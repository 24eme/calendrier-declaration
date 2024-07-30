<?php

namespace Controllers;

use Base;
use Models\Evenement;

class Calendrier extends Controller
{
    public function home(Base $f3)
    {
        $evenement = new Evenement();
        $today = new \DateTimeImmutable();
        $evenements = $evenement->getPourCalendrier($today, $f3->get('filters'));

        $f3->push('mainCssClass', 'main-calendar');
        $f3->set('displaySideNavigation', 'd-block');

        $f3->set('content', 'home.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenements', 'today'));
    }

    public function show(Base $f3)
    {
        $evenementID = $f3->get('PARAMS.evenement');
        $event = new Evenement();
        if ($event->load(['_id = ?', $evenementID]) === false) {
            return $f3->error(404, "L'évènement n'existe pas");
        }

        $f3->set('content', 'calendrier/evenement.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('event'));
    }

    public function eventsList(Base $f3)
    {
        $evenement = new Evenement();
        $evenements = $evenement->find(['active = ?', 1], ['order' => 'title ASC']);
        $f3->set('content', 'eventslist.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenements'));
    }
}
