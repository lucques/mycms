<?php
	/**
	 * This is the interface for selecting categories from a data source.
	 */
	interface SelectCategoriesMapper extends MapListMapper
	{
		/**
		 * @param boolean $selectNumberOfPosts
		 */
		public function setSelectNumberOfPosts($selectNumberOfPosts);

		/**
		 * @return MyList
		 *   MyList(Map
		 *          {
		 *            id: string
		 *            title: string
		 *            [numberOfPosts: int]
		 *          })
		 */
		public function map();
	}
