<?php

    namespace Models;
    require_once PROJECT_ROOT_PATH . 'Model/Database.php';

    use Auth\Exceptions\NotAuthorizedException;
    use Cassandra\Date;
    use Database\Exceptions\DatabaseError;
    use Exception;
    use Managers\UserManager;

    class MessageModel extends Database
    {
        /**
         * Get all messages
         *
         * @param $limit int The number of messages to get
         * @return array
         * @throws Exception
         */
        public function getMessages(int $limit): array
        {
                return $this->select("SELECT 
                                            *
                                        FROM 
                                            message 
                                        ORDER BY 
                                            sent_date
                                        LIMIT 
                                            ?",
                    ["i", $limit]);
        }

        /**
         * Get a message by their ID
         * @param $id int The ID of the message to get
         * @return array The message details
         * @throws Exception If the message doesn't exist
         */
        public function getMessageById(int $id): array
        {
            return $this->select("SELECT 
                                            *
                                        FROM 
                                            message 
                                        WHERE 
                                            id = ?",
                ["i", $id]);
        }

        /**
         * get all messages which content is $content    exact match for the moment TODO change
         * @param string $content The content of the message
         * @return array The user's details
         * @throws Exception If the message does not exist
         */
        public function getMessageByContent(string $content): array
        {
            return $this->select("SELECT 
                                            *
                                        FROM 
                                            message 
                                        WHERE 
                                            content = ?",
                ["s", $content]);
        }

        /**
         * get all messages which dates is $datesent    exact match for the moment TODO change
         * @param Date $dateSent
         * @return array
         * @throws DatabaseError
         */
        public function getMessageByDateSent(date $dateSent): array
        {
            return $this->select("SELECT 
                                            *
                                        FROM 
                                            message 
                                        WHERE 
                                            sent_date = ?",
                ["s", $dateSent]);
        }

        /**
         * Create a new message in the database with the current datetime
         *
         * @param $content string The content of the message
         * @param $userId int The ID of the user who sent the message
         * @param $chatRoomId int The ID of the chat room the message was sent in
         *
         * @throws Exception
         */
        public function createMessage(string $content, int $userId, int $chatRoomId): int
        {
            $userManager = new UserManager();
            if ($userManager->getLoggedInUserId() != $userId) {
                throw new NotAuthorizedException();
            }
            return $this->insert("INSERT INTO message (content, user_id, chat_room_id, sent_date) VALUES (?, ?, ?, ?)",
                ["s", $content, "i", $userId, "i", $chatRoomId, "d", date("Y-m-d H:i:s")]);
        }



        /**
         * modify a message
         *
         * @param int $msgId The id of the message to modify
         * @param string $content The modified content
         * @return int the id of the updated message
         * @throws Exception If the message doesn't exist
         */
        public function modifyMessage(int    $msgId, string $content = ""): int
        {
            $userManager = new UserManager();
            if ($userManager->getLoggedInUserId() != self::getMessageById($msgId)["user_id"]) {
                throw new NotAuthorizedException();
            }
            return $this->update("UPDATE message SET content = ? WHERE id = ?",
                ["si", $content, $msgId]);
        }

        /**
         * delete a message
         *
         * @param int $msgId The id of the message to delete
         * @return int the id of the deleted user
         * @throws Exception If the message doesn't exist
         */
        public function deleteMessage(int $msgId): int
        {
            return $this->delete("DELETE FROM message WHERE id = ?", ["i", $msgId]);
        }
    }