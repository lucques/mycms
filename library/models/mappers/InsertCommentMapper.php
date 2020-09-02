<?php
	/**
	 * This is the interface for inserting a comment into a data source.
	 */
	interface InsertCommentMapper
	{
		/**
		 * @param Map $comment
		 *   Map
		 *   {
		 *     nick: string
		 *     email: string
		 *     website: string
		 *     content: string
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
		 *   }
		 */
		public function setComment(Map $comment);

		/**
		 * @param string $id
		 */
		public function setPostId($id);

		/**
		 * 
		 */
		public function map();
	}
