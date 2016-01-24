<?php

namespace Libs\Connector\Entity;

use Libs\Connector\Entity\Connector;

/**
* 
*/
class PDOConnector implements Connector
{
	private $instance;

	public function __construct(ConnectorConfig $connectorConfig)
	{
		$this->connect($connectorConfig);
	}

	public function connect(ConnectorConfig $connectorConfig)
	{
		if (!$this->isConnected()) {
			$this->instance = new \PDO(
				$connectorConfig->getDsn(),
				$connectorConfig->getUser(),
				$connectorConfig->getPassword()
			);

			$this->instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
	}

	public function disconnect()
	{
		if ($this->isConnected())
			$this->instance = null;
	}

	public function isConnected(): bool
	{
		return $this->instance instanceof \PDO;
	}

	public function getConnection(): \PDO
	{
		return $this->instance;
	}
}