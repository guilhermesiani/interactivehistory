<?php
namespace Controllers;

use Libs;

/**
* 
*/
class History extends \Libs\Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->view->render('history/index');
	}
}