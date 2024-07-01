<?php

namespace Models;

use \DB\Cortex;

class Type extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'types';

    protected $fillable = ['name'];

    protected $fieldConf = [
        'name' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'unique' => true],
        'couleur' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'slug' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'unique' => true],

        // Relations
        'evenements' => [
            'has-many' => [Evenement::class, 'type_id']
        ],
    ];
}
