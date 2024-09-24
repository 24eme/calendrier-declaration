<?php

use Controllers\Calendrier;
use Controllers\AdminEvenement;
use Controllers\AdminFamille;
use Controllers\AdminOrganisme;
use Controllers\AdminAuth;

$f3 = \Base::instance();

$f3->route('GET      @home:        /', Calendrier::class.'->home');

$f3->route('GET      @events:      /evenements', Calendrier::class.'->eventsList');
$f3->route('GET      @timeline:    /chronologie', Calendrier::class.'->timeline');
$f3->route('GET      @event:       /evenement/show/@evenement', Calendrier::class.'->show');

$f3->route('GET      @statics:    /pages/@page', Calendrier::class.'->statics');

$f3->route('GET|POST @eventcreate: /admin/evenement/create', AdminEvenement::class.'->new');
$f3->route('GET      @eventedit:   /admin/evenement/edit/@evenement', AdminEvenement::class.'->edit');
$f3->route('POST     @eventupdate: /admin/evenement/update/@evenement', AdminEvenement::class.'->update');
$f3->route('GET      @eventdelete: /admin/evenement/delete/@evenement', AdminEvenement::class.'->delete');

$f3->route('GET      @organismelist:   /admin/organismes', AdminOrganisme::class.'->index');
$f3->route('GET|POST @organismecreate: /admin/organismes/create', AdminOrganisme::class.'->new');
$f3->route('GET      @organismeedit:   /admin/organismes/edit/@organisme', AdminOrganisme::class.'->edit');
$f3->route('POST     @organismeupdate: /admin/organismes/update/@organisme', AdminOrganisme::class.'->update');
$f3->route('GET      @organismedelete: /admin/organismes/delete/@organisme', AdminOrganisme::class.'->delete');
$f3->route('GET      @organismelogo:   /admin/organismes/logo/@organisme', AdminOrganisme::class.'->getLogoOrganisme');

$f3->route('GET      @famillelist:   /admin/familles', AdminFamille::class.'->index');
$f3->route('GET|POST @famillecreate: /admin/familles/create', AdminFamille::class.'->new');
$f3->route('GET      @familleedit:   /admin/familles/edit/@famille', AdminFamille::class.'->edit');
$f3->route('POST     @familleupdate: /admin/familles/update/@famille', AdminFamille::class.'->update');
$f3->route('GET      @familledelete: /admin/familles/delete/@famille', AdminFamille::class.'->delete');

$f3->route('GET      @login: /admin', AdminAuth::class.'->login');
$f3->route('GET      @logout: /logout', AdminAuth::class.'->logout');
