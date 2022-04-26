<?php


    class BaseController
    {
        /**
         * __call magic method.
         */
        public function __call($name, $arguments)
        {
            $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
        }

        /**
         * Get URI elements.
         *
         * @return array
         */
        protected function getUriSegments(): array
        {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            return explode('/', $uri);
        }

        /**
         * Get querystring params.
         *
         */
        protected function getQueryStringParams(): array
        {
            $query = array();
            parse_str($_SERVER['QUERY_STRING'], $query);
            return $query;
        }

        /**
         * Send API output.
         *
         * @param string $data
         * @param array $httpHeaders
         */
        protected function sendOutput(string $data, array $httpHeaders = array()): void
        {
            header_remove('Set-Cookie');

            if (is_array($httpHeaders) && count($httpHeaders)) {
                foreach ($httpHeaders as $httpHeader) {
                    header($httpHeader);
                }
            }

            echo $data;

            exit;
        }
    }