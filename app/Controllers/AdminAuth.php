<?php

namespace Controllers;

use Base;
use View;
use Models\Administrateur;

class AdminAuth extends AdminController
{

    public function beforeroute(Base $f3, $params)
    {
    }

    public function index(Base $f3, $params)
    {
        if ($flash = $f3->get('SESSION.flash')) {
            $f3->set('SESSION.flash', null);
        }
        $f3->set('content', 'admin/auth.html.php');
        echo View::instance()->render('layout.html.php', 'text/html', compact('flash'));
    }

    public function authenticate(Base $f3, $params)
    {
        $admin = new Administrateur();
        if (($admin->load(['nom = ?', $f3->get('POST.identifiant')]) === false)||(!password_verify($f3->get('POST.password'), $admin->mot_de_passe))) {
            $f3->set('SESSION.flash', 'Identifiant ou mot de passe incorrect');
            $f3->reroute('@login');
        }
        $f3->set('SESSION.user', $admin->nom);
        $f3->reroute('@home');
    }

    public function logout(Base $f3, $params)
    {
        if ($f3->get('SESSION.user')) {
            $f3->set('SESSION.user', null);
        }
        $f3->reroute('@home');
    }
}
