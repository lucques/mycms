<?php
	/**
	 * This is the interface for inserting a category into a data source.
	 */
	interface InsertCategoryMapper
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
