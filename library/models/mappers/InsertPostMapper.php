<?php
	/**
	 * This is the interface for inserting a post into a data source.
	 */
	interface InsertPostMapper
	{
		/**
		 * @param Map $post
		 *   Map
		 *   {
		 *     id: string
		 *     title: string
		 *     content: string
		 *     showComments: boolean
		 *     allowComments: boolean
		 *     showLink: boolean
		 *     showTimestamp: boolean
		 *     showAuthor: boolean
		 *     isStatic: boolean
		 *     timestamp: Map
		 *                {
		 *                  weekday: int
		 *                  dayOfYear: int
		 *                  week: int
		 *                  year: int
		 *                  month: int
		 *                  day: int
		 *                  hour: int
		 *                  minute: int
		 *                  second: int
		 *                }
		 *     author: string
		 *     categories: MyList(string)
		 *   }
		 */
		public function setPost(Map $post);

		/**
		 * 
		 */
		public function map();
	}
