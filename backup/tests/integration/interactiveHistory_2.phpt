--FILE--
<?php
require 'vendor/autoload.php';

use Libs\History\Entity\History;
use Libs\InteractiveHistory\Entity\InteractiveHistory;

$history = new History();
$history->offsetSet(0, [0 => 'Era uma vez...']);
$history->offsetSet(1, [0 => 'era outra vez...']);
$history->offsetSet(2, [0 => '...continuacao...']);

$interactiveHistory = new InteractiveHistory($history);
$interactiveHistory->setPageOption(1, 0, 'Quero continuar');
$interactiveHistory->setPageOption(1, 1, 'Nao quero continuar');

$interactiveHistory->moveForward(0);
if ($interactiveHistory->pageHasOptions(
	$interactiveHistory->getVerticalPosition()
)) {
	echo $interactiveHistory->getPageOption(
		$interactiveHistory->getVerticalPosition(), 0)['optionText'];
	echo PHP_EOL;
	echo $interactiveHistory->getPageOption(
		$interactiveHistory->getVerticalPosition(), 1)['optionText'];
}
echo PHP_EOL;
$interactiveHistory->moveForward(0);
echo $interactiveHistory->getContent();
?>
--EXPECTF--
Quero continuar
Nao quero continuar
...continuacao...