<?php

namespace Controllers;

use Base;
use View;
use Models\Famille as F;

class AdminFamille extends AdminController
{
    private $famille;

    public function beforeroute(Base $f3, $params)
    {
        parent::beforeroute($f3, $params);

        if ($familleID = $f3->get('PARAMS.famille')) {
            $this->famille = new F();
            if ($this->famille->load(['_id = ?', $familleID]) === false) {
                return $f3->error(404, "La famille n'existe pas");
            }
        }
    }

    public function index(Base $f3, $params)
    {
        $famille = new F();
        $familles = $famille->find();

        $f3->set('content', 'admin/famille/list.html.php');
        echo View::instance()->render('layout.html.php', 'text/html', compact('familles'));
    }

    public function new($f3, $params)
    {
        $this->famille = new F();

        if ($f3->get('VERB') === 'GET') {
            $f3->set('formurl', $f3->alias('famillecreate'));
            return $this->edit($f3, $params);
        }

        $this->famille->copyfrom('POST', $this->famille->fillable);
        $this->famille->save();

        return $f3->reroute(['familleedit', ['famille' => $this->famille->id]]);
    }

    public function edit($f3, $params)
    {
        $famille = $this->famille;
        $formurl = $f3->get('formurl') ?: $f3->alias('familleupdate', ['famille' => $this->famille->id]);

        $f3->set('content', 'admin/famille/edit.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('formurl', 'famille'));
    }

    public function update($f3, $params)
    {
        $this->famille->copyfrom('POST', $this->famille->fillable);
        $this->famille->save();

        return $f3->reroute('@familleedit');
    }

    public function delete($f3, $params)
    {
        $this->famille->erase();
        return $f3->reroute('@famillelist');
    }
}
