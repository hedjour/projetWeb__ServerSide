<?php

    namespace Models;
    require_once PROJECT_ROOT_PATH . 'Model/Database.php';

use Exception;

    class PixelModel extends Database
    {
        /**
         * Get all pixels
         *
         * @param $limit int The number of pixels to get
         * @return array
         * @throws Exception
         */
        public function getPixels(int $limit): array
        {
                return $this->select("SELECT 
                                            *
                                        FROM 
                                            pixels 
                                        ORDER BY 
                                            sent_date
                                        LIMIT 
                                            ?",
                    ["i", $limit]);
        }

        /**
         * Get a pixel by their ID
         * @param $id int The ID of the pixel to get
         * @return array The pixel details
         * @throws Exception If the pixel doesn't exist
         */
        public function getPixelById(int $id): array
        {
            return $this->select("SELECT 
                                            *
                                        FROM 
                                            pixel 
                                        WHERE 
                                            id = ?",
                ["i", $id]);
        }

        /**
         * get all pixels which content is $content    exact match for the moment TODO change
         * @param string $content The content of the pixel
         * @return array The user's details
         * @throws Exception If the pixel does not exist
         */
        public function getPixelByContent(string $content): array
        {
            return $this->select("SELECT 
                                            *
                                        FROM 
                                            pixel 
                                        WHERE 
                                            content = ?",
                ["s", $content]);
        }

        /**
         * get all pixels which datesent is $datesent    exact match for the moment TODO change
         * @param string $content The content of the pixel
         * @return array The user's details
         * @throws Exception If the pixel does not exist
         */
        public function getPixelByDatesent(string $datesent): array
        {
            return $this->select("SELECT 
                                            *
                                        FROM 
                                            pixel 
                                        WHERE 
                                            datesent = ?",
                ["s", $datesent]);
        }

        /**
         * modify a pixel
         *
         * @param int $msgId The id of the pixel to modify
         * @param string $content The modified content
         * @return int the id of the updated pixel
         * @throws Exception If the pixel doesn't exist
         */
        public function modifyPixel(int    $msgId, string $content = ""): int
        {
            return $this->update("UPDATE pixel SET content = ? WHERE id = ?",
                ["ssssssi", $content, $msgId]);
        }       // TODO apoorva check ^

        /**
         * delete a pixel
         *
         * @param int $msgId The id of the pixel to delete
         * @return int the id of the deleted user
         * @throws Exception If the pixel doesn't exist
         */
        public function deletePixel(int $msgId): int
        {
            return $this->delete("DELETE FROM pixel WHERE id = ?", ["i", $msgId]);
        }
    }