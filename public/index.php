<?php

$f3 = require __DIR__.'/../vendor/fatfree-core/base.php';
require __DIR__.'/../app/common.php';
require __DIR__.'/../app/routes.php';

$f3->config(__DIR__.'/../app/default.ini');
$f3->config(__DIR__.'/../app/config.ini');

$f3->set('DB', DBManager::init($f3->get('db.dsn')));
$f3->set('COMMIT', getCommit());
$f3->get('page_title', "Gestion du calendrier viti/vinicole");

$f3->run();
