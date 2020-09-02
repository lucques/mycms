<?php
	/**
	 * If an object of this class is created, a session is started and the default settings how to handle sessions are
	 * used (cookies, url rewriting). It is possible to map values to the session. This session only should be created
	 * once.
	 */
	class Session
	{
		/**
		 */
		public function __construct()
		{
			session_start();
		}

		/**
		 * @param string $name
		 * @return boolean
		 */
		public function containsAttribute($name)
		{
			return isset($_SESSION[$name]);
		}

		/**
		 * @param string $name
		 * @return string
		 * @throws NoMappingException
		 */
		public function getAttribute($name)
		{
			if (!$this->containsAttribute($name))
				throw new NoMappingException($name);

			return $_SESSION[$name];
		}

		/**
		 * @param string $name
		 * @param string $value
		 */
		public function setAttribute($name, $value)
		{
			$_SESSION[$name] = $value;
		}

		/**
		 * @param string $name
		 * @throws NoMappingException
		 */
		public function removeAttribute($name)
		{
			if (!$this->containsAttribute($name))
				throw new NoMappingException($name);

			unset($_SESSION[$name]);
		}

		/**
		 */
		public function invalidate()
		{
			session_destroy();
			setcookie('PHPSESSID', '', time() - 86400, '/');
		}
	}
