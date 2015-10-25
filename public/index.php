<?php

use History\Entity\History;
use InteractiveHistory\Entity\InteractiveHistory;
use Connector\Entity\PDOConnector;
use Connector\Entity\DBConnectorConfig\PostgreSQLConnectorConfig;

include 'bootstrap.php';

$history = new History();
$history->offsetSet(0, [0 => 'Bla', 1 => 'Oi']);

if (isset($history->offsetGet(0)[2])) {
	echo $history->offsetGet(0)[1].PHP_EOL;
	exit;
}

$interactiveHistory = new InteractiveHistory($history);

echo $interactiveHistory->getContent(0, 1).PHP_EOL;

$connectorConf = new PostgreSQLConnectorConfig(
	'localhost', 
	'interactivehistory', 
	'guilhermesiani', 
	''
);

$db = (new PDOConnector($connectorConf))->getConnection();

$sth = $db->query('SELECT * FROM history_content');
print_r($sth->fetchAll(PDO::FETCH_ASSOC));