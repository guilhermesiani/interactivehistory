<?php

namespace Connector\Entity\DBConnectorConfig;

use Connector\Entity\ConnectorConfig;

/**
* 
*/
class MySQLConnectorConfig extends ConnectorConfig
{
	
	public function getDsn()
	{
		return sprintf('mysql:host=%s;dbname=%s', $this->getHost(), $this->getDbName);
	}
}