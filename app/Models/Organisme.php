<?php

namespace Models;

use \DB\Cortex;

class Organisme extends Cortex
{
    protected $db = 'DB';
    protected $table = 'organismes';

    protected $fillable = ['nom', 'adresse', 'code_postal', 'ville', 'contact', 'telephone', 'email', 'site', 'couleur', 'logo', 'visible_filtre'];

    // Relations
    protected $fieldConf = [
        'evenements' => [
            'has-many' => [Evenement::class, 'organismes', 'evenement_organisme',
                'relField' => 'organisme_id'
            ]
        ],
    ];
}
