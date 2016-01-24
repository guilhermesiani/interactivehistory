<?php

require 'config.php';
require 'util/Auth.php';

$composer_autoload = APP_ROOT.DS.'vendor'.DS.'autoload.php';
if (!file_exists($composer_autoload)) {
	die('Please, fucking install composer. http://getcomposer.org');
}
require $composer_autoload;

$lib = new Libs\Bootstrap();