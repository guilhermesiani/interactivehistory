<?php

namespace Libs\InteractiveHistory\Entity;

use Libs\History\Entity\History as History;

/**
* 
*/
class InteractiveHistory implements InteractiveHistoryInterface, \SplSubject
{
	private $title;
	private $slug;
	private $history;
	private $verticalPosition = 0;
	private $horizontalPosition = 0;
	private $pageOptions = [];
	private $pages = 0;
	private $observers = [];

	public function __construct(History $history)
	{
		$this->observers = new \SplObjectStorage();
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

	public function setSlug(string $slug)
	{
		$this->slug = $slug;
	}

	public function getSlug(): string
	{
		return $this->slug;
	}	

	public function setPages(int $pages)
	{
		if ($pages <= 0) {
			throw new \OutOfRangeException('Pages should be greater than 0');
		}
		$this->pages = $pages;
	}

	public function getPages(): int
	{
		return $this->pages;
	}

	public function getContent(): string
	{
		if (!$this->history->offsetExists($this->verticalPosition))
			throw new \OutOfRangeException('History page not found');

		if (!isset($this->history->offsetGet($this->verticalPosition)[$this->horizontalPosition]['content']))
			throw new \OutOfRangeException('History variant page not found');

		return $this->history->offsetGet($this->verticalPosition)[$this->horizontalPosition]['content'];
	}
	
	public function moveForward(int $horizontalPosition)
	{
		$nextPosition = $this->verticalPosition + 1;
		if ($this->history->offsetExists($nextPosition)) {
			$this->verticalPosition = $nextPosition;
			$this->setHorizontalPosition($horizontalPosition);
		}		
		$this->notify();
	}

	public function moveBackward(int $horizontalPosition)
	{
		$previousPosition = $this->verticalPosition - 1;
		if ($this->history->offsetExists($previousPosition)) {
			$this->verticalPosition = $previousPosition;
			$this->setHorizontalPosition($horizontalPosition);
		}	
		$this->notify();
	}

	private function setHorizontalPosition(int $horizontalPosition)
	{
		$this->horizontalPosition = 0;
		if (isset($this->history->offsetGet($this->verticalPosition)[$horizontalPosition]['content'])) {
			$this->horizontalPosition = $horizontalPosition;
		}
		$this->notify();
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
		return $this->pageOptions;
	}	

	public function pageHasOptions(int $page): bool
	{
		if (!empty($this->pageOptions[$page]))
			return true;

		return false;
	}

	public function attach(\SplObserver $observer)
	{
		$this->observers->attach($observer);
	}

	public function detach(\SplObserver $observer)
	{
		$this->observers->detach($observer);
	}

	public function notify()
	{
		foreach ($this->observers as $observer) {
			$observer->update($this);
		}
	}
}

