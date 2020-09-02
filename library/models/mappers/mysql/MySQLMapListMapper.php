<?php
	/**
	 * This class implements the MapListMapper interface for a MySQL database.
	 */
	abstract class MySQLMapListMapper extends AbstractMySQLMapper implements MapListMapper
	{
		protected $modifier;
		protected $offset;
		protected $limit;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);

			$this->offset = 0;
			$this->limit = -1;
			$this->modifier = new CompositeModifier();
		}

		public function setOffset($offset)
		{
			$this->offset = $offset;
		}

		public function setLimit($limit)
		{
			$this->limit = $limit;
		}

		public function addModifier(Modifier $modifier)
		{
			$this->modifier->add($modifier);
		}
	}
