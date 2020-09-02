<?php
	/**
	 * This validator validates a string on a pattern.
	 */
	class PatternValidator
	{
		protected $pattern;

		/*
		 * @param string $pattern
		 * @return PatternValidator
		 */
		public static function create($pattern)
		{
			return new PatternValidator($pattern);
		}

		/*
		 * @param string $pattern
		 */
		public function __construct($pattern)
		{
			$this->pattern = $pattern;
		}

		/*
		 * @param string $value
		 * @return boolean
		 */
		public function isValid($value)
		{
			//The modifier s makes the dot . in the pattern also count for line-breaks
			return (boolean) preg_match('/^' . $this->pattern . '$/s', $value);
		}
	}
