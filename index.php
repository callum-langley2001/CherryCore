<?php


defined('ROOT_DIR') || define('ROOT_DIR', realpath(dirname(__FILE__)));
$autoload = ROOT_DIR . '/vendor/autoload.php';
if (is_file($autoload)) require $autoload;

use Cherry\Application\Application;
use Cherry\Session\SessionManager;

$app = new Application(ROOT_DIR);
$app->run()
    ->setSession();

$session = SessionManager::init();
$session->set('foo', 'bar');
echo $session->get('foo');
