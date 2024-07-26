<?php

namespace Controllers;

use Models\Evenement as Event;
use Models\Famille;
use Models\Organisme;
use Models\Tag;
use Models\Type;

class Evenement extends Controller
{
    private $event;

    public function beforeroute($f3, $params)
    {
        parent::beforeroute($f3, $params);

        if ($evenementID = $f3->get('PARAMS.evenement')) {
            $this->event = new Event();
            $this->event->countRel('tags');
            if ($this->event->load(['_id = ?', $evenementID]) === false) {
                return $f3->error(404, "L'évènement n'existe pas");
            }
        }
    }

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

    public function new($f3, $params)
    {
        $this->event = new Event();

        if ($f3->get('VERB') === 'GET') {
            $f3->set('formurl', $f3->alias('eventcreate'));
            return $this->edit($f3, $params);
        }

        $this->event->copyfrom('POST', $this->event->fillable);
        $this->event->active = $f3->get('POST.active');
        $this->event->tags = $f3->get('POST.tags');
        $this->event->save();

        return $f3->reroute(['eventedit', ['evenement' => $this->event->id]]);
    }

    public function edit($f3, $params)
    {
        $familles = new Famille();
        $organismes = new Organisme();
        $tags = new Tag();
        $types = new Type();
        $event = $this->event;
        $formurl = $f3->get('formurl') ?: $f3->alias('eventupdate', ['evenement' => $this->event->id]);

        $f3->set('content', 'admin/evenement/edit.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('formurl', 'event', 'familles', 'organismes', 'tags', 'types'));
    }

    public function update($f3, $params)
    {
        $this->event->copyfrom('POST', $this->event->fillable);
        $this->event->active = $f3->get('POST.active');
        $this->event->tags = $f3->get('POST.tags');
        $this->event->save();

        return $f3->reroute('@eventedit');
    }

    public function delete($f3, $params)
    {
        $this->event->erase();
        return $f3->reroute('@eventlist');
    }
}
