<?php

namespace Controllers;

class Calendrier
{
    private $f3 = null;

    public function __construct()
    {
        $this->f3 = \Base::instance();
    }

    public function home()
    {
        echo "Hello world";
    }
}
