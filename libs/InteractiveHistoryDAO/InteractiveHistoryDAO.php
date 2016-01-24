<?php

namespace Libs\InteractiveHistoryDAO;

use Libs\Connector\Entity\PDOConnector;
use Libs\Connector\Entity\DBConnectorConfig\PostgreSQLConnectorConfig;
use Libs\History\Entity\History;
use Libs\InteractiveHistory\Entity\InteractiveHistory;

/**
* 
*/
class InteractiveHistoryDAO
{
	public function getBySlug(string $slug): InteractiveHistory
	{
		// Getting history from database
		$connectorConf = new PostgreSQLConnectorConfig('localhost', 'interactivehistory', 'guilhermesiani', '');
		$db = (new PDOConnector($connectorConf))->getConnection();
		$sth = $db->prepare('SELECT * FROM history WHERE slug = :slug');
		$sth->bindValue(':slug', $slug);
		$sth->execute();

		$historyArray = $sth->fetch(\PDO::FETCH_ASSOC);

		$sth = $db->query("SELECT * FROM history_content WHERE history_id = {$historyArray['history_id']}");
		$historyContentsArray = $sth->fetchAll(\PDO::FETCH_ASSOC);
		
		$history = new History();
		$historyOptionsArray = [];
		$pages = 0;
		foreach ($historyContentsArray as $historyContentArray) {
			if (!$history->offsetExists($historyContentArray['v_position'])) {
				$history->offsetSet(
					$historyContentArray['v_position'], 
					[$historyContentArray['h_position'] => $historyContentArray['content']]
				);
			} else {
				$page = $history->offsetGet($historyContentArray['v_position']);
				$page[$historyContentArray['h_position']] = $historyContentArray['content'];

				$history->offsetSet($historyContentArray['v_position'], $page);
			}
			$sth = $db->query("SELECT * FROM history_option WHERE history_content_id = {$historyContentArray['history_content_id']}");
			$optionsArray = $sth->fetchAll(\PDO::FETCH_ASSOC);
			if (!empty($optionsArray)) {
				$historyOptionsArray[$historyContentArray['v_position']] = $optionsArray;
			}
			$pages++;
		}

		$interactiveHistory = new InteractiveHistory($history);
		$interactiveHistory->setTitle($historyArray['title']);
		$interactiveHistory->setSlug($historyArray['slug']);
		$interactiveHistory->setPages($pages);
		$interactiveHistory->attach(new \Libs\InteractiveHistory\Entity\Observers\Session());

		foreach ($historyOptionsArray as $key => $options) {
			foreach ($options as $option) {
				$interactiveHistory->setPageOption($key, $option['next_h_position'], $option['option']);
			}
		}

		return $interactiveHistory;
	}

	public function getPages(History $history) {

	}

	public function insert()
	{
		echo $interactiveHistory->getContent();
		echo PHP_EOL;
		echo $interactiveHistory->moveForward(0);
		echo $interactiveHistory->getContent();
		echo PHP_EOL;
		echo $interactiveHistory->moveBackward(0);
		echo $interactiveHistory->getContent();
	}
}