<?php

namespace Helpers;

use Prefab, View, Base;
use Models\{Organisme, Famille, Tag};

class Sidebar extends Prefab
{
    protected $data = [];

    public function __construct()
    {
        $this->data['familles'] = new Famille();
        $this->data['organismes'] = new Organisme();
        $this->data['organismes'] = $this->data['organismes']->has('evenements', array('actif'));
        $this->data['tags'] = new Tag();
        $this->data['tags'] = $this->data['tags']->has('evenements', array('actif'));

    }

    public function render()
    {
        Base::instance()->mset($this->data);
        $route = 'home';
        if (strpos(Base::instance()->get('URI'), '/evenements') !== false) {
            $route = 'events';
        }
        if (strpos(Base::instance()->get('URI'), '/chronologie') !== false) {
            $route = 'timeline';
        }
        Base::instance()->set('route', $route);
        echo View::instance()->render('sidebar.html.php');
    }

    public function getTags($filtres) {
        if (! isset($filtres['tags']) || empty($filtres['tags'])) {
            foreach ($this->data['tags']->find(null, ['order' => 'tags.nom COLLATE NOCASE ASC']) as $all) {
                yield $all;
            }

            return;
        }

        foreach ($this->data['tags']->find(['id IN ?', $filtres['tags']], ['order' => 'tags.nom COLLATE NOCASE ASC']) as $tagged) {
            yield $tagged;
        }

        foreach ($this->data['tags']->find(['id not IN ?', $filtres['tags']], ['order' => 'tags.nom COLLATE NOCASE ASC']) as $nottagged) {
            yield $nottagged;
        }
    }
}
