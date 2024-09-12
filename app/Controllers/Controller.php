<?php

namespace Controllers;

use Base;

abstract class Controller
{
    public function __construct(Base $f3)
    {
        $f3->set('mainCssClass', ['col']);
    }

    public function beforeroute(Base $f3, $params)
    {
        $filters = [];
        if ($f3->get('GET.resetfilters')) {
            $f3->set('COOKIE.filters', null);
        }
        if ($f3->get('GET.filters')) {
            $filters = $f3->get('GET.filters');
            $f3->set('COOKIE.filters', http_build_query($filters));
        } elseif ($f3->get('COOKIE.filters')) {
            parse_str($f3->get('COOKIE.filters'), $filters);
        }
        $f3->set('filters', $filters);
        $f3->set('activefiltersparams', http_build_query(array('filters' => $filters)));
    }

    public function afterroute($f3, $params) {}
}
