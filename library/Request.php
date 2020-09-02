<?php
	/**
	 * This class represents an HTTP request. You could get information about the request and there is a public
	 * attribute storage.
	 */
	class Request
	{
		protected $session;
		protected $getParameters;
		protected $postParameters;
		protected $attributes;

		/**
		 */
		public function __construct()
		{
			$this->session = null;
			$this->getParameters = new Map();
			$this->postParameters = new Map();

			foreach ($_GET as $key => $value)
				$this->getParameters->put($key, $value);

			foreach ($_POST as $key => $value)
				$this->postParameters->put($key, $value);

			$this->attributes = new Map();
		}

		/**
		 * @return string
		 */
		public function getPath()
		{
			return $_SERVER['REQUEST_URI'];
		}

		/**
		 * @param boolean $create
		 * @return Session
		 */
		public function getSession($create)
		{
			if ($this->session == null &&
			    ($create || isset($_COOKIE['PHPSESSID'])))
				$this->session = new Session();

			return $this->session;
		}

		/**
		 * @param string $name
		 * @return boolean
		 */
		public function containsGetParameter($name)
		{
			return $this->getParameters->containsKey($name);
		}

		/**
		 * @param string $name
		 * @return string 
		 */
		public function getGetParameter($name)
		{
			return $this->getParameters->get($name);
		}

		/**
		 * @param string $name
		 * @param boolean
		 */
		public function containsPostParameter($name)
		{
			return $this->postParameters->containsKey($name);
		}

		/**
		 * @param string $name
		 * @return string
		 */
		public function getPostParameter($name)
		{
			return $this->postParameters->get($name);
		}

		/**
		 * @param string $name
		 * @return boolean
		 */
		public function containsAttribute($name)
		{
			return $this->attributes->containsKey($name);
		}

		/**
		 * @param string $name
		 * @return object
		 */
		public function getAttribute($name)
		{
			return $this->attributes->get($name);
		}

		/**
		 * @param string $name
		 * @param object $object
		 */
		public function setAttribute($name, $object)
		{
			$this->attributes->put($name, $object);
		}
	}
