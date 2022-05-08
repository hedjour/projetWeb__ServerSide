<?php


    namespace Auth\Exceptions;

    use Exception;

    class NotAuthorizedException extends Exception
    {
        public function __construct()
        {
            parent::__construct('Not authorized', 401);
        }
    }
