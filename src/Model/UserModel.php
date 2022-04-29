<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";

    class UserModel extends Database
    {
        /**
         * Get all users
         *
         * @param $limit int The number of users to get
         * @return array
         * @throws Exception
         */

        const USER_TABLE = "users";
        const USER_FIELDS = "id, username,firstname, email, surname, date_joined, password, last_login, is_active, profile_picture";
        const USER_FIELDS_SAFE = "id, username,firstname, email, surname, date_joined, password, last_login, is_active, profile_picture";

        public function getUsers(int $limit): array
        {
            return $this->select("SELECT 
                                            " . $this::USER_FIELDS_SAFE . "
                                        FROM 
                                            user 
                                        ORDER BY 
                                            id 
                                        LIMIT 
                                            ?",
                ["i", $limit]);
        }

        /**
         * Get a user by their ID
         * @param $id int The ID of the user to get
         * @return array The user details
         * @throws Exception If the user doesn't exist
         */
        public function getUserById(int $id): array
        {
            return $this->select("SELECT 
                                            " . $this::USER_FIELDS_SAFE . "
                                        FROM 
                                            user 
                                        WHERE 
                                            id = ?",
                ["i", $id]);
        }

        /**
         * @param string $username The username of the user to get
         * @return array The user's details
         * @throws Exception If the user does not exist
         */
        public function getUserByUsername(string $username): array
        {
            return $this->select("SELECT 
                                            " . $this::USER_FIELDS_SAFE . "
                                        FROM 
                                            user 
                                        WHERE 
                                            username = ?",
                ["s", $username]);
        }

        /**
         * get a user by their email
         *
         * @param $userEmail string The email of the user to get
         * @return array The user
         * @throws Exception If the user doesn't exist
         */
        public function getUserByEmail($userEmail): array
        {
            return $this->select("SELECT 
                                            " . $this::USER_FIELDS_SAFE . "
                                        FROM 
                                            user 
                                        WHERE 
                                            email = ?",
                ["s", $userEmail]);
        }

        /**
         * Get a user by their username and password
         * @param $username string The username of the user to get
         * @param $password string The password of the user to get
         * @return array The user
         * @throws Exception
         */
        public function getUserByUsernameAndPassword(string $username): array
        {
            return $this->select("SELECT 
                                            " . $this::USER_FIELDS . "
                                        FROM 
                                            user 
                                        WHERE 
                                            username = ?",
                ["s", $username]);
        }

        /**
         * create a new user
         *
         *
         * @param string $username The username of the user to create
         * @param string $password The password of the user to create
         * @param string|null $firstname The firstname of the user to create
         * @param string|null $surname The surname of the user to create
         * @param string|null $email The email of the user to create
         * @param string|null $profilePicture The profile picture of the user to create
         * @return int the id of the new user
         * @throws Exception If the user already exists
         */
        public function createUser(string $username, string $password, string $firstname = null, string $surname = null,
                                   string $email = null, string $profilePicture = null): int
        {
            return $this->insert("INSERT INTO user (username, password, firstname, surname, email, profile_picture) 
                            VALUES (?, ?, ?, ?, ?, ?)",
                ["ssssss", $username, $password, $firstname, $surname, $email, $profilePicture]);
        }

        /**
         * update a user
         *
         * @param int $userId The id of the user to update
         * @param string|null $username The username of the user to update
         * @param string|null $password The password of the user to update
         * @param string|null $firstname The firstname of the user to update
         * @param string|null $surname The surname of the user to update
         * @param string|null $email The email of the user to update
         * @param string|null $profilePicture The profile picture of the user to update
         * @return int the id of the updated user
         * @throws Exception If the user doesn't exist
         */
        public function updateUser(int    $userId,
                                   string $username = null,
                                   string $password = null,
                                   string $firstname = null,
                                   string $surname = null,
                                   string $email = null,
                                   string $profilePicture = null): int
        {
            return $this->update("UPDATE user SET username = ?, password = ?, firstname = ?, surname = ?, email = ?, profile_picture = ? 
                            WHERE id = ?",
                ["ssssssi", $username, $password, $firstname, $surname, $email, $profilePicture, $userId]);
        }


        /**
         * delete a user
         *
         * @param int $userId The id of the user to delete
         * @return int the id of the deleted user
         * @throws Exception If the user doesn't exist
         */
        public function deleteUser(int $userId): int
        {
            return $this->delete("DELETE FROM user WHERE id = ?", ["i", $userId]);
        }


        /**
         * Get the rooms of a user
         *
         *
         * @param int $userId
         * @return array The rooms of the user
         * @throws Exception If the user does not exist
         */
        public function getChatRooms(int $userId): array
        {
            return $this->select("SELECT chat_room.id, chat_room.name
                                        FROM chat_room
                                        INNER JOIN chat_room_user
                                        ON chat_room.id = chat_room_user.chat_room_id
                                        WHERE chat_room_user.user_id = ?
                                        ORDER BY chat_room.id;", ["i", $userId]);
        }

        /**
         * Get the messages of a user
         *
         * @param int $userId The id of the user
         * @return array The messages of the user
         * @throws Exception If the user does not exist
         */
        public function getMessages(int $userId): array
        {
            return $this->select("SELECT message.id, message.id, message.user_id, message.chat_room_id, message.content, message.sent_date
                                        FROM message
                                        INNER JOIN user
                                        ON message.user_id = user.id
                                        WHERE message.chat_room_id = ?
                                        ORDER BY message.sent_date", ["i", $userId]);
        }


    }