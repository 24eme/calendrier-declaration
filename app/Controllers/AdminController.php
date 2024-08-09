<?php

namespace Controllers;

use Base;

abstract class AdminController
{
    public function __construct(Base $f3)
    {
        $f3->set('mainCssClass', ['col']);
    }

    public function beforeroute(Base $f3, $params)
    {
        if (!$f3->get('SESSION.user')) {
            $f3->reroute('@login');
        }
    }

    public function afterroute($f3, $params) {}
}
