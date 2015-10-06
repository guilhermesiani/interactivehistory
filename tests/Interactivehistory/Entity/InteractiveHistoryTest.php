<?php

use Interactivehistory\Entity\InteractiveHistory;

class InteractiveHistoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @depends assertPreConditions
	 */	
	public function assertPreConditions()
	{
		$this->assertTrue(
			class_exists($class = 'Interactivehistory\Entity\InteractiveHistory'),
			'Class not found: '.$class
		);
	}

	public function testInstantiationWithoutArgumentsShouldWork()
	{
		$instance = new InteractiveHistory();
		$this->assertInstanceOf(
			'Interactivehistory\Entity\InteractiveHistory',
			$instance
		);
	}

	public function testSetTitleWithValidDataShouldWork()
	{
		$instance = new InteractiveHistory();
		$title 	  = 'Título da história';
		$return   = $instance->setTitle($title);
		$this->assertInstanceOf(
			'Interactivehistory\Entity\InteractiveHistory',
			$return
		);
		$this->assertEquals($title, $instance->getTitle());
	}

	public function testSetContentWithAnArrayObjectInstanceShouldWork()
	{
		$history = $this->getMockBuilder('History')->getMock();

		$instance = new InteractiveHistory();
		$instance->setContent($history);
	}

	/**
	 * expectedException Exception
	 */
	public function testSetContentWithAnInvalidArgumentShouldThrowAnException()
	{
		$instance = new InteractiveHistory();
		$instance->setContent(2);
	}	
}
