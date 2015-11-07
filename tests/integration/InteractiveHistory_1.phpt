--FILE--
<?php
require 'vendor/autoload.php';

use History\Entity\History;
use InteractiveHistory\Entity\InteractiveHistory;

$history = new History();
$history->offsetSet(0, [0 => 'Era uma vez...']);
$history->offsetSet(1, [0 => '...continuacao...']);

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