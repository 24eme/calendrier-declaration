<?php

namespace Views;

use Prefab, View, Base;
use Models\{Organisme, Famille, Tag};

class Sidebar extends Prefab
{
    protected $data = [];

    public function __construct()
    {
        $this->data['familles'] = new Famille();
        $this->data['organismes'] = new Organisme();
        $this->data['tags'] = new Tag();
    }

    public function render()
    {
        Base::instance()->mset($this->data);
        echo View::instance()->render('sidebar.html.php');
    }
}
