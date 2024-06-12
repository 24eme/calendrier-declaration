<?php

use Controllers\Calendrier;

$f3 = \Base::instance();

$f3->route('GET /', Calendrier::class.'->home');
