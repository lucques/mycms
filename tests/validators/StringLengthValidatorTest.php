<?php
	require_once 'PHPUnit/Framework.php';

	class StringLengthValidatorTest extends PHPUnit_Framework_TestCase
	{
		public function testIsValid()
		{
			$validator = new StringLengthValidator();

			$this->assertTrue($validator->isValid(0, 10, '1234567890'));
			$this->assertFalse($validator->isValid(0, 10, '12345678901'));

			$this->assertTrue($validator->isValid(-10, 10, '12345'));
			$this->assertFalse($validator->isValid(-10, -10, '12345'));
		}
	}
