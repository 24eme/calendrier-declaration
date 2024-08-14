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
        $timeline = $evenement->getPourTimeline($evenements, $today);

        $f3->push('mainCssClass', 'main-calendar');

        $f3->set('content', 'home.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenements', 'today', 'timeline'));
    }

    public function show(Base $f3)
    {
        $evenementID = $f3->get('PARAMS.evenement');
        $referer = $f3->get('GET.referer');
        $event = new Evenement();
        if ($event->load(['_id = ?', $evenementID]) === false) {
            return $f3->error(404, "L'évènement n'existe pas");
        }

        $f3->set('content', 'calendrier/evenement.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('event', 'referer'));
    }

    public function eventsList(Base $f3)
    {
        $evenement = new Evenement();
        $evenement->addFilters($f3->get('filters'));
        $evenements = $evenement->find($evenement->computeFilters(), ['order' => 'evenements.nom ASC']);
        $f3->set('content', 'eventslist.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenements'));
    }
}
