<?php
	/**
	 * This criterion lets the mapper only select posts which belong to a given timestamp.
	 */
	class PostsByTimestampCriterion extends AbstractCriterion implements PostCriterion
	{
		protected $timestamp;

		/**
		 * @param Database $database
		 * @param Map $timestamp
		 */
		public function __construct(Database $database, Map $timestamp)
		{
			parent::__construct($database);

			$this->timestamp = $timestamp;
		}

		public function where()
		{
			$where = array();

			if ($this->timestamp->containsKey('weekday'))
				$where[] = 'WEEKDAY(post.timestamp) = ' . $this->timestamp->get('weekday');
			if ($this->timestamp->containsKey('dayOfYear'))
				$where[] = 'DAYOFYEAR(post.timestamp) = ' . $this->timestamp->get('dayOfYear');
			if ($this->timestamp->containsKey('week'))
				$where[] = 'WEEK(post.timestamp) = ' . $this->timestamp->get('week');
			if ($this->timestamp->containsKey('year'))
				$where[] = 'YEAR(post.timestamp) = ' . $this->timestamp->get('year');
			if ($this->timestamp->containsKey('month'))
				$where[] = 'MONTH(post.timestamp) = ' . $this->timestamp->get('month');
			if ($this->timestamp->containsKey('day'))
				$where[] = 'DAY(post.timestamp) = ' . $this->timestamp->get('day');
			if ($this->timestamp->containsKey('hour'))
				$where[] = 'HOUR(post.timestamp) = ' . $this->timestamp->get('hour');
			if ($this->timestamp->containsKey('minute'))
				$where[] = 'MINUTE(post.timestamp) = ' . $this->timestamp->get('minute');
			if ($this->timestamp->containsKey('second'))
				$where[] = 'SECOND(post.timestamp) = ' . $this->timestamp->get('second');

			return $where;
		}
	}
