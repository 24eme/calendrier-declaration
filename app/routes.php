<?php

use Controllers\Calendrier;
use Controllers\Evenement;
use Controllers\Famille;
use Controllers\Organisme;

$f3 = \Base::instance();

$f3->route('GET /', Calendrier::class.'->home');

$f3->route('GET      @event:       /evenement/show/@evenement', Calendrier::class.'->show');

$f3->route('GET      @eventlist:   /admin/evenements', Evenement::class.'->index');
$f3->route('GET|POST @eventcreate: /admin/evenement/create', Evenement::class.'->new');
$f3->route('GET      @eventedit:   /admin/evenement/edit/@evenement', Evenement::class.'->edit');
$f3->route('POST     @eventupdate: /admin/evenement/update/@evenement', Evenement::class.'->update');
$f3->route('GET      @eventdelete: /admin/evenement/delete/@evenement', Evenement::class.'->delete');

$f3->route('GET      @organismelist:   /admin/organismes', Organisme::class.'->index');
$f3->route('GET|POST @organismecreate: /admin/organismes/create', Organisme::class.'->new');
$f3->route('GET      @organismeedit:   /admin/organismes/edit/@organisme', Organisme::class.'->edit');
$f3->route('POST     @organismeupdate: /admin/organismes/update/@organisme', Organisme::class.'->update');
$f3->route('GET      @organismedelete: /admin/organismes/delete/@organisme', Organisme::class.'->delete');

$f3->route('GET      @famillelist:   /admin/familles', Famille::class.'->index');
$f3->route('GET|POST @famillecreate: /admin/familles/create', Famille::class.'->new');
$f3->route('GET      @familleedit:   /admin/familles/edit/@famille', Famille::class.'->edit');
$f3->route('POST     @familleupdate: /admin/familles/update/@famille', Famille::class.'->update');
$f3->route('GET      @familledelete: /admin/familles/delete/@famille', Famille::class.'->delete');
