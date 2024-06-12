<?php

namespace Models;

use \DB\Cortex;

class Famille extends Cortex
{
    protected $db = 'DB';
    protected $table = 'familles';

    protected $fillable = ['nom', 'description'];

    // Relations
    protected $fieldConf = [
        'evenements' => [
            'has-many' => [Evenement::class, 'familles', 'evenement_famille',
                'relField' => 'famille_id'
            ]
        ],
    ];
}
