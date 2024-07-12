<?php

namespace Views;

use View;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

class MonthTimeline
{
    /**
     * @param int $month Mois (1 - 12)
     * @param array $evenements Les évènements à afficher
     */
    public static function render($month, array $evenements)
    {
        $monthStart = sprintf('%02d', $month);
        $monthStart = new DateTimeImmutable(date('Y')."-$monthStart-01");
        $monthEnd = $monthStart->modify('last day of');

        $events = array_filter($evenements, function ($e) use ($monthStart) {
            if ($monthStart >= new DateTimeImmutable($e['start']) && $monthStart <= new DateTimeImmutable($e['end'])) {
                return true;
            }

            return false;
        });

        $nbDays = $monthEnd->format('d');
        $today = new DateTime();
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
            if ($currentDate >= new DateTime($event['start']) && $currentDate <= new DateTime($event['end'])) {
                $class[] = 'active';
            }
        }

        $class = array_unique($class);
        return implode(' ', $class);
    }
}
