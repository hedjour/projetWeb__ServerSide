<?php

    namespace Models;
    require_once PROJECT_ROOT_PATH . 'Model/Database.php';

    use Auth\Exceptions\InvalidEmailException;
    use Auth\Exceptions\InvalidPasswordException;
    use Auth\Exceptions\NotLoggedInException;
    use Auth\Exceptions\UserAlreadyExistException;
    use Auth\Exceptions\UserDoesNotExistException;
    use Cassandra\Exception\UnauthorizedException;
    use Database\Exceptions\DatabaseError;
    use Exception;
    use Managers\UserManager;

    class UserModel extends Database
    {
        const USER_TABLE = "users";
        const USER_FIELDS = "id, username,firstname, email, surname, date_joined, password, last_login, is_active, profile_picture";
        const USER_FIELDS_SAFE = "id, username,firstname, email, surname, date_joined, last_login, is_active, profile_picture";


        /**
         * Get all users
         *
         * @param $limit int The number of users to get
         * @return array
         * @throws DatabaseError
         */

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
         * @throws UserDoesNotExistException If the user doesn't exist
         */
        public function getUserById(int $id): array
        {
            try {
                return $this->select("SELECT 
                                            " . $this::USER_FIELDS_SAFE . "
                                        FROM 
                                            user 
                                        WHERE 
                                            id = ?",
                    ["i", $id]);
            } catch (DatabaseError $e) {
                throw new UserDoesNotExistException("User with ID " . $id . " does not exist");
            }
        }

        /**
         * @param string $username The username of the user to get
         * @return array The user's details
         * @throws UserDoesNotExistException If the user does not exist
         */
        public function getUserByUsername(string $username): array
        {
            try {
                return $this->select("SELECT 
                                            " . $this::USER_FIELDS_SAFE . "
                                        FROM 
                                            user 
                                        WHERE 
                                            username = ?",
                    ["s", $username]);
            } catch (DatabaseError $e) {
                throw new UserDoesNotExistException("User with username $username does not exist");
            }

        }

        /**
         * get a user by their email
         *
         * @param $userEmail string The email of the user to get
         * @return array The user
         * @throws UserDoesNotExistException If the user doesn't exist
         */
        public function getUserByEmail(string $userEmail): array
        {
            try {
                return $this->select("SELECT 
                                            " . $this::USER_FIELDS_SAFE . "
                                        FROM 
                                            user 
                                        WHERE 
                                            email = ?",
                    ["s", $userEmail]);
            } catch (DatabaseError $e) {
                throw new UserDoesNotExistException("User with email " . $userEmail . " does not exist");
            }

        }

        /**
         * Get a user by their username and password
         * @param $username string The username of the user to get
         * @return array The user
         * @throws UserDoesNotExistException
         */
        public function getUserByUsernameAndPassword(string $username): array
        {
            try {

                return $this->select("SELECT 
                                            " . $this::USER_FIELDS . "
                                        FROM 
                                            user 
                                        WHERE 
                                            username = ?",
                    ["s", $username]);
            } catch (DatabaseError $e) {
                throw new UserDoesNotExistException("User with username " . $username . " does not exist");
            }
        }

        /**
         * Verify that a user's email is unique and valid
         * @param $email string The email to check
         * @return bool True if the email is unique and valid
         * @throws UserAlreadyExistException If the email is already in use
         * @throws InvalidEmailException If the email is not valid
         */
        public function verifyEmail(string $email): bool
        {
            // count the number of users who do already have that specified email
            try {
                $occurrencesOfEmail = $this->select(
                    'SELECT * FROM user WHERE email = ?',
                    ["s", $email]);
            } catch (DatabaseError $e) {
                throw new UserAlreadyExistException("User with email " . $email . " already exists");
            }
            // if any user with that email does already exist
            if (count($occurrencesOfEmail) > 0) {
                // cancel the operation and report the violation of this requirement
                throw new UserAlreadyExistException("A user with the email $email already exists");
            }
            // check if the email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // cancel the operation and report the violation of this requirement
                throw new InvalidEmailException("The email $email is not valid");
            }
            // if no user with that email does already exist and the email is valid
            return true;
        }

        /**
         * Verify that a user's username is unique and valid
         * @param string $username The username to check
         * @return bool True if the username is unique and valid
         * @throws UserAlreadyExistException If the username is already in use
         */
        public function verifyUsername(string $username): bool
        {

            // count the number of users who do already have that specified username
            try {
                $occurrencesOfUsername = $this->select(
                    'SELECT * FROM user WHERE username = ?',
                    ["s", $username]);
            } catch (DatabaseError $e) {
                throw new UserAlreadyExistException("A user with the username $username already exists Database Error");
            }
            // if any user with that username does already exist
            if (count($occurrencesOfUsername) > 0) {
                // cancel the operation and report the violation of this requirement
                throw new UserAlreadyExistException("A user with the username $username already exists");
            }
            // if no user with that username does already exist
            return true;
        }

        /**
         * Validate a user's password
         * @param string $password The password to check
         * @return bool True if the password is valid
         * @throws InvalidPasswordException If the password is not valid
         */

        public function validatePassword(string $password): bool
        {
            // check if the password is valid
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
                // cancel the operation and report the violation of this requirement
                throw new InvalidPasswordException("The password $password is not valid");
            }
            // if the password is valid
            return true;
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
         * @throws InvalidEmailException
         * @throws InvalidPasswordException
         * @throws UserAlreadyExistException
         */
        public function createUser(string $username, string $password, string $firstname = null, string $surname = null,
                                   string $email = null, string $profilePicture = null): int
        {
            // check if the user already exists
            $this->verifyUsername($username);
            $this->verifyEmail($email);
            // validate the password
            $this->validatePassword($password);
            // create the user
            try {
                return $this->insert("INSERT INTO user (username, password, firstname, surname, email, profile_picture) 
                                VALUES (?, ?, ?, ?, ?, ?)",
                    ["ssssss", $username, \password_hash($password, \PASSWORD_BCRYPT), $firstname, $surname, $email, $profilePicture]);
            } catch (DatabaseError $e) {
                throw new UserAlreadyExistException("User with username $username already exists");
            }
        }

        /**
         * update a user
         *
         * @param int $userId The id of the user to update
         * @param string|null $username The username of the user to update
         * @param string|null $firstname The firstname of the user to update
         * @param string|null $surname The surname of the user to update
         * @param string|null $email The email of the user to update
         * @param string|null $profilePicture The profile picture of the user to update
         * @return int the id of the updated user
         * @throws InvalidEmailException If the email is not valid
         * @throws NotLoggedInException If the user is not logged in
         * @throws UserAlreadyExistException If the username is already in use
         * @throws UserDoesNotExistException If the user does not exist
         */
        public function updateUser(int    $userId,
                                   string $username = null,
                                   string $firstname = null,
                                   string $surname = null,
                                   string $email = null,
                                   string $profilePicture = null): int
        {
            $userManager = new UserManager();
            if ($userManager->getLoggedInUserId() != $userId) {
                throw new UnauthorizedException("You are not allowed to modify this user",
                    403,
                    "Unauthorized");
            }
            $fields = "";
            $params = [""];
            if ($username !== null && $this->verifyUsername($username)) {
                $fields .= "username = ?,";
                $params[] = $username;
                $params[0] = $params[0] . "s";

            }
            if ($firstname !== null) {
                $fields .= "firstname = ?,";
                $params[] = $firstname;
                $params[0] = $params[0] . "s";
            }
            if ($surname !== null) {
                $fields .= "surname = ?,";
                $params[] = $surname;
                $params[0] = $params[0] . "s";
            }
            if ($email !== null && $this->verifyEmail($email)) {
                $fields .= "email = ?,";
                $params[] = $email;
                $params[0] = $params[0] . "s";
            }
            if ($profilePicture !== null) {
                $fields .= "profile_picture = ?,";
                $params[] = $profilePicture;
                $params[0] = $params[0] . "s";
            }
            $fields = substr($fields, 0, -1);
            $params[0] = $params[0] . "i";
            $params[] = $userId;
            try {
                return $this->update("UPDATE user SET " . $fields . " WHERE id = ?", $params);
            } catch (DatabaseError $e) {
                throw new UserDoesNotExistException("User with ID " . $userId . " does not exist");
            }
        }

        /**
         * Update the password of a user
         * @param int $userId The id of the user to update
         * @param string $password The new password of the user to update
         *
         * @throws NotLoggedInException If the user is not logged in
         * @throws InvalidPasswordException If the password is not valid
         * @throws UserDoesNotExistException If the user does not exist
         */
        public function updatePassword(int $userId, string $password): void
        {
            $userManager = new UserManager();
            if ($userManager->getLoggedInUserId() != $userId) {
                throw new UnauthorizedException("You are not allowed to modify this user",
                    403,
                    "Unauthorized");
            }
            if ($this->validatePassword($password)) {
                try {
                    $this->update("UPDATE user SET password = ? WHERE id = ?", ["ss", $password, $userId]);
                } catch (DatabaseError $e) {
                    throw new UserDoesNotExistException("User with ID " . $userId . " does not exist");
                }
            }
        }


        /**
         * delete a user if the user is logged in
         *
         * @param int $userId The id of the user to delete
         * @return int the id of the deleted user
         * @throws UserDoesNotExistException If the user doesn't exist
         * @throws NotLoggedInException if the user is not logged in
         *
         */
        public function deleteUser(int $userId): int
        {
            $userManager = new UserManager();
            if ($userManager->getLoggedInUserId() != $userId) {
                throw new UnauthorizedException("You are not allowed to delete this user",
                    403,
                    "Unauthorized");
            }
            try {
                return $this->delete("DELETE FROM user WHERE id = ?", ["i", $userId]);
            } catch (DatabaseError $e) {
                throw new UserDoesNotExistException("User doesn't exist", 404, DatabaseError::$NOT_FOUND);
            }
        }


        /**
         * Get the rooms of a user by their id if the user is logged in
         *
         *
         * @param int $userId
         * @return array The rooms of the user
         * @throws NotLoggedInException If the user is not logged in
         * @throws UserDoesNotExistException If the user doesn't exist
         * @throws UnauthorizedException If the user is not allowed to view the rooms
         */
        public function getChatRooms(int $userId): array
        {
            $userManager = new UserManager();
            if ($userManager->getLoggedInUserId() != $userId) {
                throw new UnauthorizedException("You are not allowed to see this user's rooms",
                    403,
                    "Unauthorized");
            }
            try {
                return $this->select("
                                        SELECT 
                                            chat_room.id,
                                            chat_room.name
                                        FROM chat_room
                                        INNER JOIN chat_room_user
                                        ON chat_room.id = chat_room_user.chat_room_id
                                        WHERE chat_room_user.user_id = ?
                                        ORDER BY chat_room.id;", ["i", $userId]);
            } catch (DatabaseError $e) {
                throw new UserDoesNotExistException("User doesn't exist", 404, DatabaseError::$NOT_FOUND);
            }
        }

        /**
         * Get the messages of a user if the user is logged in and the room is in the user's rooms
         * and the room is not private else throw an exception
         *
         *
         * @param int $userId The id of the user
         * @return array The messages of the user
         * @throws Exception If the user does not exist
         */
        public function getMessages(int $userId): array
        {
            $userManager = new UserManager();
            if ($userManager->getLoggedInUserId() != $userId) {
                throw new UnauthorizedException("You are not allowed to see this room",
                    403,
                    "Unauthorized");
            }
            try {

                return $this->select("
                                        SELECT 
                                            message.id,
                                            message.user_id,
                                            message.chat_room_id,
                                            message.content,
                                            message.sent_date
                                        FROM message
                                        INNER JOIN user
                                        ON message.user_id = user.id
                                        WHERE message.chat_room_id = ?
                                        ORDER BY message.sent_date", ["i", $userId]);
            } catch (DatabaseError $e) {
                throw new UserDoesNotExistException("User doesn't exist", 404, DatabaseError::$NOT_FOUND);
            }
        }
    }