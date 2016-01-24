<?php

namespace Libs\Connector\Entity\DBConnectorConfig;

use Libs\Connector\Entity\ConnectorConfig;

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