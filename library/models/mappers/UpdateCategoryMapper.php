<?php
	/**
	 * This is the interface for updating a category from a data source.
	 */
	interface UpdateCategoryMapper
	{
		/**
		 * @param Map $post
		 *   Map
		 *   {
		 *     id: string
		 *     title: string
		 *   }
		 */
		public function setCategory(Map $category);

		/**
		 * 
		 */
		public function map();
	}
