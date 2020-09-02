<?php
	/**
	 * This is the interface for selecting posts from a data source.
	 */
	interface SelectPostsMapper extends MapListMapper
	{
		/**
		 * @param boolean $ascending
		 */
		public function setAscending($ascending);

		/**
		 * @param boolean $selectAuthor
		 */
		public function setSelectAuthor($selectAuthor);

		/**
		 * @param boolean $selectCategories
		 */
		public function setSelectCategories($selectCategories);

		/**
		 * @param Modifier $modifier
		 */
		public function addAuthorModifier(Modifier $modifier);

		/**
		 * @param Modifier $modifier
		 */
		public function addCategoryModifier(Modifier $modifier);

		/**
		 * @return MyList
		 *   MyList(Map
		 *          {
		 *            id: string
		 *            title: string
		 *            content: string
		 *            showComments: boolean
		 *            allowComments: boolean
		 *            showLink: boolean
		 *            showTimestamp: boolean
		 *            showAuthor: boolean
		 *            isStatic: boolean
		 *            timestamp: Map
		 *                       {
		 *                         weekday: int
		 *                         dayOfYear: int
		 *                         week: int
		 *                         year: int
		 *                         month: int
		 *                         day: int
		 *                         hour: int
		 *                         minute: int
		 *                         second: int
		 *                       }
		 *            [author: Map
		 *                     {
		 *                       id: string
		 *                       nick: string
		 *                       website: string
		 *                     }]
		 *            [categories: MyList(Map
		 *                                {
		 *                                  id: string
		 *                                  title: string
		 *                                })]
		 *          })
		 */
		public function map();
	}
