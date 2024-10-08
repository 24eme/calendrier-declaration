<?php

namespace Helpers;

use View;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use \Models\Evenement;

class MonthTimeline
{
    /**
     * @param int $month Mois (1 - 12)
     * @param array $evenements Les évènements à afficher
     */
    public static function render(DateTime $date, DateTimeInterface $today, array $evenements, $type)
    {
        $monthStart = new DateTimeImmutable($date->format('Y-m-d'));
        $monthEnd = $monthStart->modify('last day of');

        $events = array_filter($evenements, function ($e) use ($monthStart) {
            if ($monthStart >= new DateTimeImmutable($e->date_debut) && $monthStart <= new DateTimeImmutable($e->date_fin)) {
                return true;
            }

            return false;
        });

        $nbDays = $monthEnd->format('t');
        $current = new DateTime($monthStart->format('Y-m-d'));

        return View::instance()->render('calendrier/_blocMois.html.php',
            'text/html',
            compact('events', 'nbDays', 'today', 'current', 'type')
        );
    }

    public static function getTimelineClass($events,
                                            DateTimeInterface $currentDate,
                                            DateTimeInterface $today)
    {
        $class = ['jour'];

        if ($today->format('Ymd') > $currentDate->format('Ymd')) {
            $class[] = 'passe';
        }

        if ($today->format('Ymd') == $currentDate->format('Ymd')) {
            $class[] = 'jourcourant';
        }

        foreach ($events as $event) {
            if ($currentDate >= new DateTime($event->date_debut) && $currentDate <= new DateTime($event->date_fin)) {
                $class[] = 'active';
            }
            if ($currentDate == new DateTime($event->date_fin) && $event->isDate()) {
                $class[] = 'jourfin';
            }
            if ($currentDate == new DateTime($event->date_debut) && $event->isDate()) {
                $class[] = 'jourdebut';
            }
        }

        $class = array_unique($class);
        return implode(' ', $class);
    }

    public static function getDateFin($events)
    {
        foreach ($events as $event) {
            if($event->isDate()) {
                return $event->date_fin;
            }
        }

        return false;
    }


    public static function renderDatelines(Evenement $event)
    {
        switch ($event->recurrence) {
            case 'mensuel':
                $dateLines = self::renderMonthlyDatelines($event);
                break;
            case 'trimestriel':
                $dateLines = self::renderQuarterlyDatelines($event);
                break;
            case 'semestriel':
                $dateLines = self::renderHalfYearlyDatelines($event);
                break;
            case 'annuel':
                $dateLines = self::renderYearlyDatelines($event);
                break;
            default:
                $dateLines = self::renderInterval($event);
                break;
        }
        return str_replace(array_keys(Evenement::$months), array_values(Evenement::$months), $dateLines);
    }

    private static function renderMonthlyDatelines(Evenement $event)
    {
        return 'Chaque mois '.strtolower(self::renderInterval($event, 'j'));
    }

    private static function renderQuarterlyDatelines(Evenement $event)
    {
        return 'Chaque trimestre '.strtolower(self::renderInterval($event, 'j F'));
    }

    private static function renderHalfYearlyDatelines(Evenement $event)
    {
        return 'Chaque semestre '.strtolower(self::renderInterval($event, 'j F'));
    }

    private static function renderYearlyDatelines(Evenement $event)
    {
        return 'Chaque année '.strtolower(self::renderInterval($event, 'j F'));
    }

    private static function renderInterval(Evenement $event, $dateFormat = 'd/m/Y')
    {
        if ($event->date_debut && $event->date_fin) {
            return 'Du '.date($dateFormat, strtotime($event->date_debut)).' au '.date($dateFormat, strtotime($event->date_fin));
        }
        if ($event->date_debut && !$event->date_fin) {
            return 'À partir du '.date($dateFormat, strtotime($event->date_debut));
        }
        if (!$event->date_debut && $event->date_fin) {
            return 'Jusqu\'au '.date($dateFormat, strtotime($event->date_fin));
        }
        return 'Toute l\'année';
    }
}
