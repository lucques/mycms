<?php
	/**
	 * This class is the subclass of all link modifiers and has a method which easily can replace placeholders in links.
	 */
	abstract class PathModifier implements Modifier
	{
		protected $settings;
		protected $field;

		/**
		 * @param Map $settings
		 * @param string $field
		 */
		public function __construct(Map $settings, $field)
		{
			$this->settings = $settings;
			$this->field = $field;
		}

		/**
		 * @param string $key
		 * @param string $value
		 * @param string $string
		 * @return string
		 */
		protected function replace($key, $value, $string)
		{
			return str_replace('%' . $key . '%', $value, $string);
		}
	}
