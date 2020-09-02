<?php
	/**
	 * This class represents an HTTP response. The response is directly bound to a template system which means that you
	 * put values in it, give it a view (template file) and flush the response with a status code and headers.
	 */
	class Response
	{
		protected static $statusMessages = array (100 => 'Continue',
		                                          101 => 'Switching Protocols',
		                                          200 => 'OK',
		                                          201 => 'Created',
		                                          202 => 'Accepted',
		                                          203 => 'Non-Authoritative Information',
		                                          204 => 'No Content',
		                                          205 => 'Reset Content',
		                                          206 => 'Partial Content',
		                                          300 => 'Multiple Choices',
		                                          301 => 'Moved Permanently',
		                                          302 => 'Found',
		                                          303 => 'See Other',
		                                          304 => 'Not Modified',
		                                          305 => 'Use Proxy',
		                                          307 => 'Temporary Redirect',
		                                          400 => 'Bad Request',
		                                          401 => 'Unauthorized',
		                                          402 => 'Payment Required',
		                                          403 => 'Forbidden',
		                                          404 => 'Not Found',
		                                          405 => 'Method Not Allowed',
		                                          406 => 'Not Acceptable',
		                                          407 => 'Proxy Authentication Required',
		                                          408 => 'Request Time-out',
		                                          409 => 'Conflict',
		                                          410 => 'Gone',
		                                          411 => 'Length Required',
		                                          412 => 'Precondition Failed',
		                                          413 => 'Request Entity Too Large',
		                                          414 => 'Request-URI Too Large',
		                                          415 => 'Unsupported Media Type',
		                                          416 => 'Requested range not satisfiable',
		                                          417 => 'Expectation Failed',
		                                          500 => 'Internal Server Error',
		                                          501 => 'Not Implemented',
		                                          502 => 'Bad Gateway',
		                                          503 => 'Service Unavailable',
		                                          504 => 'Gateway Time-out');

		protected $variables;

		/**
		 */
		public function __construct()
		{
			$this->variables = new Map();
		}

		/**
		 * @param string $type
		 */
		public function setContentType($type)
		{
			header('Content-type: ' . $type, true);
		}

		/**
		 * Sets or overrides a headers if it was set previously.
		 *
		 * @param string $name
		 * @param string $value
		 */
		public function setHeader($name, $value)
		{
			header($name . ': ' . $value, true);
		}

		/**
		 * Adds a header, there might be several headers with the same name.
		 *
		 * @param string $name
		 * @param string $value
		 */
		public function addHeader($name, $value)
		{
			header($name . ': ' . $value, false);
		}

		/**
		 * @param string $location
		 */
		public function sendRedirect($location)
		{
			header('Location: ' . $location, true);
		}

		/**
		 * @param int $status
		 */
		public function setStatus($status)
		{
			header('HTTP/1.1 ' . $status . ' ' . self::$statusMessages[$status], true);
		}

		/**
		 * @param string $view
		 */
		public function flush($view)
		{
			include $view;
		}

		/**
		 * @param string $key
		 * @return boolean
		 */
		public function contains($key)
		{
			return $this->variables->containsKey($key);
		}

		/**
		 * @param string $key
		 * @return mixed
		 */
		public function get($key)
		{
			return $this->variables->get($key);
		}

		/**
		 * This is a convenience method for get($key).
		 *
		 * @param string $key
		 * @return mixed
		 */
		public function __get($key)
		{
			return $this->get($key);
		}

		/**
		 * @param string $key
		 * @param mixed $value
		 */
		public function put($key, $value)
		{
			$this->variables->put($key, $value);
		}
	}
