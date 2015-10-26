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
		$interactiveHistory->moveForward(1);
		$this->assertInternalType('string', $interactiveHistory->getContent());
		$this->assertEquals($dilmasHistory[0][1], $interactiveHistory->getContent());		
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

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMoveForwardWithInvalidTypeArgumentShouldThrowAnException()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history); // Starts with index 0 on VerticalPosition

		$instance->moveForward('bla');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMoveBackwardWithInvalidTypeArgumentShouldThrowAnException()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history); // Starts with index 0 on VerticalPosition

		$instance->moveBackward('bla');
	}	

	public function testMoveForwardShouldReceiveIntArgumentAsHorizontalPosition()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history); // Starts with index 0 on VerticalPosition

		$instance->moveForward(1);
		$this->assertInternalType('int', $instance->getHorizontalPosition());			
		$this->assertEquals(1, $instance->getHorizontalPosition());		
	}

	public function testMoveBackwardShouldReceiveIntArgumentAsHorizontalPosition()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history); // Starts with index 0 on VerticalPosition

		$instance->moveForward(1);
		$instance->moveBackward(1);
		$this->assertInternalType('int', $instance->getHorizontalPosition());			
		$this->assertEquals(0, $instance->getHorizontalPosition());		
	}	

	public function testMoveForwardShouldSetNextIndexOfVerticalPosition()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history); // Starts with index 0 on VerticalPosition

		$instance->moveForward(0);
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(1, $instance->getVerticalPosition());	

		$instance->moveForward(0);
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(2, $instance->getVerticalPosition());		
	}

	public function testMoveBackwardShouldSetPreviousIndexOfVerticalPosition()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);

		$instance->moveForward(0);
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(1, $instance->getVerticalPosition());	

		$instance->moveBackward(0);
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(0, $instance->getVerticalPosition());		
	}	

	public function testSetPageOptionWithValidArgumentsForExistingPageShouldWork()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$history->offsetSet(1, 'Some valid argument');
		$instance = new InteractiveHistory($history);

		$optionsText = [
			'Some option to horizontal position',
			'Another option',
		];

		$instance->setPageOption(1, 0, $optionsText[0]);
		$instance->setPageOption(1, 1, $optionsText[1]);
		$this->assertEquals($optionsText[0], $instance->getPageOption(1, 0));
		$this->assertEquals($optionsText[1], $instance->getPageOption(1, 1));
	}	

	public function testGetPageOptionsShouldReturnValidArrayAndKeys()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$history->offsetSet(1, 'Some valid argument');
		$instance = new InteractiveHistory($history);

		$optionsText = [
			'Some option to horizontal position',
			'Another option',
		];

		$instance->setPageOption(1, 0, $optionsText[0]);
		$instance->setPageOption(1, 1, $optionsText[1]);
		$this->assertArrayHasKey('nextHorizontalPosition', $instance->getPageOptions(1)[0]);
		$this->assertArrayHasKey('optionText', $instance->getPageOptions(1)[0]);
	}

	public function testHasOptionsForExistingPageShouldReturnTrueOrFalse()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$history->offsetSet(0, 'Some valid argument');
		$history->offsetSet(1, 'Another valid argument');
		$instance = new InteractiveHistory($history);
		$instance->setPageOption(1, 0, 'Some option');

		$this->assertInternalType('bool', $instance->pageHasOption(0));
		$this->assertInternalType('bool', $instance->pageHasOption(1));
		$this->assertFalse($instance->pageHasOption(0));
		$this->assertTrue($instance->pageHasOption(1));
	}

	/**
	 * @expectedException OutOfRangeException
	 */
	public function testGetOptionWithNonExistingValueShouldThrowAnException()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);
		$instance->getOption(0, 0);
	}

	public function testMoveForwardWhenThereIsNoNextVerticalPositionShouldStayInTheSamePosition()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();

		$dilmasHistory = [];
		$dilmasHistory[] = [0 => 'Eu dou dinheiro pra minha filha.'];
		$dilmasHistory[] = [1 => 'The end'];

		$history->method('offsetGet')->will($this->onConsecutiveCalls(
			$dilmasHistory[0][0], 
			$dilmasHistory[1][1]
		));

		$instance = new InteractiveHistory($history);
		$instance->moveForward(0);	
		$instance->moveForward(0);	
		$instance->moveForward(0);

		$this->assertEquals(1, $instance->getVerticalPosition());	
		$this->assertEquals($dilmasHistory[1][1], $instance->getContent());	
	}

	public function testMoveBackwardWhenThereIsNoPreviousVerticalPositionShouldStayInTheSamePosition()
	{
		$history = $this->getMockBuilder('History\Entity\History')->getMock();

		$dilmasHistory = [];
		$dilmasHistory[] = [0 => 'Coloca esse dinheiro na poupança que a senhora ganha R$10 mil por mês'];

		$history->method('offsetGet')->willReturn($dilmasHistory[0][0]);

		$instance = new InteractiveHistory($history);
		$instance->moveBackward(0);
		
		$this->assertEquals(0, $instance->getVerticalPosition());		
		$this->assertEquals($dilmasHistory[0][0], $instance->getContent());	
	}	
}
