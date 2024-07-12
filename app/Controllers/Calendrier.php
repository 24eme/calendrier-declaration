<?php

namespace Controllers;

use Base;
use Models\Evenement;

class Calendrier extends Controller
{
    public function home(Base $f3)
    {
        $evenement = new Evenement();
        $evenements = $evenement->getPourCalendrier(date('Y'));

        $f3->set('filters', $f3->get('GET.filters') ?? []);

        $f3->set('content', 'home.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenements'));
    }
}
