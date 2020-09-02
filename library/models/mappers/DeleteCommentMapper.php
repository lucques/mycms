<?php
	/**
	 * This is the interface for deleting a comment from a data source.
	 */
	interface DeleteCommentMapper
	{
		/**
		 * @param int $id
		 */
		public function setId($id);

		/**
		 * 
		 */
		public function map();
	}
