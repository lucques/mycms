<?php
	/**
	 * This criterion lets the mapper only select posts which are published (written in the past).
	 */
	class PublishedPostsCriterion extends AbstractCriterion implements PostCriterion
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
			return array('post.timestamp < NOW()');
		}
	}
