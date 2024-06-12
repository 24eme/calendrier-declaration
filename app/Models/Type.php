<?php

namespace Models;

use \DB\Cortex;

class Type extends Cortex
{
    protected $db = 'DB';
    protected $table = 'types';

    protected $fillable = ['nom'];

    // Relations
    protected $fieldConf = [
        'evenements' => [
            'has-many' => [Evenement::class, 'type_id']
        ],
    ];
}
