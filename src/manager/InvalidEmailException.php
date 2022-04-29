<?php

    class InvalidEmailException extends Exception
    {
        public function __construct($code = 0, Exception $previous = null)
        {
            parent::__construct("Invalid Email", $code, $previous);
        }
    }