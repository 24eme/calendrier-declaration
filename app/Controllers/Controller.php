<?php

namespace Controllers;

use Base;

abstract class Controller
{
    public function __construct(Base $f3)
    {
        $f3->set('mainCssClass', ['col']);
    }

    public function beforeroute($f3, $params) {}
    public function afterroute($f3, $params) {}
}
