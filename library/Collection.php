<?php
	/**
	 * This interface resembles the Collection interface from Java.
	 *
	 * @link http://java.sun.com/j2se/1.4.2/docs/api/java/util/Collection.html
	 */
	interface Collection
	{
		/**
		 * @param mixed $value
		 * @return boolean
		 */
		public function contains($value);

		/**
		 * @return MyIterator
		 */
		public function iterator();

		/**
		 * @return int
		 */
		public function size();

		/**
		 * @return array
		 */
		public function toArray();

		/**
		 * @return MyList
		 */
		public function toList();
	}
