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

	public function testGetContentShouldReturnAText()
	{
		$history = $this->getMockBuilder('History')->getMock();

		$dilmasHistory = [];
		$dilmasHistory[] = [
			'Se hoje é o dia das crianças... Ontem eu disse: o dia da criança é o dia da mãe, 
			dos pais, das professoras, mas também é o dia dos animais, sempre que você olha 
			uma criança, há sempre uma figura oculta, que é um cachorro atrás. O que é algo 
			muito importante!',
			'Eu dou dinheiro pra minha filha. Eu dou dinheiro pra ela viajar, então é... é... 
			Já vivi muito sem dinheiro, já vivi muito com dinheiro.'
		];

		$history->method('offsetGet')->will($this->onConsecutiveCalls(
			$dilmasHistory[0][0],
			$dilmasHistory[0][1]
		));

		$interactiveHistory = new InteractiveHistory($history);
		$this->assertInternalType('string', $interactiveHistory->getContent(0, 0));
		$this->assertEquals($dilmasHistory[0][0], $interactiveHistory->getContent(0, 0));
		$this->assertInternalType('string', $interactiveHistory->getContent(0, 1));
		$this->assertEquals($dilmasHistory[0][1], $interactiveHistory->getContent(0, 1));		
	}

	public function testGetUndefinedOffsetShouldReturnEmptyString()
	{
		$history = $this->getMockBuilder('History')->getMock();

		$history->method('offsetExists')->will($this->onConsecutiveCalls(false));

		$interactiveHistory = new InteractiveHistory($history);
		$this->assertInternalType('string', $interactiveHistory->getContent(0, 0));
		$this->assertEquals('', $interactiveHistory->getContent(0, 0));
	}

	public function testGetLastOffsetShouldReturnStringTheEnd()
	{
		$history = $this->getMockBuilder('History')->getMock();

		$content = [];
		$content[] = ['The end'];

		$history->method('offsetGet')->will($this->onConsecutiveCalls($content[0][0]));

		$interactiveHistory = new InteractiveHistory($history);
		$this->assertInternalType('string', $interactiveHistory->getContent(0, 0));
		$this->assertEquals($content[0][0], $interactiveHistory->getContent(0, 0));
	}	
}
