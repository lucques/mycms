<?php
	/**
	 * This class implements the MyIterator interface for MySQL database result sets. It also offers an additional
	 * method to skip a number of elements.
	 */
	class MySQLResultIterator implements MyIterator
	{
		protected $result;
		protected $size;
		protected $pointer;

		/**
		 * @param resource $result
		 */
		public function __construct($result)
		{
			$this->result = $result;
			$this->size = mysqli_num_rows($this->result);
			$this->pointer = 0;
		}

		public function hasNext()
		{
			return $this->pointer < $this->size;
		}

		/**
		 * @return array
		 */
		public function next()
		{
			if (!$this->hasNext())
				throw new NoSuchElementException('');

			$this->pointer ++;

			return mysqli_fetch_assoc($this->result);
		}

		/**
		 * @param int $count
		 */
		public function skip($count)
		{
			$this->pointer += $count;

			if ($this->pointer < $this->size)
				mysqli_data_seek($this->result, $this->pointer);
		}
	}
