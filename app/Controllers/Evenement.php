<?php

namespace Controllers;

use Models\Evenement as Event;
use Models\Famille;
use Models\Organisme;
use Models\Tag;
use Models\Type;

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
            echo "<span style='background-color: #F00'>".$event->type_id->name."</span>";
            echo '</li>';
        }
        echo '</ul>';
    }

    public function edit($f3, $params)
    {
        $evenementID = $this->f3->get('PARAMS.evenement');

        $event = new Event();
        $event->countRel('tags');
        if ($event->load(['_id = ?', $evenementID]) === false) {
            return $this->f3->error(404, "L'évnèment n'existe pas");
        }

        $familles = new Famille();
        $organismes = new Organisme();
        $tags = new Tag();
        $types = new Type();
        $f3 = $this->f3;

        echo \View::instance()->render('admin/evenement/edit.html.php', 'text/html', compact('f3', 'event', 'familles', 'organismes', 'tags', 'types'));
    }

    public function update($f3, $params)
    {
        $evenementID = $f3->get('PARAMS.evenement');

        $event = new Event();
        if ($event->load(['_id = ?', $evenementID]) === false) {
            return $this->f3->error(404, "L'évnèment n'existe pas");
        }

        $event->copyfrom('POST', $event->fillable);
        $event->active = $f3->get('POST.active');
        $event->tags = $f3->get('POST.tags');
        $event->save();

        return $f3->reroute('@eventedit');
    }
}
