<?php
	/**
	 * This class is used to generate simple captchas which let the user add two numbers. There is also a method to
	 * validate the users answer.
	 */
	class CaptchaModel
	{
		/**
		 * @return Map
		 *   Map      
		 *   {
		 *     a: int
		 *     b: int
		 *     operator: string
		 *     answer: string
		 *   }
		 */
		public function create()
		{
			$captcha = new Map();
			$captcha->put('a', rand(1, 10));
			$captcha->put('b', rand(1, 10));
			$captcha->put('operator', '+');
			$captcha->put('answer', $this->encrypt($captcha->get('a') + $captcha->get('b')));

			return $captcha;
		}

		/**
		 * @param string $answer
		 * @param string $input
		 * @return boolean
		 */
		public function isValid($answer, $input)
		{
			return $answer == $this->encrypt($input);
		}

		/**
		 * @param string $value
		 * @return string
		 */
		protected function encrypt($value)
		{
			return md5($value);
		}
	}
