<?php

use Interactivehistory\Entity\History;

class HistoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @depends assertPreConditions
	 */	
	public function assertPreConditions()
	{
		$this->assertTrue(
			class_exists($class = 'Interactivehistory\Entity\History'),
			'Class not found: '.$class
		);
	}

	public function testInstantiationWithoutArgumentsShouldWork()
	{
		$instance = new History();
		$this->assertInstanceOf(
			'Interactivehistory\Entity\History',
			$instance
		);
	}

	public function testSetTitleWithValidDataShouldWork()
	{
		$instance = new History();
		$title 	  = 'Título da história';
		$return   = $instance->setTitle($title);
		// $this->assertInstanceOf(

		// );
	}
}