<?php

namespace Libs\Connector\Entity\DBConnectorConfig;

use Libs\Connector\Entity\ConnectorConfig;

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