<?php

    namespace Models;
    require_once PROJECT_ROOT_PATH . 'Model/Database.php';

use Exception;

    class PixelModel extends Database
    {
        /**
         * Get adjacent pixels
         *
         * @param $limit int The number of pixels to get
         * @return array
         * @throws Exception
         */
        public function getPixels(int $limit=null, int $beginning=0): array
        {

                return $this->select("SELECT 
                                            *
                                        FROM 
                                            pixels 
                                        ORDER BY 
                                            id
                                        WHERE 
                                            id >= ?
                                        LIMIT 
                                            ?",
                    ["i", $limit, $beginning]);
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
         * get all pixels which datesent is $datesent    exact match for the moment TODO change
         * @param string $datesent The date of the pixel to match
         * @return array The pixel's details
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
                ["d", $datesent]);
        }

        /**
         * get all pixels which datesent is over $date
         * @param string $date The date to compare
         * @return array The pixel's details
         * @throws Exception If the pixel does not exist
         */
        public function getPixelSentAfterDate(string $date): array
        {
            return $this->select("SELECT 
                                            *
                                        FROM 
                                            pixel 
                                        WHERE 
                                            datesent >= ?",
                ["d", $date]);
        }

        /**
         * modify a pixel
         *
         * @param int $msgId The id of the pixel to modify
         * @param string $content The modified content
         * @return int the id of the updated pixel
         * @throws Exception If the pixel doesn't exist
         */
        public function modifyPixel(int $msgId, string $content = ""): int
        {
            return $this->update("UPDATE pixel SET color = ? WHERE id = ?",
                ["ii", $content, $msgId]);
        }

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


        protected function generateSafeFields(): array
        {
            // TODO: Implement generateSafeFields() method.
        }

        protected function generateFields(): array
        {
            // TODO: Implement generateFields() method.
        }
    }

