<?php

namespace Connector\Entity\DBConnectorConfig;

use Connector\Entity\ConnectorConfig;

/**
* 
*/
class PostgreSQLConnectorConfig extends ConnectorConfig
{
	
	public function getDsn()
	{
		return sprintf('pgsql:host=%s;dbname=%s', $this->getHost(), $this->getDbName());		
	}
}