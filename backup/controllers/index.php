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
		$this->view->render('index/index');		
	}
	
}