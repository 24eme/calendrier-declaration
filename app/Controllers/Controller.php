<?php

namespace Controllers;

abstract class Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->data = [];
    }

    public function beforeroute($f3, $params) {}
    public function afterroute($f3, $params) {}
}
