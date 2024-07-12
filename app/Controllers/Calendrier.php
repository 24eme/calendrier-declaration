<?php

namespace Controllers;

use Base;
use Models\Evenement;

class Calendrier extends Controller
{
    public function home(Base $f3)
    {
        $filters = $f3->get('GET.filters') ?? [];
        $evenement = new Evenement();
        $evenements = $evenement->getPourCalendrier(date('Y'), $filters);

        $f3->set('filters', $filters);

        $f3->set('content', 'home.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenements'));
    }
}
