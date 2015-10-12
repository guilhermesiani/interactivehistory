<?php

use InteractiveHistory\Entity\InteractiveHistory;

class InteractiveHistoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @depends assertPreConditions
	 */	
	public function assertPreConditions()
	{
		$this->assertTrue(
			class_exists($class = 'InteractiveHistory\Entity\InteractiveHistory'),
			'Class not found: '.$class
		);
	}

	/**
	 * @expectedException TypeError
	 */
	public function testInstantiationWithoutArgumentsShouldThrowAnException()
	{
		$instance = new InteractiveHistory();
	}

	/**
	 * @expectedException TypeError
	 */
	public function testInstantiationWithAnInvalidArgumentShouldThrowAnException()
	{
		$instance = new InteractiveHistory(2);
	}	

	public function testInstantiationWithAnInstanceOfHistoryOnConstructShouldWork()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);
	}	

	public function testSetTitleWithValidArgumentShouldWork()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();

		$instance = new InteractiveHistory($history);
		$title 	  = 'Título da história';
		$return   = $instance->setTitle($title);
		$this->assertEquals($title, $instance->getTitle());
	}

	public function testGetContentShouldReturnAText()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();

		$dilmasHistory = [];
		$dilmasHistory[] = [
			1 => 'Se hoje é o dia das crianças... Ontem eu disse: o dia da criança é o dia da mãe, 
			dos pais, das professoras, mas também é o dia dos animais, sempre que você olha 
			uma criança, há sempre uma figura oculta, que é um cachorro atrás. O que é algo 
			muito importante!'
		];

		$history->method('offsetExists')->willReturn(true);
		$history->method('offsetGet')->willReturn([1 => $dilmasHistory[0][1]]);

		$interactiveHistory = new InteractiveHistory($history);
		$this->assertInternalType('string', $interactiveHistory->getContent(0, 1));
		$this->assertEquals($dilmasHistory[0][1], $interactiveHistory->getContent(0, 1));		
	}

	/**
	 * @expectedException OutOfRangeException
	 */
	public function testGetUndefinedOffsetShouldThrowOutOfRangeException()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();

		$history->method('offsetExists')->will($this->onConsecutiveCalls(false));

		$interactiveHistory = new InteractiveHistory($history);
		echo $interactiveHistory->getContent(0, 0);
	}

	public function testGetLastOffsetShouldReturnStringTheEnd()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();

		$content = [];
		$content[] = ['The end'];

		$history->method('offsetExists')->willReturn(true);
		$history->method('offsetGet')->willReturn([0 => $content[0][0]]);

		$interactiveHistory = new InteractiveHistory($history);
		$this->assertInternalType('string', $interactiveHistory->getContent(0, 0));
		$this->assertEquals($content[0][0], $interactiveHistory->getContent(0, 0));
	}

	public function testInstantiationShouldStartWithOneHorizontalAndVerticalPosition()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);

		$this->assertInternalType('int', $instance->getHorizontalPosition());			
		$this->assertEquals(0, $instance->getHorizontalPosition());
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(0, $instance->getVerticalPosition());
	}	

	public function testMoveForwardShouldSetNextIndexOfVerticalPosition()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history); // Starts with index 1 on VerticalPosition

		$instance->moveForward();
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(1, $instance->getVerticalPosition());	

		$instance->moveForward();
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(2, $instance->getVerticalPosition());		
	}	
}
