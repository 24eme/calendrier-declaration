<?php

namespace Models;

use \DB\Cortex;

class Organisme extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'organismes';
    public static $uploadDir = __DIR__.'/../../public/images/logos/organismes/';

    protected $fillable = ['nom', 'adresse', 'code_postal', 'ville', 'contact', 'telephone', 'email', 'site', 'couleur'];

    protected $fieldConf = [
        'nom' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'unique' => true, 'nullable' => false],
        'nom_court' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'nullable' => true],
        'adresse' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'nullable' => true],
        'code_postal' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'ville' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'nullable' => true],
        'contact' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'telephone' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'email' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'logo' => ['type' => \DB\SQL\Schema::DT_BLOB, 'nullable' => true],
        'site' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'visible_filtre' => ['type' => \DB\SQL\Schema::DT_BOOL, 'nullable' => false, 'default' => 0],

        // Relations
        'evenements' => [
            'has-many' => [Evenement::class, 'organismes', 'evenement_organisme',
                'relField' => 'organisme_id'
            ]
        ],
    ];

    public function set_visible_filtre($visible)
    {
        return $visible ? true : false;
    }

    public function getNomCourt() {
        return $this->nom_court ?: $this->nom;
    }
}
