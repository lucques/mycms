<?php
	/**
	 * This is the interface for selecting the timestamps of posts from a data source.
	 */
	interface SelectTimestampsOfPostsMapper extends MapListMapper
	{
		/**
		 * @param boolean $selectWeekday
		 */
		public function setSelectWeekday($selectWeekday);

		/**
		 * @param boolean $selectDayOfYear
		 */
		public function setSelectDayOfYear($selectDayOfYear);

		/**
		 * @param boolean $selectWeek
		 */
		public function setSelectWeek($selectWeek);

		/**
		 * @param boolean $selectYear
		 */
		public function setSelectYear($selectYear);

		/**
		 * @param boolean $selectMonth
		 */
		public function setSelectMonth($selectMonth);

		/**
		 * @param boolean $selectDay
		 */
		public function setSelectDay($selectDay);

		/**
		 * @param boolean $selectHour
		 */
		public function setSelectHour($selectHour);

		/**
		 * @param boolean $selectMinute
		 */
		public function setSelectMinute($selectMinute);

		/**
		 * @param boolean $selectSecond
		 */
		public function setSelectSecond($selectSecond);

		/**
		 * @param boolean $setSelectNumberOfPosts
		 */
		public function setSelectNumberOfPosts($selectNumberOfPosts);

		/**
		 * @return MyList
		 *   MyList(Map
		 *          {
		 *            [weekday: int]
		 *            [dayOfYear: int]
		 *            [week: int]
		 *            [year: int]
		 *            [month: int]
		 *            [day: int]
		 *            [hour: int]
		 *            [minute: int]
		 *            [second: int]
		 *            [numberOfPosts: int]
		 *          })
		 */
		public function map();
	}
