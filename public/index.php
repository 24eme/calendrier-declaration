<?php

$f3 = require __DIR__.'/../vendor/fatfree-core/base.php';
require __DIR__.'/../app/routes.php';

$f3->config(__DIR__.'/../app/default.ini');
$f3->config(__DIR__.'/../app/config.ini');

$f3->set('DB', DBManager::init($f3->get('db.dsn')));

$f3->set('mois', array('Jan' => "Janv", 'Feb' => "Fév", 'Mar' => 'Mars', 'Apr' => "Avr", 'May' => 'Mai', 'Jun' => 'Juin', 'Jul' => 'Juil', 'Aug' => 'Aout', 'Sep' => 'Sept', 'Oct' => 'Oct', 'Nov' => 'Nov', 'Dec' => 'Déc'));

new Session();

$f3->run();
