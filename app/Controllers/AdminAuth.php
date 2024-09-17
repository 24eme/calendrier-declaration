<?php

namespace Controllers;

use Base;
use View;
use Models\Administrateur;

class AdminAuth
{
    public function login(Base $f3, $params)
    {
        $f3->set('SESSION.user', 'admin');
        $f3->reroute('@home');
    }

    public function logout(Base $f3, $params)
    {
        $f3->set('SESSION.user', null);
        $f3->reroute('@home');
    }
}
