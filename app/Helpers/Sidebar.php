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
        Base::instance()->set('route', $route);
        echo View::instance()->render('sidebar.html.php');
    }

    public function getTags($filtres) {
        if (! isset($filtres['tags']) || empty($filtres['tags'])) {
            foreach ($this->data['tags']->find() as $all) {
                yield $all;
            }

            return;
        }

        foreach ($this->data['tags']->find(['id IN ?', array_keys($filtres['tags'])]) as $tagged) {
            yield $tagged;
        }

        foreach ($this->data['tags']->find(['id not IN ?', array_keys($filtres['tags'])]) as $nottagged) {
            yield $nottagged;
        }
    }
}
