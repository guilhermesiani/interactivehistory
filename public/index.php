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



// [0] => Array
//     (
//         [history_content_id] => 1
//         [history_id] => 1
//         [v_position] => 0
//         [h_position] => 0
//         [next_h_position] => 0
//         [content] => Era uma vez um cara do mau chamado aldemar batista. Saqueador de baladas vip.
//     )

// [1] => Array
//     (
//         [history_content_id] => 2
//         [history_id] => 1
//         [v_position] => 1
//         [h_position] => 0
//         [next_h_position] => 0
//         [content] => Ele comecou a querer pegar as menininhas solteiras, embora todas o quisessem longe delas.
//     )

// [2] => Array
//     (
//         [history_content_id] => 3
//         [history_id] => 1
//         [v_position] => 2
//         [h_position] => 0
//         [next_h_position] => 0
//         [content] => Foi quando uma loira bem gata deu moral para o coitado. ele pirou ne vei.
//     )

// [3] => Array
//     (
//         [history_content_id] => 4
//         [history_id] => 1
//         [v_position] => 2
//         [h_position] => 1
//         [next_h_position] => 0
//         [content] => Foi qunado ele desistiu e foi para a casa.
//     )

// [4] => Array
//     (
//         [history_content_id] => 5
//         [history_id] => 1
//         [v_position] => 3
//         [h_position] => 0
//         [next_h_position] => 0
//         [content] => E nunca mais quis saber de baladas de novo.
//     )

// [5] => Array
//     (
//         [history_content_id] => 6
//         [history_id] => 1
//         [v_position] => 4
//         [h_position] => 0
//         [next_h_position] => 0
//         [content] => The end
//     )