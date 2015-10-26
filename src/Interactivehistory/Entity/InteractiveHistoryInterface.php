<?php

namespace InteractiveHistory\Entity;

interface InteractiveHistoryInterface
{
	public function setTitle(string $title);
	public function getTitle(): string;
	public function getContent(): string;
	public function moveForward(int $horizontalPosition);
	public function moveBackward(int $horizontalPosition);
	public function getHorizontalPosition();
	public function getVerticalPosition();
	public function setPageOption();
	public function getPageOption(int $page, int $option);
	public function getPageOptions();
}