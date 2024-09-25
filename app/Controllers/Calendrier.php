<?php

namespace Controllers;

use Base;
use Models\Evenement;
use Models\Organisme;

class Calendrier extends Controller
{
    public function home(Base $f3)
    {
        $evenement = new Evenement();
        $year = $f3->get('GET.annee') ?:  date('Y');
        $today = new \DateTimeImmutable();
        $start = $today;
        if ($year != date('Y')) {
            $start = new \DateTimeImmutable("$year-01-01");
        }
        $evenementsByTpe = $evenement->getPourCalendrier($start, $f3->get('filters'));
        $timeline = $evenement->getPourTimeline($evenementsByTpe, $start);
        $f3->push('mainCssClass', 'main-calendar');
        $f3->set('content', 'home.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenementsByTpe', 'timeline', 'today', 'year'));
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
        $today = new \DateTimeImmutable();
        $evenement->addFilters($f3->get('filters'));
        $evenements = $evenement->find($evenement->computeFilters(), ['order' => 'evenements.nom ASC']);
        $f3->set('content', 'eventslist.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('evenements', 'today'));
    }

    public function timeline(Base $f3)
    {
        $evenement = new Evenement();
        $today = new \DateTimeImmutable();
        $timeline = $evenement->getPourTimeline($evenement->getPourCalendrier($today, $f3->get('filters')), $today);
        $f3->set('content', 'timeline.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('timeline', 'today'));
    }

    public function getLogoOrganisme($f3, $params)
    {
        $organisme = new Organisme();
        if ($organisme->load(['_id = ?', $f3->get('PARAMS.organisme')]) === false) {
            return $f3->error(404, "L'organisme n'existe pas");
        }

        $image = @imagecreatefromstring($organisme->logo);
        if (! $image) {
            return $f3->error('No image');
        }

        $infos = getimagesizefromstring($organisme->logo);
        if ($infos) {
            header("Content-Type: ".$infos['mime']);
        }

        $format = str_replace('image/', '', $infos['mime']);

        return call_user_func_array(
            'image'.$format,
            [$image, null, -1, -1]
        );
    }

    public function statics(Base $f3)
    {
        $page = $f3->get('PARAMS.page');
        $f3->set('content', 'statics.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('page'));
    }
}
