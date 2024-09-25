<?php

namespace Controllers;

use Base;
use View;
use Image;
use Web;
use Models\Organisme;

class AdminOrganisme extends AdminController
{
    private $organisme;

    public function beforeroute(Base $f3, $params)
    {
        parent::beforeroute($f3, $params);

        if ($organismeID = $f3->get('PARAMS.organisme')) {
            $this->organisme = new Organisme();
            if ($this->organisme->load(['_id = ?', $organismeID]) === false) {
                return $f3->error(404, "L'organisme n'existe pas");
            }
        }
    }

    public function index(Base $f3, $params)
    {
        $organisme = new Organisme();
        $organismes = $organisme->find();

        $f3->set('content', 'admin/organisme/list.html.php');
        echo View::instance()->render('layout.html.php', 'text/html', compact('organismes'));
    }

    public function new($f3, $params)
    {
        $this->organisme = new Organisme();

        if ($f3->get('VERB') === 'GET') {
            $f3->set('formurl', $f3->alias('organismecreate'));
            return $this->edit($f3, $params);
        }

        $this->organisme->copyfrom('POST', $this->organisme->fillable);
        $this->organisme->visible_filtre = $f3->get('POST.visible_filtre');
        $this->organisme->save();

        return $f3->reroute('@organismelist');
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

        if ($f3->get('FILES.logo') && $f3->get('FILES.logo')['size']) {
            $oldUploadDir = $f3->get('UPLOADS');
            $f3->set('UPLOADS', Organisme::$uploadDir);

            $files = Web::instance()->receive(function ($file, $fieldName) {
                if ($fieldName !== 'logo') { return false; }
                if (strpos($file['type'], 'image/') !== 0) { return false; }

                return true;
            }, true);

            foreach ($files as $path => $uploaded) {
                if ($uploaded === false) {
                    continue;
                }

                $image = new Image($path, false, '');
                $this->organisme->logo = $image->dump();
                unlink($path);

            }
            $f3->set('UPLOADS', $oldUploadDir);
        }

        $this->organisme->save();

        return $f3->reroute('@organismelist');
    }

    public function delete($f3, $params)
    {
        $this->organisme->erase();
        return $f3->reroute('@organismelist');
    }
}
