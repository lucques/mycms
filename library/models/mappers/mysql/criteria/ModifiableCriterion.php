<?php
	/**
	 * This class is supposed to be a criterion which can be filled by several methodes.
	 */
	class ModifiableCriterion implements Criterion
	{
		protected $from;
		protected $where;
		protected $groupBy;
		protected $having;

		/**
		 */
		public function __construct()
		{
			$this->from = array();
			$this->where = array();
			$this->groupBy = array();
			$this->having = array();
		}

		public function from()
		{
			return $this->from;
		}

		public function where()
		{
			return $this->where;
		}

		public function groupBy()
		{
			return $this->groupBy;
		}

		public function having()
		{
			return $this->having;
		}

		/**
		 * @param string $part
		 */
		public function addToFrom($part)
		{
			if (!in_array($part, $this->from))
				$this->from[] = $part;
		}

		/**
		 * @param string $part
		 */
		public function addToWhere($part)
		{
			if (!in_array($part, $this->where))
				$this->where[] = $part;
		}

		/**
		 * @param string $part
		 */
		public function addToGroupBy($part)
		{
			if (!in_array($part, $this->groupBy))
				$this->groupBy[] = $part;
		}

		/**
		 * @param string $part
		 */
		public function addToHaving($part)
		{
			if (!in_array($part, $this->having))
				$this->having[] = $part;
		}
	}
