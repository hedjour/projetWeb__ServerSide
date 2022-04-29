<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";

    class ChatRoomModel extends Database
    {
        /**
         * Get all chat rooms
         *
         * @param $limit int The number of chat rooms to get
         * @return array
         * @throws Exception
         */
        public function getChatRooms(int $limit): array
        {
            return $this->select("SELECT 
                                            *
                                        FROM 
                                            chat_room 
                                        ORDER BY 
                                            id 
                                        LIMIT 
                                            ?",
                ["i", $limit]);
        }

        /**
         * Get the users of a chat room
         *
         * @param int $chatRoomId The id of the chat room
         * @return array The messages of the chat room
         * @throws Exception If the chat room does not exist
         */
        public function getUsers(int $chatRoomId): array
        {
            return $this->select("SELECT user.id,
                                               user.username,
                                               user.firstname,
                                               user.email,
                                               user.surname,
                                               user.date_joined,
                                               user.last_login,
                                               user.is_active,
                                               user.profile_picture
                                        FROM user
                                        INNER JOIN chat_room_user
                                        ON user.id = chat_room_user.user_id
                                        WHERE chat_room_user.chat_room_id = ?
                                        ORDER BY user.id
                                        ", ["i", $chatRoomId]);
        }

        /**
         * Get the messages of a chat room
         *
         * @param int $chatRoomId The id of the chat room
         * @param int $limit The number of messages to get
         * @return array The messages of the chat room
         * @throws Exception If the chat room does not exist
         */
        public function getMessages(int $chatRoomId, int $limit): array
        {
            return $this->select("SELECT * 
                                        FROM message 
                                        WHERE chat_room_id = ? 
                                        ORDER BY sent_date DESC 
                                        LIMIT ?
                                        ", ["i", $chatRoomId, "i", $limit]);
        }

        /**
         * Get the chat room with the given id
         *
         * @param int $chatRoomId The id of the chat room
         * @return array The chat room
         * @throws Exception If the chat room does not exist
         */
        public function getChatRoom(int $chatRoomId): array
        {
            return $this->select("SELECT * 
                                        FROM chat_room
                                        WHERE id = ?
                                        ", ["i", $chatRoomId]);
        }

        /**
         * Get the chat rooms with the given name
         *
         * @param string $chatRoomName The name of the chat room
         * @return array The chat rooms
         * @throws Exception If the chat room does not exist
         */
        public function getChatRoomByName(string $chatRoomName): array
        {
            return $this->select("SELECT * 
                                        FROM chat_room 
                                        WHERE name = ?
                                        ", ["s", $chatRoomName]);
        }

        /**
         * Create a chat room
         *
         * @param string $chatRoomName The name of the chat room
         *
         * @return array The chat room
         * @throws Exception If the chat room does not exist
         */
        public function createChatRoom(string $chatRoomName): array
        {
            return $this->select("INSERT INTO 
                                        chat_room (name) 
                                        VALUES (?)
                                        ", ["s", $chatRoomName]);
        }


    }