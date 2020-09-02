<?php
	/**
	 * This class implements MyIterator for MyList objects, so you can iterate with it over the items of a MyList
	 * object.
	 */
	class ListIterator implements MyIterator
	{
		protected $list;
		protected $pointer;

		/**
		 * @param MyList $list
		 */
		public function __construct(MyList $list)
		{
			$this->list = $list;
			$this->pointer = 0;
		}

		public function hasNext()
		{
			return $this->pointer < $this->list->size();
		}

		public function next()
		{
			if (!$this->hasNext())
				throw new NoSuchElementException('');

			$this->pointer ++;

			return $this->list->get($this->pointer - 1);
		}
	}
