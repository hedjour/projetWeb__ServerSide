<?php
    require_once PROJECT_ROOT_PATH . 'Model/UserModel.php';
    require_once PROJECT_ROOT_PATH . 'manager/InvalidEmailException.php';
    require_once PROJECT_ROOT_PATH . 'manager/InvalidPasswordException.php';

    class UserManager
    {

        /** @var string session field for whether the client is currently signed in */
        const SESSION_FIELD_LOGGED_IN = 'auth_logged_in';
        /** @var string session field for the ID of the user who is currently signed in (if any) */
        const SESSION_FIELD_USER_ID = 'auth_user_id';
        /** @var string session field for the email address of the user who is currently signed in (if any) */
        const SESSION_FIELD_EMAIL = 'auth_email';
        /** @var string session field for the display name (if any) of the user who is currently signed in (if any) */
        const SESSION_FIELD_USERNAME = 'auth_username';
        /** @var string session field for the status of the user who is currently signed in (if any) as one of the constants from the {@see Status} class */
        const SESSION_FIELD_STATUS = 'auth_status';
        /** @var string session field for the UNIX timestamp in seconds of the session data's last resynchronization with its authoritative source in the database */
        const SESSION_FIELD_LAST_RESYNC = 'auth_last_resync';
        /**
         * @var UserModel
         */
        private $userModel;


        public function __construct()
        {
            $this->userModel = new UserModel();
        }

        /**
         * @throws InvalidEmailException
         */
        protected static function validateEmailAddress($email): string
        {
            if (empty($email)) {
                throw new InvalidEmailException();
            }

            $email = \trim($email);

            if (!\filter_var($email, \FILTER_VALIDATE_EMAIL)) {
                throw new InvalidEmailException();
            }

            return $email;
        }

        /**
         * Validates a password
         *
         * @param string $password the password to validate
         * @return string the sanitized password
         * @throws InvalidPasswordException if the password has been invalid
         */
        protected static function validatePassword(string $password): string
        {
            if (empty($password)) {
                throw new InvalidPasswordException();
            }

            $password = \trim($password);

            if (\strlen($password) < 1) {
                throw new InvalidPasswordException();
            }

            return $password;
        }

        /**
         * @throws InvalidEmailException
         * @throws InvalidPasswordException
         * @throws Exception
         */
        public function createUser($username, $password, $email = null, callable $callback = null): int
        {
            \ignore_user_abort(true);

            if ($email) $email = self::validateEmailAddress($email);
            else $email = '';
            $password = self::validatePassword($password);

            $username = isset($username) ? \trim($username) : null;

            // if a username has actually been provided
            if ($username !== null) {
                // count the number of users who do already have that specified username
                $occurrencesOfUsername = $this->userModel->select(
                    'SELECT * FROM user WHERE username = ?',
                    ["s", $username]);
                // if any user with that username does already exist
                if (count($occurrencesOfUsername) > 0) {
                    // cancel the operation and report the violation of this requirement
                    throw new Exception("Username already taken");
                }
            }

            $password = \password_hash($password, \PASSWORD_BCRYPT);
            $verified = \is_callable($callback) ? 0 : 1;

            try {
                $user = $this->userModel->createUser($username, $password);
                return $user['id'];
            } catch (Exception $e) {
                echo($e->getMessage());
            }


            return -1;
        }

        /**
         * Called when a user has successfully logged in
         *
         *
         * @param int $userId the ID of the user
         * @throws Exception
         */
        protected function onLoginSuccessful(int $userId)
        {
            session_unset();

            $userData = $this->userModel->getUserById($userId);
            $userData = $this->userModel->getUserById($userId);
            // save the user data in the session variables maintained by this library
            $_SESSION[self::SESSION_FIELD_LOGGED_IN] = true;
            $_SESSION[self::SESSION_FIELD_USER_ID] = $userId;
            $_SESSION[self::SESSION_FIELD_EMAIL] = $userData['email'];
            $_SESSION[self::SESSION_FIELD_USERNAME] = $userData['username'];
            $_SESSION[self::SESSION_FIELD_LAST_RESYNC] = \time();
        }


        /**
         * Logs in the user with the given credentials
         *
         *
         * @param string $username
         * @param string $password
         * @throws Exception
         */
        public function login(string $username, string $password)
        {
            $userData = $this->userModel->getUserByUsernameAndPassword($username);
            if (!\password_verify($password, $userData[0]['password'])) {
                throw new Exception("Invalid username or password");
            }

            $this->onLoginSuccessful($userData[0]['id']);
        }

        public function logout()
        {
            session_unset();

        }


        /**
         * Updates the user's credentials
         *
         * @throws Exception
         */
        public function updateUser(string $username, string $email, string $password){
            $userId = $_SESSION[self::SESSION_FIELD_USER_ID];


            $this->userModel->updateUser($userId, $username, $email, $password);
        }
    }