<?php

namespace Libs\Connector\Entity;

/**
* 
*/
abstract class ConnectorConfig
{
	private $host;
	private $dbName;
	private $user;
	private $password;

	function __construct($host, $dbName, $user, $password)
	{
		$this->host 	= $host;
		$this->dbName 	= $dbName;
		$this->user 	= $user;
		$this->password = $password;
	}

	public function getHost(): string
	{
		return $this->host;
	}

	public function getDbName(): string
	{
		return $this->dbName;
	}	

	public function getUser(): string
	{
		return $this->user;		
	}

	public function getPassword(): string
	{
		return $this->password;		
	}

	abstract public function getDsn();
}
