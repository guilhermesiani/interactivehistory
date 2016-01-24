<?php

namespace Libs\InteractiveHistory\Entity\Observers;

/**
* 
*/
class Session implements \SplObserver
{
	public function update(\SplSubject $interactiveHistory)
	{
		\Libs\Session::set('history', $interactiveHistory);
	}
}