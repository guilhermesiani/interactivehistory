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
		Libs\Session::init();
	}

	public function index($slug)
	{
		$this->view->history = $this->getHistory($slug);

		if (isset($_POST['nextPage'])) {
			$this->view->history->moveForward($_POST['nextHorizontalPosition'] ?? 0);
		}

		$this->view->render('history/index');
	}

	public function getNewHistorySession($slug) 
	{
		$interactiveHistoryDAO = new Libs\InteractiveHistoryDAO\InteractiveHistoryDAO();
		Libs\Session::set('history', $interactiveHistoryDAO->getBySlug($slug));

		return Libs\Session::get('history', Libs\Session::UNSERIALIZE);
	}

	public function getHistory($slug)
	{
		$history = Libs\Session::get('history', Libs\Session::UNSERIALIZE);
		if (null === $history || $slug !== $history->getSlug()) {
			return $this->getNewHistorySession($slug);
		}
		return $history;
	}
}