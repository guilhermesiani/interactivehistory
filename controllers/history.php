<?php
namespace Controllers;

use Libs\InteractiveHistoryDAO\InteractiveHistoryDAO;
use Libs\InteractiveHistory\Entity\InteractiveHistory;
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

	public function index(string $slug, int $page = 1)
	{
		$this->view->history = $this->getHistory($slug);

		if (isset($_POST['nextPage'])) {
			$this->view->history->moveForward($_POST['nextHorizontalPosition'] ?? $this->view->history->getNextHorizontalPosition());
		} else if ($this->view->history->getVerticalPosition() > ($page - 1)) {
			for ($i = $this->view->history->getVerticalPosition(); $i > ($page - 1); $i--) {
				$this->view->history->moveBackward(0);
			}
		}

		$this->view->render('history/index');
	}

	private function getNewHistorySession(string $slug): InteractiveHistory
	{
		$interactiveHistoryDAO = new InteractiveHistoryDAO();
		Session::set('history', $interactiveHistoryDAO->getBySlug($slug));

		return Session::get('history', Session::UNSERIALIZE);
	}

	private function getHistory(string $slug): InteractiveHistory
	{
		$history = Session::get('history', Session::UNSERIALIZE);
		if (null === $history || $slug !== $history->getSlug()) {
			return $this->getNewHistorySession($slug);
		}
		return $history;
	}
}