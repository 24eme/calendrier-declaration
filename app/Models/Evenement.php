<?php

namespace Models;

use \DB\Cortex;

class Evenement extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'evenements';

    public $fillable = ['type_id', 'organismes', 'familles', 'nom', 'description', 'date_debut', 'date_fin', 'textedeloi', 'liendeclaration', 'active', 'rrule'];

    public static $displayMonths = 16;

    public static $rrules = [
        '' => 'Aucune',
        'mensuel' => 'Tous les mois',
        'trimestriel' => 'Tous les 3 mois',
        'semestriel' => 'Tous les 6 mois',
        'annuel' => 'Tous les ans'
    ];

    protected $fieldConf = [
        'nom' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'nullable' => false, 'index' => true],
        'date_debut' => ['type' => \DB\SQL\Schema::DT_DATE, 'nullable' => true],
        'date_fin' => ['type' => \DB\SQL\Schema::DT_DATE, 'nullable' => true],
        'description' => ['type' => \DB\SQL\Schema::DT_TEXT, 'nullable' => false, 'index' => true],
        'textedeloi' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'nullable' => true],
        'liendeclaration' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'nullable' => true],
        'active' => ['type' => \DB\SQL\Schema::DT_BOOL],
        'rrule' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'created_at' => ['type' => \DB\SQL\Schema::DT_DATETIME],
        'updated_at' => ['type' => \DB\SQL\Schema::DT_DATETIME],

        // Relations
        'type_id' => ['belongs-to-one' => Type::class, 'index' => true],
        'organismes' => ['has-many' => [Organisme::class, 'evenements', 'evenement_organisme', 'relField' => 'evenement_id']],
        'tags' => [
            'has-many' => [Tag::class, 'evenements', 'evenement_tag',
                'relField' => 'evenement_id'
            ]
        ],
        'familles' => ['has-many' => [Famille::class, 'evenements', 'evenement_famille', 'relField' => 'evenement_id']],
    ];

    public function __construct()
    {
        $this->beforeupdate(function ($self) {
            $self->touch('updated_at');
        });

        $this->beforeinsert(function ($self) {
            $self->touch('created_at');
            $self->touch('updated_at');
        });

        parent::__construct();
    }

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

    public function set_active($active)
    {
        return $active ? true : false;
    }

    public function getTags()
    {
        if (! $this->count_tags) {
            return '';
        }

        $t = [];
        foreach ($this->tags as $tag) {
            $t[] = $tag->nom;
        }

        return implode(', ', $t);
    }

    public function set_tags($tags)
    {
        if (! is_array($tags)) {
            $tags = explode(',', $tags);
        }

        if (! is_array($tags)) {
            $tags = [$tags];
        }

        $tags = array_map('trim', $tags);
        $tags = array_filter($tags, 'strlen');

        if (empty($tags)) {
            return;
        }

        foreach ($tags as $tag) {
            $tagModel = new Tag();
            $tagModel->load(['nom = ?', $tag]);

            if ($tagModel->dry()) {
                $tagModel->nom = $tag;
                $tagModel->save();
            }

            $t[] = $tagModel->id;
        }

        return $t;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function isDate()
    {
        return ($this->date_fin || $this->date_debut);
    }

    public function getDuree()
    {
        if (!$this->date_debut || !$this->date_fin) return null;
        $dateDebut = new DateTime($this->date_debut);
        $dateFin = new DateTime($this->date_fin);
        $interval = $dateDebut->diff($dateFin);
        return $interval->days;
    }

    public function getPourCalendrier(\DateTimeInterface $today, $filters = [])
    {
        $evenementsDates = [];
        $evenementsNonDates = [];
        $stop = $today->modify('last day of '.(self::$displayMonths - 2).' months');

        if (empty($filters) === false) {
            foreach ($filters as $type => $filter) {
                if ($type === "query") { continue; }
                if ($type === "tags") { $filter = array_keys($filter); }
                $this->has($type, ['id IN ?', $filter]);
            }
        }

        $evenements = $this->find();
        foreach ($evenements as $evenement) {
            if (!$evenement->isActive()) continue;
            $isDate = $evenement->isDate(); // à une date de début ou de fin ?

            if (!$evenement->date_fin) {
                $evenement->date_fin = $stop->format('Y-m-d');
            }

            if (!$evenement->date_debut) {
                $evenement->date_debut = $today->modify('first day of january')->format('Y-m-d');
            }

            $evts = [];
            $dateDebut = new \DateTime($evenement->date_debut);
            $dateFin = new \DateTime($evenement->date_fin);

            if(in_array($evenement->rrule, array('mensuel', 'trimestriel', 'semestriel', 'annuel'))) {
                while($dateFin <= $stop || $dateDebut <= $stop) {
                   if ($dateFin->format('Y') >= $today->format('Y')) {
                       $evts[] = ['date_debut' => $dateDebut->format('Y-m-d'), 'date_fin' => $dateFin->format('Y-m-d'), 'nom' => $evenement->nom, 'id' => $evenement->id, 'isDate' => $isDate];
                   }
                   if ($evenement->rrule == 'mensuel') {
                        $dateDebut->modify('+1 month');
                        $dateFin->modify('+1 month');
                   }
                   if ($evenement->rrule == 'trimestriel') {
                       $dateDebut->modify('+3 months');
                       $dateFin->modify('+3 months');
                   }
                   if ($evenement->rrule == 'semestriel') {
                       $dateDebut->modify('+6 months');
                       $dateFin->modify('+6 months');
                   }
                   if ($evenement->rrule == 'annuel') {
                       $dateDebut->modify('+1 year');
                       $dateFin->modify('+1 year');
                   }
                 }
            } else {
                if ($dateFin->format('Y') >= $today->format('Y')) {
                    $evts[] = ['date_debut' => $evenement->date_debut, 'date_fin' => $evenement->date_fin, 'nom' => $evenement->nom, 'id' => $evenement->id, 'isDate' => $isDate];
                }
            }
            if (!$evts) continue;
            if ($isDate) {
                $evenementsDates[$evenement->nom] = $evts;
            } else {
                $evenementsNonDates[$evenement->nom] = $evts;
            }
        }
        ksort($evenementsDates);
        ksort($evenementsNonDates);
        return $evenementsDates + $evenementsNonDates;
    }
}
