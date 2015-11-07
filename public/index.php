<?php

use Connector\Entity\PDOConnector;
use Connector\Entity\DBConnectorConfig\PostgreSQLConnectorConfig;
use History\Entity\History;
use InteractiveHistory\Entity\InteractiveHistory;

include 'bootstrap.php';

// Getting history from database
$connectorConf = new PostgreSQLConnectorConfig('localhost', 'interactivehistory', 'guilhermesiani', '');
$db = (new PDOConnector($connectorConf))->getConnection();
$sth = $db->query('SELECT * FROM history_content WHERE history_id = 1');

// Setting into History object
$history = new History();
foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $historyData) {
	if (!$history->offsetExists($historyData['v_position'])) {
		$history->offsetSet(
			$historyData['v_position'], 
			[$historyData['h_position'] => $historyData['content']]
		);
	} else {
		$page = $history->offsetGet($historyData['v_position']);
		$page[$historyData['h_position']] = $historyData['content'];

		$history->offsetSet($historyData['v_position'], $page);
	}
}

$interactiveHistory = new InteractiveHistory($history);
echo $interactiveHistory->getContent().PHP_EOL;
$interactiveHistory->moveForward(0);
echo $interactiveHistory->getContent().PHP_EOL;
$interactiveHistory->moveForward(0);
echo $interactiveHistory->getContent().PHP_EOL;
$interactiveHistory->moveForward(0);
echo $interactiveHistory->getContent().PHP_EOL;
$interactiveHistory->moveForward(0);
echo $interactiveHistory->getContent().PHP_EOL;