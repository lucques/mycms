<?php
	/**
	 * This is the interface for selecting comments from a data source.
	 */
	interface SelectCommentsMapper extends MapListMapper
	{
		/**
		 * @param boolean $ascending
		 */
		public function setAscending($ascending);

		/**
		 * @return MyList
		 *   MyList(Map
		 *          {
		 *            id: int
		 *            nick: string
		 *            content: string
		 *            email: string
		 *            website: string
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
		 *            post: Map
		 *                  {
		 *                    id: string
		 *                    title: string
		 *                  }
		 *          })
		 */
		public function map();
	}
