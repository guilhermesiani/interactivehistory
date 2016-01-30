<?php

namespace Libs\InteractiveHistory\Entity;

interface InteractiveHistoryInterface
{
	public function setTitle(string $title);
	public function getTitle(): string;
	public function getContent(): string;
	public function moveForward(int $horizontalPosition);
	public function moveBackward(int $horizontalPosition);
	public function getHorizontalPosition(): int;
	public function getVerticalPosition(): int;
	public function setPageOption(
		int $page, 
		int $horizontalPosition, 
		int $nextHorizontalPosition, 
		string $optionText
	);
	public function getPageOption(int $page, int $horizontalPosition, int $option): array;
	public function getPageOptions(): array;
	public function pageHasOptions(int $page, int $horizontalPosition): bool;
}