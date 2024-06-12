<?php

namespace Controllers;

use Models\Evenement as Event;

class Evenement extends Controller
{
    public function index()
    {
        $events = new Event();
        echo '<ul>';
        foreach ($events->find() as $event) {
            echo '<li>'.$event->title.': '.PHP_EOL;
            $t = $event->tags ?: [];
            foreach ($t as $tag) {
                echo "\t tag: $tag->nom";
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}
