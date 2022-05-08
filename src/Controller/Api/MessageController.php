<?php

    namespace Controllers;

    use Exception;
    use Models\MessageModel;

    class MessageController extends BaseController
    {
        public function listAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $messageModel = new MessageModel();

                    $intLimit = 10;
                    if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                        $intLimit = $arrQueryStringParams['limit'];
                    }

                    $arrMessage = $messageModel->getMessages($intLimit);
                    $responseData = json_encode($arrMessage);
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

        public function getByIdAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $messageModel = new MessageModel();

                    $messageId = 10;        // ???? TODO change this
                    if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                        $messageId = $arrQueryStringParams['id'];
                    }

                    $arrMessage = $messageModel->getMessageById($messageId);
                    $responseData = json_encode($arrMessage);
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

        /*
         * get chat room messages
         * 
         * 
         */
        public function getMessagesAction()
        {
            $strErrorDesc = '';
            $responseData = array();
            $strErrorHeader = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $arrQueryStringParams = $this->getGETData();

            if (strtoupper($requestMethod) == 'GET') {
                try {
                    $messageModel = new MessageModel();

                    $messageId = null;
                    $limit = 10;
                    if (isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']) {
                        if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                            $limit = $arrQueryStringParams['limit'];
                        }
                        $messageId = $arrQueryStringParams['id'];
                    }

                    $arrMessage = $messageModel->getMessages($messageId, $limit);
                    $responseData = json_encode($arrMessage);
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