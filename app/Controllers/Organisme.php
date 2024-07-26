<?php

namespace Controllers;

use Models\Organisme as Org;

class Organisme extends Controller
{
    private $organisme;

    public function beforeroute($f3, $params)
    {
        parent::beforeroute($f3, $params);

        if ($organismeID = $f3->get('PARAMS.organisme')) {
            $this->organisme = new Org();
            if ($this->organisme->load(['_id = ?', $organismeID]) === false) {
                return $this->f3->error(404, "L'organisme n'existe pas");
            }
        }
    }

    public function index($f3, $params)
    {
        $organismes = new Org();

        echo "<ul>";
        foreach ($organismes->find() as $organisme) {
            echo "<li>".$organisme->nom.' <a href='.$f3->alias('organismeedit', ['organisme' => $organisme->id]).'>Editer</a></li>';
        }
        echo '</ul>';
    }

    public function new($f3, $params)
    {
        $this->organisme = new Org();

        if ($f3->get('VERB') === 'GET') {
            return $this->edit($f3, $params);
        }

        $this->organisme->copyfrom('POST', $this->organisme->fillable);
        $this->organisme->visible_filtre = $f3->get('POST.visible_filtre');
        $this->organisme->save();

        return $f3->reroute(['organismeedit', ['organisme' => $this->organisme->id]]);
    }

    public function edit($f3, $params)
    {
        $organisme = $this->organisme;
        $formurl = $f3->get('formurl') ?: $f3->alias('organismeupdate', ['organisme' => $this->organisme->id]);

        $f3->set('content', 'admin/organisme/edit.html.php');
        echo \View::instance()->render('layout.html.php', 'text/html', compact('formurl', 'organisme'));
    }

    public function update($f3, $params)
    {
        $this->organisme->copyfrom('POST', $this->organisme->fillable);
        $this->organisme->visible_filtre = $f3->get('POST.visible_filtre');
        $this->organisme->save();

        return $f3->reroute('@organismeedit');
    }

    public function delete($f3, $params)
    {
        $this->organisme->erase();
        return $f3->reroute('@organismelist');
    }
}
