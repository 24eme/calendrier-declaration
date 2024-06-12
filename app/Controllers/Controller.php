<?php

namespace Controllers;

abstract class Controller
{
    protected $f3 = null;

    public function __construct()
    {
        $this->f3 = \Base::instance();
    }

    public function beforeroute() {}
    public function afterroute() {}
}
