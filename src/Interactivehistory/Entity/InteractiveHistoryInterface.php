<?php

namespace InteractiveHistory\Entity;

interface InteractiveHistoryInterface
{
	public function setTitle(string $title);
	public function getTitle(): string;
	public function getContent(int $vPosition, int $hPosition): string;
	public function moveForward();
	public function setHorizontalPosition(int $hPosition);
	public function getHorizontalPosition();
	public function getVerticalPosition();
}