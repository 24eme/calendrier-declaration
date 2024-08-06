<?php

namespace Views;

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
    public static function render(DateTime $date, DateTimeInterface $today, array $evenements)
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

        return View::instance()->render('calendrier/_timeline.html.php',
            'text/html',
            compact('events', 'nbDays', 'today', 'current')
        );
    }

    public static function getTimelineClass($events,
                                            DateTimeInterface $currentDate,
                                            DateTimeInterface $today)
    {
        $class = ['jour'];

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
        }

        $class = array_unique($class);
        return implode(' ', $class);
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
        return $dateLines;
    }

    private static function renderMonthlyDatelines(Evenement $event)
    {
        return 'Chaque mois '.strtolower(self::renderInterval($event, 'd'));
    }

    private static function renderQuarterlyDatelines(Evenement $event)
    {
        return 'Chaque trimestre '.strtolower(self::renderInterval($event, 'd M'));
    }

    private static function renderHalfYearlyDatelines(Evenement $event)
    {
        return 'Chaque semestre '.strtolower(self::renderInterval($event, 'd M'));
    }

    private static function renderYearlyDatelines(Evenement $event)
    {
        return 'Chaque année '.strtolower(self::renderInterval($event, 'd M'));
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
