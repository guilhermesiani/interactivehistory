<?php

namespace InteractiveHistory\Entity;

use History\Entity\History as History;

/**
* 
*/
class InteractiveHistory implements InteractiveHistoryInterface
{
	private $title;
	private $history;
	private $verticalPosition = 0;
	private $horizontalPosition = 0;
	private $availablePositions = [];

	public function __construct(History $history)
	{
		$this->history = $history;
	}

	public function setTitle(string $title)
	{
		$this->title = $title;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getContent(int $verticalPosition, int $horizontalPosition): string
	{
		if (!$this->history->offsetExists($verticalPosition))
			throw new \OutOfRangeException('History page not found');

		if (!isset($this->history->offsetGet($verticalPosition)[$horizontalPosition]))
			throw new \OutOfRangeException('History variant page not found');

		return $this->history->offsetGet($verticalPosition)[$horizontalPosition];
	}
	
	public function moveForward()
	{
		$this->verticalPosition++;
	}
	
	public function setHorizontalPosition(int $horizontalPosition)
	{
		$this->horizontalPosition = $horizontalPosition;
	}
	
	private function getHorizontalPosition()
	{
		return $this->horizontalPosition;
	}

	public function getVerticalPosition()
	{
		return $this->verticalPosition;
	}
}