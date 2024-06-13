<?php

namespace Controllers;

abstract class Controller
{
    protected $f3 = null;

    public function __construct()
    {
        $this->f3 = \Base::instance();
    }

    abstract public function beforeroute($f3, $params);
    public function afterroute() {}
}
