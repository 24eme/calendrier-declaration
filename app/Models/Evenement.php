<?php

namespace Models;

use \DB\Cortex;

class Evenement extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'evenements';

    public $fillable = ['type_id', 'organismes', 'familles', 'nom', 'description', 'date_debut', 'date_fin', 'textedeloi', 'liendeclaration', 'actif', 'recurrence'];

    public static $displayMonths = 16;

    public static $recurrences = [
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
        'actif' => ['type' => \DB\SQL\Schema::DT_BOOL],
        'recurrence' => ['type' => \DB\SQL\Schema::DT_VARCHAR128, 'nullable' => true],
        'date_creation' => ['type' => \DB\SQL\Schema::DT_DATETIME],
        'date_modification' => ['type' => \DB\SQL\Schema::DT_DATETIME],

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

    private $extra_filter;

    public function __construct()
    {
        $this->beforeupdate(function ($self) {
            $self->touch('date_modification');
        });

        $this->beforeinsert(function ($self) {
            $self->touch('date_creation');
            $self->touch('date_modification');
        });

        $this->extra_filter = [];

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

    public function set_actif($actif)
    {
        return $actif ? true : false;
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

    public function isActif()
    {
        return $this->actif;
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

    public function addFilters($filters = []) {
        if (empty($filters) === false) {
            foreach ($filters as $type => $filter) {
                if ($type === "query") {
                    if ($filter) {
                        $this->extra_filter[] = ['description LIKE ? OR nom LIKE ?', '%'.$filter.'%', '%'.$filter.'%'];
                    }
                    continue;
                }
                $this->has($type, ['id IN ?', $filter]);
            }
        }
    }

    public function find($filter=NULL,?array $options=NULL,$ttl=0) {
        $f = [];
        if ($filter) {
            $f = $filter;
        }
        $f[0] = '('.$f[0].')';
        foreach($this->extra_filter as $e) {
            if (count($f)) {
                $f[0] .= ' AND ';
            }else{
                $f[0] = '';
            }
            $f[0] .= '('.array_shift($e).')';
            foreach( $e as $t) {
                $f[] = $t;
            }
        }
        return parent::find($f, $options, $ttl);
    }

    public function getPourCalendrier(\DateTimeInterface $today, $filters = [])
    {
        $evenementsDates = [];
        $evenementsNonDates = [];
        $stop = $today->modify('last day of '.(self::$displayMonths - 2).' months');
        $this->addFilters($filters);
        $evenements = $this->find(['actif = ?', 1]);
        if ($evenements) foreach ($evenements as $evenement) {
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

            if(in_array($evenement->recurrence, array('mensuel', 'trimestriel', 'semestriel', 'annuel'))) {
                while($dateFin <= $stop || $dateDebut <= $stop) {
                   if ($dateFin->format('Y') >= $today->format('Y')) {
                       $e = clone $evenement;
                       $e->date_debut = $dateDebut->format('Y-m-d');
                       $e->date_fin = $dateFin->format('Y-m-d');
                       $evts[] = $e;
                   }
                   if ($evenement->recurrence == 'mensuel') {
                        $dateDebut->modify('+1 month');
                        $dateFin->modify('+1 month');
                   }
                   if ($evenement->recurrence == 'trimestriel') {
                       $dateDebut->modify('+3 months');
                       $dateFin->modify('+3 months');
                   }
                   if ($evenement->recurrence == 'semestriel') {
                       $dateDebut->modify('+6 months');
                       $dateFin->modify('+6 months');
                   }
                   if ($evenement->recurrence == 'annuel') {
                       $dateDebut->modify('+1 year');
                       $dateFin->modify('+1 year');
                   }
                 }
            } else {
                if ($dateFin->format('Y') >= $today->format('Y')) {
                    $evts[] = $evenement;
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
