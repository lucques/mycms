<?php
	/**
	 * This criterion lets the mapper only select posts which are not published (written in the future).
	 */
	class UnpublishedPostsCriterion extends AbstractCriterion implements PostCriterion
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
			return array('post.timestamp > NOW()');
		}
	}
