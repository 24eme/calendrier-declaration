<?php

$f3 = require __DIR__.'/../vendor/fatfree-core/base.php';
require __DIR__.'/../app/routes.php';

$f3->config(__DIR__.'/../app/default.ini');
$f3->config(__DIR__.'/../app/config.ini');

$f3->set('DB', DBManager::init($f3->get('db.dsn')));

$f3->set('mois', array('January' => "Janvier", 'February' => "Février", 'March' => 'Mars', 'April' => "Avril", 'May' => 'Mai', 'June' => 'Juin', 'July' => 'Juillet', 'August' => 'Aout', 'September' => 'Septembre', 'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'));

new Session();

$f3->run();
