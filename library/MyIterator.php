<?php
	/**
	 * This interface resembles the Iterator interface from Java. The class name is "MyIterator" because "Iterator" is an
	 * interface from the SPL.
	 *
	 * @link http://java.sun.com/j2se/1.4.2/docs/api/java/util/Iterator.html
	 */
	interface MyIterator
	{
		/**
		 * @return boolean
		 */
		public function hasNext();

		/**
		 * @return mixed
		 * @throws NoSuchElementException
		 */
		public function next();
	}
