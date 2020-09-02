<?php
	require_once 'PHPUnit/Framework.php';

	class TimestampValidatorTest extends PHPUnit_Framework_TestCase
	{
		public function testIsValid()
		{
			$validator = new TimestampValidator();

			$this->assertTrue($validator->isValid($this->createTimestamp()));

			//year
			$timestamp = $this->createTimestamp();
			$timestamp->put('year', 100);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('year', 10000);
			$this->assertTrue($validator->isValid($timestamp));

			//month
			$timestamp = $this->createTimestamp();
			$timestamp->put('month', -1);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('month', 0);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('month', 1);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('month', 12);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('month', 13);
			$this->assertFalse($validator->isValid($timestamp));

			//day
			$timestamp = $this->createTimestamp();
			$timestamp->put('day', -1);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('day', 0);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('day', 1);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('day', 28);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('day', 32);
			$this->assertFalse($validator->isValid($timestamp));

			//hour
			$timestamp = $this->createTimestamp();
			$timestamp->put('hour', -1);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('hour', 0);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('hour', 23);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('hour', 24);
			$this->assertFalse($validator->isValid($timestamp));

			//minute
			$timestamp = $this->createTimestamp();
			$timestamp->put('minute', -1);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('minute', 0);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('minute', 59);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('minute', 60);
			$this->assertFalse($validator->isValid($timestamp));

			//second
			$timestamp = $this->createTimestamp();
			$timestamp->put('second', -1);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('second', 0);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('second', 59);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('second', 60);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('month', 2);
			$timestamp->put('day', 29);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('month', 2);
			$timestamp->put('day', 29);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('year', 2008); //2008 is a leap year
			$timestamp->put('month', 2);
			$timestamp->put('day', 29);
			$this->assertTrue($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('month', 4);
			$timestamp->put('day', 31);
			$this->assertFalse($validator->isValid($timestamp));

			$timestamp = $this->createTimestamp();
			$timestamp->put('month', 5);
			$timestamp->put('day', 31);
			$this->assertTrue($validator->isValid($timestamp));
		}

		protected function createTimestamp()
		{
			$timestamp = new Map();
			$timestamp->put('year', 2010); //2010 is not a leap year
			$timestamp->put('month', 7);
			$timestamp->put('day', 7);
			$timestamp->put('hour', 13);
			$timestamp->put('minute', 42);
			$timestamp->put('second', 23);

			return $timestamp;
		}
	}
