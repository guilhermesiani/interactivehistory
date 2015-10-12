<?php

use InteractiveHistory\Entity\InteractiveHistory;
use History\Entity\History;

include 'bootstrap.php';

$history = new History();
$history->offsetSet(0, [0 => 'Bla', 1 => 'Oi']);

if (isset($history->offsetGet(0)[2])) {
	echo $history->offsetGet(0)[1].PHP_EOL;
	exit;
}

$interactiveHistory = new InteractiveHistory($history);

echo $interactiveHistory->getContent(0, 1).PHP_EOL;