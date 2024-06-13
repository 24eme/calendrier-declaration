<?php

namespace Models;

use \DB\Cortex;

class Evenement extends Cortex
{
    protected $db = 'DB';
    protected $table = 'evenements';

    protected $fillable = ['type_id', 'organismes', 'familles', 'tags', 'title', 'description', 'start', 'end', 'textedeloi', 'liendeclaration', 'active', 'rrule'];

    public static $rrules = [
        '' => 'Aucune',
        'mensuel' => 'Tous les mois',
        'trimestriel' => 'Tous les 3 mois',
        'semestriel' => 'Tous les 6 mois',
        'annuel' => 'Tous les ans'
    ];

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

    /**
     * @param int
     * @return bool
     */
    public function hasFamille($familleid)
    {
        return $this->familles && $this->familles->contains($familleid);
    }

    /**
     * @param int
     * @return bool
     */
    public function hasOrganisme($organismeid)
    {
        return $this->organismes && $this->organismes->contains($organismeid);
    }

    public function getTags()
    {
        $t = [];
        foreach ($this->tags as $tag) {
            $t[] = $tag->nom;
        }

        return implode(', ', $t);
    }
}
