<?php
	/**
	 * This is the interface for selecting the number of comments from a data source.
	 */
	interface SelectNumberOfCommentsMapper
	{
		/**
		 * @return int
		 */
		public function map();
	}
