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
	private $vPosition = 0;
	private $hPosition = 0;

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

	public function getContent(int $vPosition, int $hPosition): string
	{
		if (!$this->history->offsetExists($vPosition))
			throw new \OutOfRangeException('History page not found');

		if (!isset($this->history->offsetGet($vPosition)[$hPosition]))
			throw new \OutOfRangeException('History variant page not found');

		return $this->history->offsetGet($vPosition)[$hPosition];
	}
	
	public function moveForward()
	{
		$this->vPosition++;
	}
	
	public function setHorizontalPosition(int $hPosition)
	{
		$this->hPosition = $hPosition;
	}
	
	public function getHorizontalPosition()
	{
		return $this->hPosition;
	}

	public function getVerticalPosition()
	{
		return $this->vPosition;
	}
}