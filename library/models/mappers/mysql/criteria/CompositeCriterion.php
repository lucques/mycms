<?php
	/**
	 * This class acts as a composite of several criteria. It also does some stuff like removing doubled conditions.
	 */
	class CompositeCriterion implements Criterion
	{
		protected $criteria;

		/**
		 */
		public function __construct()
		{
			$this->criteria = array();
		}

		/**
		 * @param Criterion $criterion
		 */
		public function add(Criterion $criterion)
		{
			$this->criteria[] = $criterion;
		}

		public function from()
		{
			$from = array();

			foreach ($this->criteria as $criterion)
			{
				foreach ($criterion->from() as $part)
				{
					if (!in_array($part, $from))
						$from[] = $part;
				}
			}

			return $from;
		}

		public function where()
		{
			$where = array();

			foreach ($this->criteria as $criterion)
			{
				foreach ($criterion->where() as $part)
				{
					if (!in_array($part, $where))
						$where[] = $part;
				}
			}

			return $where;
		}

		public function groupBy()
		{
			$groupBy = array();

			foreach ($this->criteria as $criterion)
			{
				foreach ($criterion->groupBy() as $part)
				{
					if (!in_array($part, $groupBy))
						$groupBy[] = $part;
				}
			}

			return $groupBy;
		}

		public function having()
		{
			$having = array();

			foreach ($this->criteria as $criterion)
			{
				foreach ($criterion->having() as $part)
				{
					if (!in_array($part, $having))
						$having[] = $part;
				}
			}

			return $having;
		}
	}
