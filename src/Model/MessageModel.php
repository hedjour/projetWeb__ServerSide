<?php

    namespace Models;
    require_once PROJECT_ROOT_PATH . 'Model/Database.php';

    use Cassandra\Date;
    use Database\Exceptions\DatabaseError;
    use Exception;

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
         * modify a message
         *
         * @param int $msgId The id of the message to modify
         * @param string $content The modified content
         * @return int the id of the updated message
         * @throws Exception If the message doesn't exist
         */
        public function modifyMessage(int    $msgId, string $content = ""): int
        {
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