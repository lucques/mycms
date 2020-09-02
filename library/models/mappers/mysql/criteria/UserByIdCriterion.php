<?php
	/**
	 * This criterion lets the mapper only select one user by id.
	 */
	class UserByIdCriterion extends AbstractCriterion implements UserCriterion
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
			return array('user.id = "' . $this->escape($this->id) . '"');
		}
	}
