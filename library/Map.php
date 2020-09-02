<?php
	/**
	 * This class implements some methods resembling those of the Map interface from Java. In contrast to the Java
	 * interface, the keys used to map values are strings.
	 *
	 * @link http://java.sun.com/j2se/1.4.2/docs/api/java/util/Map.html
	 */
	class Map
	{
		protected $values;

		/**
		 * @param array $array Associative array
		 * @return Map
		 */
		public static function fromArray(array $array)
		{
			$map = new Map();

			foreach ($array as $key => $value)
				$map->put((string) $key, $value);

			return $map;
		}

		/**
		 */
		public function __construct()
		{
			$this->values = array();
		}

		/**
		 * @param string $key
		 * @return boolean
		 */
		public function containsKey($key)
		{
			return isset($this->values[$key]);
		}

		/**
		 * @param string $key
		 * @return mixed
		 * @throws NoMappingException
		 */
		public function get($key)
		{
			if (!$this->containsKey($key))
				throw new NoMappingException($key);

			return $this->values[$key];
		}

		/**
		 * @param string $key
		 * @param mixed $value
		 */
		public function put($key, $value)
		{
			$this->values[$key] = $value;
		}

		/**
		 * @param string $key
		 */
		public function remove($key)
		{
			unset($this->values[$key]);
		}

		/**
		 * @return int
		 */
		public function size()
		{
			return count($this->values);
		}

		/**
		 * @return MyList
		 */
		public function keyList()
		{
			$keys = new MyList();

			foreach ($this->values as $key => $value)
				$keys->add($key);

			return $keys;
				
		}

		/**
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
		public function __set($key, $value)
		{
			$this->put($key, $value);
		}
	}
