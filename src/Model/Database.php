<?php

    namespace Models;
    use Exception;
    use mysqli;
    use mysqli_stmt;

    class Database
    {
        protected $connection = null;

        /**
         * @throws Exception
         */
        public function __construct()
        {
            try {
                $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

                if (mysqli_connect_errno()) {
                    throw new Exception("Could not connect to database.");
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        /**
         * Selects rows from the database
         *
         *
         * @throws Exception
         */
        public function select($query = "", $params = []): array
        {
            try {
                $stmt = $this->executeStatement($query, $params);
                $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                return $result;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        /**
         * Inserts a new row into the database.
         *
         * @param string $query
         * @param array $params
         * @return int
         * @throws Exception
         */
        public function insert(string $query = "", array $params = []): int
        {
            try {
                $stmt = $this->executeStatement($query, $params);
                $result = $stmt->insert_id;
                $stmt->close();

                return $result;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        /**
         * Updates a row in the database.
         *
         * @param string $query
         * @param array $params
         * @return int
         * @throws Exception
         */
        public function update(string $query = "", array $params = []): int
        {
            try {
                $stmt = $this->executeStatement($query, $params);
                $result = $stmt->affected_rows;
                $stmt->close();

                return $result;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        /**
         * Deletes a row from the database.
         *
         * @param string $query
         * @param array $params
         * @return int
         * @throws Exception
         */
        public function delete(string $query = "", array $params = []): int
        {
            try {
                $stmt = $this->executeStatement($query, $params);
                $result = $stmt->affected_rows;
                $stmt->close();

                return $result;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        /**
         * @throws Exception
         */
        protected function executeStatement($query = "", $params = []): mysqli_stmt
        {
            try {
                $stmt = $this->connection->prepare($query);

                if ($stmt === false) {
                    throw new Exception("Unable to do prepared statement: " . $query);
                }

                if ($params) {
                    $stmt->bind_param($params[0], ...array_slice($params, 1));
                }

                $stmt->execute();

                return $stmt;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }