<?php

namespace Models;

use \DB\Cortex;

class Evenement extends Cortex
{
    protected $db = 'DB';
    protected $table = 'evenements';

    protected $fillable = ['type_id', 'organismes', 'familles', 'tags', 'title', 'description', 'start', 'end', 'textedeloi', 'liendeclaration', 'active', 'rrule'];

    // Relations
    protected $fieldConf = [
        'type_id' => ['belongs-to-one' => Type::class],
        'organismes' => ['has-many' => [Organisme::class, 'evenements', 'evenement_organisme', 'relField' => 'evenement_id']],
        'tags' => [
            'has-many' => [Tag::class, 'evenements', 'evenement_tag',
                'relField' => 'evenement_id'
            ]
        ],
        'familles' => ['has-many' => [Famille::class, 'evenements', 'evenement_famille', 'relField' => 'evenement_id']],
    ];
}
