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
	private $pageOptions = [];

	// 	$arr = [
	// 	0 => null, 
	// 	1 => [
	// 		0 => ['nextHorizontalPosition' => 0, 'optionText' => 'Some direction to select'], 
	// 		1 => ['nextHorizontalPosition' => 1, 'optionText' => 'Another direction']
	// 	], 
	// 	2 => null, 
	// 	3 => null, 
	// 	4 => null
	// ];

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

	public function getContent(): string
	{
		if (!$this->history->offsetExists($this->verticalPosition))
			throw new \OutOfRangeException('History page not found');

		if (!isset($this->history->offsetGet($this->verticalPosition)[$this->horizontalPosition]))
			throw new \OutOfRangeException('History variant page not found');

		return $this->history->offsetGet($this->verticalPosition)[$this->horizontalPosition];
	}
	
	public function moveForward(int $horizontalPosition)
	{
		$nextPosition = $this->verticalPosition + 1;
		if ($this->history->offsetExists($nextPosition)) {
			$this->verticalPosition = $nextPosition;
			$this->setHorizontalPosition($horizontalPosition);
		}		
	}

	public function moveBackward(int $horizontalPosition)
	{
		$previousPosition = $this->verticalPosition - 1;
		if ($this->history->offsetExists($previousPosition)) {
			$this->verticalPosition = $previousPosition;
			$this->setHorizontalPosition($horizontalPosition);
		}	
	}

	private function setHorizontalPosition(int $horizontalPosition)
	{
		$this->horizontalPosition = 0;
		if (isset($this->history->offsetGet($this->verticalPosition)[$horizontalPosition])) {
			$this->horizontalPosition = $horizontalPosition;
		}
	}	

	public function getHorizontalPosition(): int
	{
		return $this->horizontalPosition;
	}

	public function getVerticalPosition(): int
	{
		return $this->verticalPosition;
	}

	public function setPageOption(int $page, int $nextHorizontalPosition, string $optionText)
	{
		$this->pageOptions[$page][] = [
			'nextHorizontalPosition' 	=> $nextHorizontalPosition,
			'optionText' 				=> $optionText,
		];
	}

	public function getPageOption(int $page, int $option): array
	{
		if (!isset($this->pageOptions[$page][$option])) {
			throw new \OutOfRangeException('This page has no options to choose for the next horizontal page');
		}

		return $this->pageOptions[$page][$option];
	}

	public function getPageOptions(): array
	{

	}	

	public function pageHasOptions(int $page): bool
	{
		if (!empty($this->pageOptions[$page]))
			return true;

		return false;
	}	
}

