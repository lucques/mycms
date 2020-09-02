<?php
	/**
	 * This is the interface for selecting the number of posts from a data source.
	 */
	interface SelectNumberOfPostsMapper
	{
		/**
		 * @return int
		 */
		public function map();
	}
