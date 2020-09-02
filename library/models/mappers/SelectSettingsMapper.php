<?php
	/**
	 * This is the interface for selecting settings from a data source.
	 */
	interface SelectSettingsMapper
	{
		/**
		 * @return Map
		 *   Map
		 *   {
		 *     *: string
		 *   }
		 */
		public function map();
	}
