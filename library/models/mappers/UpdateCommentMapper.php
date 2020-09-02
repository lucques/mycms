<?php
	/**
	 * This is the interface for updating a comment from a data source.
	 */
	interface UpdateCommentMapper
	{
		/**
		 * @param Map $comment
		 *   Map
		 *   {
		 *     id: int
		 *     nick: string
		 *     content: string
		 *     email: string
		 *     website: string
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
		 * 
		 */
		public function map();
	}
