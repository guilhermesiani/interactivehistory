<?php

use History\Entity\History;

class HistoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @depends assertPreConditions
	 */	
	public function assertPreConditions()
	{
		$this->assertTrue(
			class_exists($class = 'History\Entity\History'),
			'Class not found: '.$class
		);
	}

	public function testHistoryShouldBeAnInstanceOfArrayObject()
	{
		$this->assertInstanceOf('\ArrayObject', new History);		
	}
}