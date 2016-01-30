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
		$connectorConf = new PostgreSQLConnectorConfig(DB_HOST, DB_NAME, DB_USER, DB_PASS);
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
					[$historyContentArray['h_position'] => [
							'content' => $historyContentArray['content'],
							'nextHorizontalPosition' => $historyContentArray['next_h_position']
						]
					]
				);
				$pages++;
			} else {
				$page = $history->offsetGet($historyContentArray['v_position']);
				$page[$historyContentArray['h_position']] = [
					'content' => $historyContentArray['content'],
					'nextHorizontalPosition' => $historyContentArray['next_h_position']
				];

				$history->offsetSet($historyContentArray['v_position'], $page);
			}
			$sth = $db->query("SELECT * FROM history_option 
				WHERE history_content_id = {$historyContentArray['history_content_id']}");
			$optionsArray = $sth->fetchAll(\PDO::FETCH_ASSOC);
			if (!empty($optionsArray)) {
				$horizontalPositions[$historyContentArray['v_position']] = (int) $historyContentArray['h_position'];
				$historyOptionsArray[$historyContentArray['v_position']] = $optionsArray;
			}
		}

		$interactiveHistory = new InteractiveHistory($history);
		$interactiveHistory->setTitle($historyArray['title']);
		$interactiveHistory->setSlug($historyArray['slug']);
		$interactiveHistory->setPages($pages);
		$interactiveHistory->attach(new \Libs\InteractiveHistory\Entity\Observers\Session());

		foreach ($historyOptionsArray as $key => $options) {
			foreach ($options as $option) {
				$interactiveHistory->setPageOption(
					$key, 
					$horizontalPositions[$key], 
					$option['next_h_position'], 
					$option['option']
				);
			}
		}

		return $interactiveHistory;
	}

	public function getAll()
	{
		// Getting history from database
		$connectorConf = new PostgreSQLConnectorConfig(DB_HOST, DB_NAME, DB_USER, DB_PASS);
		$db = (new PDOConnector($connectorConf))->getConnection();
		$sth = $db->query('SELECT history.history_id, history.title, history.slug FROM history
			ORDER BY history.history_id DESC LIMIT 3');

		$histories = $sth->fetchAll(\PDO::FETCH_ASSOC);

		foreach ($histories as $key => $value) {
			$sth = $db->query('SELECT content FROM history_content 
				WHERE history_id = '.$value['history_id'].' ORDER BY history_content_id ASC');
			$result = $sth->fetch(\PDO::FETCH_ASSOC);	
			$histories[$key]['content'] = $result['content'] ?? '';
		}

		return $histories;		
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