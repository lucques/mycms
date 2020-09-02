<?php
	/**
	 * This is the interface for selecting data from a data source as Map objects in a MyList.
	 */
	interface MapListMapper
	{
		/**
		 * @param int $offset
		 */
		public function setOffset($offset);

		/**
		 * @param int $limit
		 */
		public function setLimit($limit);

		/**
		 * @param Modifier $modifier
		 */
		public function addModifier(Modifier $modifier);
	}
