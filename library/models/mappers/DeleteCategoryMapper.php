<?php
	/**
	 * This is the interface for deleting a category from a data source.
	 */
	interface DeleteCategoryMapper
	{
		/**
		 * @param string $id
		 */
		public function setId($id);

		/**
		 * 
		 */
		public function map();
	}
