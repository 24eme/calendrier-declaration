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

    public function set_nom($nom)
    {
        return trim($nom);
    }

    public function set_slug($slug)
    {
        return \Web::instance()->slug($slug);
    }
}
