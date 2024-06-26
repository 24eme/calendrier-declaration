<?php

namespace Models;

use \DB\Cortex;

class Famille extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'familles';

    protected $fillable = ['nom', 'description'];

    protected $fieldConf = [
        'nom' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => false],
        'description' => ['type' => \DB\SQL\Schema::DT_LONGTEXT, 'nullable' => true],
        'couleur' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'slug' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => false],

        // Relations
        'evenements' => [
            'has-many' => [Evenement::class, 'familles', 'evenement_famille',
                'relField' => 'famille_id'
            ]
        ],
    ];

    public function set_slug($slug)
    {
        return \Web::instance()->slug($slug);
    }
}
