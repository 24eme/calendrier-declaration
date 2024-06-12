<?php

use Controllers\Calendrier;
use Controllers\Evenement;

$f3 = \Base::instance();

$f3->route('GET /', Calendrier::class.'->home');

$f3->route('GET      @eventlist:   /admin/evenements', Evenement::class.'->index');
$f3->route('GET|POST @eventcreate: /admin/evenement/create', Evenement::class.'->new');
$f3->route('GET      @eventedit:   /admin/evenement/edit/@evenement', Evenement::class.'->edit');
$f3->route('GET      @eventdelete: /admin/evenement/delete/@evenement', Evenement::class.'->delete');
