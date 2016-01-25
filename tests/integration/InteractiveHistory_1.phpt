--FILE--
<?php
require 'vendor/autoload.php';

use Libs\History\Entity\History;
use Libs\InteractiveHistory\Entity\InteractiveHistory;

$history = new History();
$history->offsetSet(0, [
	0 => [
		'content' => 'Era uma vez...',
		'nextHorizontalPosition' => 0
	]
]);
$history->offsetSet(1, [
	0 => [
		'content' => '...continuacao...',
		'nextHorizontalPosition' => 0
	]
]);

$interactiveHistory = new InteractiveHistory($history);
echo $interactiveHistory->getContent();
echo PHP_EOL;
echo $interactiveHistory->moveForward(0);
echo $interactiveHistory->getContent();
echo PHP_EOL;
echo $interactiveHistory->moveBackward(0);
echo $interactiveHistory->getContent();
?>
--EXPECTF--
Era uma vez...
...continuacao...
Era uma vez...