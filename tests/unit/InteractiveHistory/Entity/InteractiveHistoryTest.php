<?php

use Libs\InteractiveHistory\Entity\InteractiveHistory;

class InteractiveHistoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @depends assertPreConditions
	 */	
	public function assertPreConditions()
	{
		$this->assertTrue(
			class_exists($class = 'Libs\InteractiveHistory\Entity\InteractiveHistory'),
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
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);
	}	

	public function testIfIsInstanceOfSplSubject()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);
		$this->assertInstanceOf('\SplSubject', $instance);		
	}

	public function testSetTitleWithValidArgumentShouldWork()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();

		$instance = new InteractiveHistory($history);
		$title 	  = 'Título da história';
		$return   = $instance->setTitle($title);
		$this->assertEquals($title, $instance->getTitle());
	}

	public function testSetSlugWithValidArgumentShouldWork()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();

		$instance = new InteractiveHistory($history);
		$slug 	  = 'an-slug-test';
		$return   = $instance->setSlug($slug);
		$this->assertEquals($slug, $instance->getSlug());
	}	

	public function testGetContentShouldReturnAText()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();

		$dilmasHistory = [];
		$dilmasHistory[] = [
				1 => [
					'content' => 'Se hoje é o dia das crianças... Ontem eu disse: o dia da criança é o dia da mãe, 
					dos pais, das professoras, mas também é o dia dos animais, sempre que você olha 
					uma criança, há sempre uma figura oculta, que é um cachorro atrás. O que é algo 
					muito importante!',
					'nextHorizontalPosition' => 0
			]
		];

		$history->method('offsetExists')->willReturn(true);
		$history->method('offsetGet')->willReturn($dilmasHistory[0]);

		$interactiveHistory = new InteractiveHistory($history);
		$interactiveHistory->moveForward(1);
		$this->assertInternalType('string', $interactiveHistory->getContent());
		$this->assertEquals($dilmasHistory[0][1]['content'], $interactiveHistory->getContent());		
	}

	/**
	 * @expectedException OutOfRangeException
	 */
	public function testGetUndefinedOffsetShouldThrowOutOfRangeException()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();

		$history->method('offsetExists')->will($this->onConsecutiveCalls(false));

		$interactiveHistory = new InteractiveHistory($history);
		echo $interactiveHistory->getContent(0, 0);
	}

	public function testGetLastOffsetShouldReturnStringTheEnd()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();

		$content = [];
		$content[] = [
			0 => [
				'content' => 'The end',
				'nextHorizontalPosition' => 0
			]
		];

		$history->method('offsetExists')->willReturn(true);
		$history->method('offsetGet')->willReturn($content[0]);

		$interactiveHistory = new InteractiveHistory($history);
		$this->assertInternalType('string', $interactiveHistory->getContent(0, 0));
		$this->assertEquals($content[0][0]['content'], $interactiveHistory->getContent(0, 0));
	}

	public function testInstantiationShouldStartWithOneHorizontalAndVerticalPosition()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);

		$this->assertInternalType('int', $instance->getHorizontalPosition());			
		$this->assertEquals(0, $instance->getHorizontalPosition());
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(0, $instance->getVerticalPosition());
	}

	public function testMoveForwardShouldSetNextIndexOfVerticalPosition()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$history->method('offsetExists')->will($this->onConsecutiveCalls(true, true));
		$instance = new InteractiveHistory($history); // Starts with index 0 on VerticalPosition

		$instance->moveForward(0);
		$this->assertInternalType('int', $instance->getVerticalPosition());			
		$this->assertEquals(1, $instance->getVerticalPosition());	
		$instance->moveForward(0);	
		$this->assertEquals(2, $instance->getVerticalPosition());		
	}

	public function testMoveBackwardShouldSetPreviousIndexOfVerticalPosition()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$history->method('offsetExists')->will($this->onConsecutiveCalls(true, true));		
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
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$history->offsetSet(1, [
			'content' => 'Some valid argument',
			'nextHorizontalPosition' => 0
		]);
		$instance = new InteractiveHistory($history);

		$optionsText = [
			'Some option to horizontal position',
			'Another option',
		];

		$instance->setPageOption(1, 0, $optionsText[0]);
		$instance->setPageOption(1, 1, $optionsText[1]);
		$this->assertEquals($optionsText[0], $instance->getPageOption(1, 0)['optionText']);
		$this->assertEquals($optionsText[1], $instance->getPageOption(1, 1)['optionText']);
	}	

	public function testGetPageOptionShouldReturnValidArrayAndKeys()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$history->offsetSet(1, [
			'content' => 'Some valid argument',
			'nextHorizontalPosition' => 0
		]);
		$instance = new InteractiveHistory($history);

		$optionsText = [
			'Some option to horizontal position',
			'Another option',
		];

		$instance->setPageOption(1, 0, $optionsText[0]);
		$instance->setPageOption(1, 1, $optionsText[1]);
		$this->assertArrayHasKey('nextHorizontalPosition', $instance->getPageOption(1, 0));
		$this->assertArrayHasKey('optionText', $instance->getPageOption(1, 1));
	}

	public function testHasOptionsForExistingPageShouldReturnTrueOrFalse()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$history->offsetSet(0, [
			'content' => 'Some valid argument',
			'nextHorizontalPosition' => 0
		]);
		$history->offsetSet(1, [
			'content' => 'Another valid argument',
			'nextHorizontalPosition' => 0
		]);
		$instance = new InteractiveHistory($history);
		$instance->setPageOption(1, 0, 'Some option');

		$this->assertInternalType('bool', $instance->pageHasOptions(0));
		$this->assertInternalType('bool', $instance->pageHasOptions(1));
		$this->assertFalse($instance->pageHasOptions(0));
		$this->assertTrue($instance->pageHasOptions(1));
	}

	/**
	 * @expectedException OutOfRangeException
	 */
	public function testGetOptionWithNonExistingValueShouldThrowAnException()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);
		$instance->getPageOption(0, 0);
	}

	public function testMoveForwardWhenThereIsNoNextVerticalPositionShouldStayInTheSamePosition()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();

		$dilmasHistory = [];
		$dilmasHistory[] = [0 => [
				'content' => 'The end',
				'nextHorizontalPosition' => 0
			]
		];

		$history->method('offsetExists')->will($this->onConsecutiveCalls(true, false, true));	
		$history->method('offsetGet')->willReturn($dilmasHistory[0]);

		$instance = new InteractiveHistory($history);
		$instance->moveForward(0);	
		$instance->moveForward(0);

		$this->assertEquals(1, $instance->getVerticalPosition());	
		$this->assertEquals($dilmasHistory[0][0]['content'], $instance->getContent());	
	}

	public function testMoveBackwardWhenThereIsNoPreviousVerticalPositionShouldStayInTheSamePosition()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();

		$dilmasHistory = [];
		$dilmasHistory[] = [
			0 => [
				'content' => 'Coloca esse dinheiro na poupança que a senhora ganha R$10 mil por mês',
				'nextHorizontalPosition' => 0
			]
		];

		$history->method('offsetGet')->willReturn($dilmasHistory[0]);
		$history->method('offsetExists')->will($this->onConsecutiveCalls(false, true));

		$instance = new InteractiveHistory($history);
		$instance->moveBackward(0);
		
		$this->assertEquals(0, $instance->getVerticalPosition());
		$this->assertEquals($dilmasHistory[0][0]['content'], $instance->getContent());	
	}	

	public function testMoveWithNonExistingHorizontalPositionShouldSetZeroAsDefault()
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();

		$dilmasHistory = [];
		$dilmasHistory[] = [
			0 => [
				'content' => 'O desemprego beira 20%, ou seja, 1 em cada 4 portugueses.',
				'nextHorizontalPosition' => 0
			]
		];
		$dilmasHistory[] = [
			0 => [
				'content' => 'The end',
				'nextHorizontalPosition' => 0
			]
		];

		$history->method('offsetExists')->will($this->onConsecutiveCalls(true, true));	
		$history->method('offsetGet')->will(
			$this->onConsecutiveCalls(
				$dilmasHistory[1], 
				$dilmasHistory[1],
				$dilmasHistory[1]
			)
		);

		$instance = new InteractiveHistory($history);
		$instance->moveForward(1);

		$this->assertEquals(1, $instance->getVerticalPosition());	
		$this->assertEquals($dilmasHistory[1][0]['content'], $instance->getContent());	
	}

	public function testGetNextHorizontalPositionShouldReturnAnIntOfAnExistingPage()
	{

	}

	public function testSetPagesShouldReceiveArgumentOfTypeInt() 
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);	
		$instance->setPages(12);
		$this->assertEquals(12, $instance->getPages());
	}

	/**
	 * @expectedException TypeError
	 * @dataProvider providerInvalidArgumentForSetPages
	 */
	public function testSetPagesWithInvalidArgumentShouldThrowAnException($param)
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);	
		$instance->setPages($param);
	}

	/**
	 * @expectedException \OutOfRangeException
	 */
	public function testSetPagesWithIntLessThanOneShouldThrowAnException() 
	{
		$history = $this->getMockBuilder('Libs\History\Entity\History')->getMock();
		$instance = new InteractiveHistory($history);	
		$instance->setPages(-3);
	}

	public function providerInvalidArgumentForSetPages()
	{
		return [
			['test'],
			[new ArrayObject],
			[[]]
		];
	}
}
