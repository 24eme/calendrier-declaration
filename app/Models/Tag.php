<?php

namespace Models;

use \DB\Cortex;

class Tag extends Cortex
{
    protected $db = 'DB';
    protected $table = 'tags';

    protected $fillable = ['nom'];

    // Relations
    protected $fieldConf = [
        'evenements' => [
            'has-many' => [Evenement::class, 'tags', 'evenement_tag',
                'relField' => 'tag_id'
            ]
        ],
    ];
}
