<?php


    namespace Auth\Exceptions;

    use Exception;

    class UserDoesNotExistException extends Exception
    {
        public function __construct()
        {
            parent::__construct('User does not exist', 404);
        }
    }
