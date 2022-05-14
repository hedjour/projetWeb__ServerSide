<?php

    namespace Controllers;

    use Auth\Exceptions\NotLoggedInException;
    use Auth\Exceptions\WrongCredentialsException;
    use Exception;
    use Managers\UserManager;
    use Models\UserModel;

    class UserController extends BaseController
    {
        /**
         * "/user/list" Endpoint - Get list of users
         */
        public function listAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();
                    (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) ? $intLimit = $arrQueryStringParams['limit'] : $intLimit = 10;
                    // $intLimit = 10;
                    // if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    //     $intLimit = $arrQueryStringParams['limit'];
                    // }

                    $arrUsers = $userModel->getUsers($intLimit);
                    $responseData = json_encode($arrUsers);
                } catch (Exception $e) {
                    self::treatBasicExceptions($e);
                    return;

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function getAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $queryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($queryStringParams['id']) and $queryStringParams['id'] !== '') {
                        $userId = $queryStringParams['id'];
                        $arrUsers = $userModel->getUserById($userId);
                        $responseData = json_encode($arrUsers);


                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
                        $strErrorHeader = 'HTTP/1.1 418 Bad Request';
                    }


                } catch (Exception $e) {
                    self::treatBasicExceptions($e);
                    return;

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function getByUsernameAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($arrQueryStringParams['username']) && $arrQueryStringParams['username']) {
                        $userUsername = $arrQueryStringParams['username'];
                        $user = $userModel->getUserByUsername($userUsername);
                        $responseData = json_encode($user);

                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
                        $strErrorHeader = 'HTTP/1.1 418 Bad Request';
                    }


                } catch (Exception $e) {
                    self::treatBasicExceptions($e);
                    return;

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function getByEmailAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($arrQueryStringParams['email']) && $arrQueryStringParams['email']) {
                        $userEmail = $arrQueryStringParams['email'];
                        $user = $userModel->getUserByEmail($userEmail);
                        $responseData = json_encode($user);

                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
                        $strErrorHeader = 'HTTP/1.1 418 Bad Request';
                    }

                } catch (Exception $e) {
                    self::treatBasicExceptions($e);
                    return;

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function getMessagesAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                        $userId = $arrQueryStringParams['id'];
                        $arrMessages = $userModel->getMessages($userId);
                        $responseData = json_encode($arrMessages);
                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
                        $strErrorHeader = 'HTTP/1.1 418 Bad Request';
                    }

                } catch (Exception $e) {
                    self::treatBasicExceptions($e);
                    return;

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function getChatRoomsAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                        $userId = $arrQueryStringParams['id'];
                        $arrChatRooms = $userModel->getChatRooms($userId);
                        $responseData = json_encode($arrChatRooms);

                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
                        $strErrorHeader = 'HTTP/1.1 418 Bad Request';
                    }

                } catch (Exception $e) {
                    self::treatBasicExceptions($e);
                    return;
                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        /**
         * Create a new User with POST method
         */
        public function createUserAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getPOSTData();

            if (strtoupper($requestMethod) == 'POST') {
                try {
                    $userManager = new UserManager();
                    $userManager->createUser($arrQueryStringParams['username'], $arrQueryStringParams['password']);
                    $responseData = json_encode(array('success' => 'User created'));


                } catch (Exception $e) {
                    self::treatBasicExceptions($e);
                    return;

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        /**
         * Login the user with POST method
         *
         */
        public function loginAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $postData = $this->getPOSTData();
            if (strtoupper($requestMethod) == 'POST') {
                try {
                    $userManager = new UserManager();

                    if (isset($postData['username']) && isset($postData['password'])) {
                        $userManager->login($postData['username'], $postData['password']);
                        $responseData = json_encode(array('success' => 'User logged in'));
                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
                        $strErrorHeader = 'HTTP/1.1 400 Bad Request';
                    }

                } catch (Exception $e) {
                    self::treatBasicExceptions($e);
                    return;

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        /**
         * Logout the user with POST method
         *
         */

        public function logoutAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];

            if (strtoupper($requestMethod) == 'POST') {
                try {
                    $userManager = new UserManager();
                    try {
                        $userManager->logout();
                        $responseData = json_encode(array('success' => 'User logged out'));
                    } catch (NotLoggedInException $e) {
                        $strErrorDesc = 'User not logged in';
                        $strErrorHeader = 'HTTP/1.1 401 Unauthorized';
                    } catch (Exception $e) {
                        $strErrorDesc = $e->getMessage();
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }

                } catch (Exception $e) {
                    $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        /**
         * Update the user with PUT method
         *
         */
        public function updateAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];

            if (strtoupper($requestMethod) == 'PUT') {
                try {
                    $userManager = new UserManager();
                    try {
                        #TODO update user
                        $userManager->updateUser($this->getPOSTData());
                        $responseData = json_encode(array('success' => 'User updated'));

                    } catch (Exception $e) {
                        $strErrorDesc = 'Arguments missing or invalid' . $e->getMessage();
                        $strErrorHeader = 'HTTP/1.1 418 Bad Request';
                    }

                } catch (Exception $e) {
                    $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';

                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

    }
