<?php
	/**
	 * This is the interface for deleting a post from a data source.
	 */
	interface DeletePostMapper
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
