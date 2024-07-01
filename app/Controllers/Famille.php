<?php

namespace Controllers;

use Models\Famille as F;

class Famille extends Controller
{
    private $famille;

    public function beforeroute($f3, $params)
    {
        if ($familleID = $f3->get('PARAMS.famille')) {
            $this->famille = new F();
            if ($this->famille->load(['_id = ?', $familleID]) === false) {
                return $this->f3->error(404, "La famille n'existe pas");
            }
        }
    }

    public function index($f3, $params)
    {
        $familles = new F();

        echo "<ul>";
        foreach ($familles->find() as $famille) {
            echo "<li>".$famille->nom.' <a href='.$f3->alias('familleedit', ['famille' => $famille->id]).'>Editer</a></li>';
        }
        echo '</ul>';
    }

    public function new($f3, $params)
    {
        $this->famille = new F();

        if ($f3->get('VERB') === 'GET') {
            $f3->set('formurl', $f3->alias('famillecreate'));
            return $this->edit($f3, $params);
        }

        $this->famille->copyfrom('POST', $this->famille->fillable);
        $this->famille->slug = $this->famille->nom;
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
        $this->famille->slug = $this->famille->nom;
        $this->famille->save();

        return $f3->reroute('@familleedit');
    }

    public function delete($f3, $params)
    {
        $this->famille->erase();
        return $f3->reroute('@famillelist');
    }
}
