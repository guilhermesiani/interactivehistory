<?php
namespace Controllers;

use Libs\InteractiveHistoryDAO\InteractiveHistoryDAO;
use Libs\Session;

/**
* 
*/
class History extends \Libs\Controller
{
	
	function __construct()
	{
		parent::__construct();
		Session::init();
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
		$interactiveHistoryDAO = new InteractiveHistoryDAO();
		Session::set('history', $interactiveHistoryDAO->getBySlug($slug));

		return Session::get('history', Session::UNSERIALIZE);
	}

	public function getHistory($slug)
	{
		$history = Session::get('history', Session::UNSERIALIZE);
		if (null === $history || $slug !== $history->getSlug()) {
			return $this->getNewHistorySession($slug);
		}
		return $history;
	}
}