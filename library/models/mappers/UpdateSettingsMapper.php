<?php
	/**
	 * This is the interface for updating the settings from a data source.
	 */
	interface UpdateSettingsMapper
	{
		/**
		 * @param Map $settings
		 */
		public function setSettings(Map $settings);

		/**
		 * 
		 */
		public function map();
	}
