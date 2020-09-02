<?php
	/**
	 * This criterion lets the mapper only select posts which are not static.
	 */
	class NonstaticPostsCriterion extends AbstractCriterion implements PostCriterion
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
			return array('post.is_static = 0');
		}
	}
