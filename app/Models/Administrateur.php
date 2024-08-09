<?php

namespace Models;

use \DB\Cortex;

class Administrateur extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'administrateurs';

    protected $fillable = ['nom', 'mot_de_passe'];

    protected $fieldConf = [
        'nom' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'unique' => true, 'nullable' => false],
        'mot_de_passe' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'nullable' => false],
    ];
}
