<?php
	/**
	 * This criterion lets the mapper only select one category by id.
	 */
	class CategoryByIdCriterion extends AbstractCriterion implements CategoryCriterion
	{
		protected $id;

		/**
		 * @param Database $database
		 * @param string $id
		 */
		public function __construct(Database $database, $id)
		{
			parent::__construct($database);

			$this->id = $id;
		}

		public function where()
		{
			return array('category.id = "' . $this->escape($this->id) . '"');
		}
	}
