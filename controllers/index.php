<?php
namespace Controllers;

use Libs\Connector\Entity\PDOConnector;
use Libs\Connector\Entity\DBConnectorConfig\PostgreSQLConnectorConfig;
use Libs\History\Entity\History;
use Libs\InteractiveHistory\Entity\InteractiveHistory;

/**
* 
*/
class Index extends \Libs\Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Getting history from database
		$connectorConf = new PostgreSQLConnectorConfig(DB_HOST, DB_NAME, DB_USER, DB_PASS);
		$db = (new PDOConnector($connectorConf))->getConnection();
		$sth = $db->query('SELECT history.history_id, history.title, history.slug FROM history
			ORDER BY history.history_id DESC LIMIT 3');

		$histories = $sth->fetchAll(\PDO::FETCH_ASSOC);

		foreach ($histories as $key => $value) {
			$sth = $db->query('SELECT content FROM history_content WHERE history_id = '.$value['history_id'].' ORDER BY history_content_id ASC');
			$result = $sth->fetch(\PDO::FETCH_ASSOC);	
			$histories[$key]['content'] = $result['content'] ?? '';
		}

		$this->view->histories = $histories;
		$this->view->render('index/index');
	}
	
}