<?php

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
            $arrQueryStringParams = $this->getQueryStringParams();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    $intLimit = 10;
                    if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                        $intLimit = $arrQueryStringParams['limit'];
                    }

                    $arrUsers = $userModel->getUsers($intLimit);
                    $responseData = json_encode($arrUsers);
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

        public function getAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $queryStringParams = $this->getQueryStringParams();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($queryStringParams['id']) and $queryStringParams['id'] !== '') {
                        $userId = $queryStringParams['id'];
                        $arrUsers = $userModel->getUserById($userId);
                        if (!($arrUsers and count($arrUsers) != 0)) {
                            $strErrorDesc = 'User not found';
                            $strErrorHeader = 'HTTP/1.1 404 Not Found';
                        } else {

                            $responseData = json_encode($arrUsers[0]);
                        }

                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
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

        public function getByUsernameAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getQueryStringParams();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($arrQueryStringParams['username']) && $arrQueryStringParams['username']) {
                        $userUsername = $arrQueryStringParams['username'];
                        $arrUsers = $userModel->getUserByUsername($userUsername);
                        if (!($arrUsers and count($arrUsers) != 0)) {
                            $strErrorDesc = 'User not found';
                            $strErrorHeader = 'HTTP/1.1 404 Not Found';
                        } else {

                            $responseData = json_encode($arrUsers[0]);
                        }

                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
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

        public function getByEmailAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getQueryStringParams();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($arrQueryStringParams['email']) && $arrQueryStringParams['email']) {
                        $userEmail = $arrQueryStringParams['email'];
                        $arrUsers = $userModel->getUserByEmail($userEmail);
                        if (!($arrUsers and count($arrUsers) != 0)) {
                            $strErrorDesc = 'User not found';
                            $strErrorHeader = 'HTTP/1.1 404 Not Found';
                        } else {

                            $responseData = json_encode($arrUsers[0]);
                        }

                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
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

        public function getMessagesAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getQueryStringParams();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                        $userId = $arrQueryStringParams['id'];
                        $arrMessages = $userModel->getMessages($userId);
                        if (!($arrMessages and count($arrMessages) != 0)) {
                            $strErrorDesc = 'User not found';
                            $strErrorHeader = 'HTTP/1.1 404 Not Found';
                        }

                        else {

                            $responseData = json_encode($arrMessages);
                        }

                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
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

        public function getChatRoomsAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getQueryStringParams();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $userModel = new UserModel();

                    if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                        $userId = $arrQueryStringParams['id'];
                        $arrChatRooms = $userModel->getChatRooms($userId);
                        if (!($arrChatRooms and count($arrChatRooms) != 0)) {
                            $strErrorDesc = 'User not found';
                            $strErrorHeader = 'HTTP/1.1 404 Not Found';
                        } else {

                            $responseData = json_encode($arrChatRooms);
                        }

                    } else {
                        $strErrorDesc = 'Arguments missing or invalid';
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

        /**
         * Create a new User with POST method
         */
        public function createUserAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getQueryStringParams();

            if (strtoupper($requestMethod) == 'POST') {
                try {
                    $userManager = new UserManager();
                    try {
                        $userManager->createUser($arrQueryStringParams['name'], $arrQueryStringParams['password']);
                        $responseData = json_encode(array('success' => 'User created'));

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

        /**
         * Login the user with POST method
         *
         */
        public function loginUserAction(){
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getQueryStringParams();

            if (strtoupper($requestMethod) == 'POST') {
                try {
                    $userManager = new UserManager();
                    try {
                        $userManager->login($arrQueryStringParams['name'], $arrQueryStringParams['password']);
                        $responseData = json_encode(array('success' => 'User logged in'));

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

        /**
         * Logout the user with POST method
         *
         */

        public function logoutAction(){
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

        /**
         * Update the user with PUT method
         *
         */
        public function updateAction(){
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];

            if (strtoupper($requestMethod) == 'PUT') {
                try {
                    $userManager = new UserManager();
                    try {
//                        $userManager-);
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
    