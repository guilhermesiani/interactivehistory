<?php
namespace Libs;

/**
* 
*/
abstract class Controller
{
	
	function __construct()
	{
		$this->view = new View();
	}
}