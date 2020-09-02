<?php
	require_once 'PHPUnit/Framework.php';

	class NaturalNumberValidatorTest extends PHPUnit_Framework_TestCase
	{
		public function testIsValid()
		{
			$validator = new NaturalNumberValidator();

			$this->assertTrue($validator->isValid('0', false));
			$this->assertFalse($validator->isValid('00', false));

			$this->assertTrue($validator->isValid('1234567890', false));
			$this->assertFalse($validator->isValid('01', false));

			$this->assertFalse($validator->isValid('0.1', false));
			$this->assertFalse($validator->isValid('0.1', true));

			$this->assertFalse($validator->isValid('0,1', false));
			$this->assertFalse($validator->isValid('0,1', true));
		}
	}
