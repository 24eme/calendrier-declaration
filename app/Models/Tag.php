<?php

namespace Models;

use \DB\Cortex;

class Tag extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'tags';

    protected $fillable = ['nom'];

    protected $fieldConf = [
        'nom' => ['type' => \DB\SQL\Schema::DT_VARCHAR128],
        'slug' => ['type' => \DB\SQL\Schema::DT_VARCHAR128],

        // Relations
        'evenements' => [
            'has-many' => [Evenement::class, 'tags', 'evenement_tag',
                'relField' => 'tag_id'
            ]
        ],
    ];

    public function set_nom($nom)
    {
        return trim($nom);
    }

    public function set_slug($slug)
    {
        return \Web::instance()->slug($slug);
    }
}
