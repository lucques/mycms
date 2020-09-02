<?php
	/**
	 * This class implements some methods resembling those of the List interface from Java. The class name is "MyList"
	 * because "List" is a reserverd word in PHP.
	 *
	 * @link http://java.sun.com/j2se/1.4.2/docs/api/java/util/List.html
	 */
	class MyList implements Collection
	{
		protected $values;

		/**
		 * @param array $array
		 * @return MyList
		 */
		public static function fromArray(array $array)
		{
			$list = new MyList();

			foreach ($array as $value)
				$list->add($value);

			return $list;
		}

		/**
		 */
		public function __construct()
		{
			$this->values = array();
		}

		public function contains($value)
		{
			foreach ($this->values as $currentValue)
				if ($currentValue === $value)
					return true;

			return false;
		}

		public function iterator()
		{
			return new ListIterator($this);
		}

		public function size()
		{
			return count($this->values);
		}

		public function toArray()
		{
			return $this->values;
		}

		public function toList()
		{
			return $this;
		}

		/**
		 * @param int $index
		 * @throws IndexOutOfBoundsException
		 */
		public function get($index)
		{
			if ($index < 0 || $index >= $this->size())
				throw new IndexOutOfBoundsException();

			return $this->values[$index];
		}

		/**
		 * @param mixed $value
		 * @return boolean
		 */
		public function add($value)
		{
			$contains = $this->contains($value);

			$this->values[] = $value;

			return $contains;
		}

		/**
		 * @param int $index
		 * @return mixed
		 * @throws IndexOutOfBoundsException
		 */
		public function removeAt($index)
		{
			if ($index < 0 || $index >= $this->size())
				throw new IndexOutOfBoundsException();

			$removed = $this->values[$index];

			for ($i = $index + 1; $i < $this->size(); $i ++)
				$this->values[$i - 1] = $this->values[$i];

			unset($this->values[$this->size() - 1]);

			return $removed;
		}

		/**
		 * @param mixed $value
		 * @return boolean
		 */
		public function remove($value)
		{
			if (!$this->contains($value))
				return false;

			for ($i = 0; $i < $this->size(); $i ++)
				if ($this->values[$i] === $value)
				{
					$this->removeAt($i);
					break;
				}

			return true;
		}
	}
