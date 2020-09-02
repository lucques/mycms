<?php
	/**
	 * This validator validates natural numbers including 0 (zero). The range of valid numbers is therefore >= 0.
	 */
	class NaturalNumberValidator
	{
		protected $withLeadingZeros;

		/*
		 * @param boolean $withLeadingZeros
		 * @return PatternValidator
		 */
		public static function create($withLeadingZeros)
		{
			return new NaturalNumberValidator($withLeadingZeros);
		}

		/*
		 * @param boolean $withLeadingZeros
		 */
		public function __construct($withLeadingZeros)
		{
			$this->withLeadingZeros = $withLeadingZeros;
		}

		/**
		 * @param string $value
		 * @return boolean
		 */
		public function isValid($value)
		{
			if ($this->withLeadingZeros)
				return (boolean) preg_match('/^[0-9]+$/', $value);
			else
				return (boolean) preg_match('/^(0|[1-9][0-9]*)$/', $value);
		}
	}
