<?php

$f3 = require __DIR__.'/../vendor/fatfree-core/base.php';
require __DIR__.'/../app/routes.php';

$f3->config(__DIR__.'/../app/default.ini');
$f3->config(__DIR__.'/../app/config.ini');

$f3->set('DB', DBManager::init($f3->get('db.dsn')));

if ($f3->get("theme")) {
    $f3->set('THEME', implode(DIRECTORY_SEPARATOR, [$f3->get('ROOT'), "themes" , $f3->get("theme")]));
} else {
    $f3->set('THEME', null);
}


new Session();

$f3->run();
