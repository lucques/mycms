<?php
	/**
	 * This class implements the SelectTimestampsOfPostsMapper interface for a MySQL database.
	 */
	class MySQLSelectTimestampsOfPostsMapper extends MySQLMapListMapper implements SelectTimestampsOfPostsMapper
	{
		protected $selectWeekday;
		protected $selectDayOfYear;
		protected $selectWeek;
		protected $selectYear;
		protected $selectMonth;
		protected $selectDay;
		protected $selectHour;
		protected $selectMinute;
		protected $selectSecond;
		protected $selectNumberOfPosts;
		protected $criterion;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);

			$this->selectWeekday = false;
			$this->selectDayOfYear = false;
			$this->selectWeek = false;
			$this->selectYear = false;
			$this->selectMonth = false;
			$this->selectDay = false;
			$this->selectHour = false;
			$this->selectMinute = false;
			$this->selectSecond = false;
			$this->selectNumberOfPosts = false;
			$this->criterion = new CompositeCriterion();
		}

		public function setSelectWeekday($selectWeekday)
		{
			$this->selectWeekday = $selectWeekday;
		}

		public function setSelectDayOfYear($selectDayOfYear)
		{
			$this->selectDayOfYear = $selectDayOfYear;
		}

		public function setSelectWeek($selectWeek)
		{
			$this->selectWeek = $selectWeek;
		}

		public function setSelectYear($selectYear)
		{
			$this->selectYear = $selectYear;
		}

		public function setSelectMonth($selectMonth)
		{
			$this->selectMonth = $selectMonth;
		}

		public function setSelectDay($selectDay)
		{
			$this->selectDay = $selectDay;
		}

		public function setSelectHour($selectHour)
		{
			$this->selectHour = $selectHour;
		}

		public function setSelectMinute($selectMinute)
		{
			$this->selectMinute = $selectMinute;
		}

		public function setSelectSecond($selectSecond)
		{
			$this->selectSecond = $selectSecond;
		}

		public function setSelectNumberOfPosts($selectNumberOfPosts)
		{
			$this->selectNumberOfPosts = $selectNumberOfPosts;
		}

		public function map()
		{
			$timestamps = new MyList();

			$selections = array();
			$aliases = array();

			if ($this->selectYear)
			{
				$selections[] = 'YEAR(post.timestamp) AS year';
				$aliases[] = 'year';
			}
			if ($this->selectDayOfYear)
			{
				$selections[] = 'DAYOFYEAR(post.timestamp) AS day_of_year';
				$aliases[] = 'day_of_year';
			}
			if ($this->selectWeek)
			{
				$selections[] = 'WEEK(post.timestamp) AS week';
				$aliases[] = 'week';
			}
			if ($this->selectMonth)
			{
				$selections[] = 'MONTH(post.timestamp) AS month';
				$aliases[] = 'month';
			}
			if ($this->selectDay)
			{
				$selections[] = 'DAY(post.timestamp) AS day';
				$aliases[] = 'day';
			}
			if ($this->selectWeekday)
			{
				$selections[] = 'WEEKDAY(post.timestamp) AS weekday';
				$aliases[] = 'weekday';
			}
			if ($this->selectHour)
			{
				$selections[] = 'HOUR(post.timestamp) AS hour';
				$aliases[] = 'hour';
			}
			if ($this->selectMinute)
			{
				$selections[] = 'MINUTE(post.timestamp) AS minute';
				$aliases[] = 'minute';
			}
			if ($this->selectSecond)
			{
				$selections[] = 'SECOND(post.timestamp) AS second';
				$aliases[] = 'second';
			}

			if ($this->selectNumberOfPosts)
			{
				$criterion = new ModifiableCriterion();

				foreach ($aliases as $alias)
					$criterion->addToGroupBy($alias);

				$this->criterion->add($criterion);
			}

			$sql  = 'SELECT ';
			$sql .=   implode(', ', $selections);

			if ($this->selectNumberOfPosts)
				$sql .= ', COUNT(post.id) AS number_of_posts';

			$sql .= ' ';
			$sql .= 'FROM ';
			$sql .=   $this->relation('posts') . ' AS post';
			$sql .=   implode('', $this->criterion->from()) . ' ';

			$where = $this->criterion->where();

			if (count($where) > 0)
				$sql .= 'WHERE ' . implode(' AND ', $where) . ' ';

			$groupBy = $this->criterion->groupBy();

			if (count($groupBy) > 0)
				$sql .= 'GROUP BY ' . implode(', ', $groupBy) . ' ';

			$having = $this->criterion->having();

			if (count($having) > 0)
				$sql .= 'HAVING ' . implode(' AND ', $having) . ' ';

			$sql .= 'ORDER BY ';
			$sql .=   implode(', ', $aliases);

			$iterator = $this->database->query($sql);

			while ($iterator->hasNext())
			{
				$tuple = $iterator->next();

				$timestamp = new Map();

				if ($this->selectWeekday)
					$timestamp->put('weekday', $tuple['weekday']);
				if ($this->selectDayOfYear)
					$timestamp->put('dayOfYear', $tuple['day_of_year']);
				if ($this->selectWeek)
					$timestamp->put('week', $tuple['week']);
				if ($this->selectYear)
					$timestamp->put('year', $tuple['year']);
				if ($this->selectMonth)
					$timestamp->put('month', $tuple['month']);
				if ($this->selectDay)
					$timestamp->put('day', $tuple['day']);
				if ($this->selectHour)
					$timestamp->put('hour', $tuple['hour']);
				if ($this->selectMinute)
					$timestamp->put('minute', $tuple['minute']);
				if ($this->selectSecond)
					$timestamp->put('second', $tuple['second']);
				if ($this->selectNumberOfPosts)
					$timestamp->put('numberOfPosts', $tuple['number_of_posts']);

				$this->modifier->modify($timestamp);

				$timestamps->add($timestamp);
			}

			return $timestamps;
		}

		/**
		 * @param PostCriterion $criterion
		 */
		public function addCriterion(PostCriterion $criterion)
		{
			$this->criterion->add($criterion);
		}
	}
