<?php
	/**
	 * This criterion lets the mapper only select posts which are static.
	 */
	class StaticPostsCriterion extends AbstractCriterion implements PostCriterion
	{
		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);
		}

		public function where()
		{
			return array('post.is_static = 1');
		}
	}
