<?php

namespace Controllers;

use Models\Evenement;

class Calendrier extends Controller
{
    public function home($f3)
    {
        $evenement = new Evenement();
        $evenements = $evenement->getPourCalendrier(date('Y'));
        $f3->set('content', 'home.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenements'));
    }
}
