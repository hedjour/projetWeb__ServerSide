<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";

    class UserModel extends Database
    {
        /**
         * @throws Exception
         */
        public function getUsers($limit): array
        {
            return $this->select("SELECT 
                                            id,
                                            username,
                                            firstname,
                                            email,
                                            surname,
                                            date_joined,
                                            last_login,
                                            is_active,
                                            profile_picture
                                        FROM 
                                            user 
                                        ORDER BY 
                                            id 
                                        LIMIT 
                                            ?",
                ["i", $limit]);
        }
    }