<?php

namespace Models;

use \DB\Cortex;

class Evenement extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'evenements';

    public $fillable = ['type_id', 'organismes', 'familles', 'nom', 'description', 'start', 'end', 'textedeloi', 'liendeclaration', 'active', 'rrule'];

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
        'start' => ['type' => \DB\SQL\Schema::DT_DATE, 'nullable' => true],
        'end' => ['type' => \DB\SQL\Schema::DT_DATE, 'nullable' => true],
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
        return ($this->end || $this->start);
    }

    public function getDuree()
    {
        if (!$this->start || !$this->end) return null;
        $start = new DateTime($this->start);
        $end = new DateTime($this->end);
        $interval = $start->diff($end);
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

            if (!$evenement->end) {
                $evenement->end = $stop->format('Y-m-d');
            }

            if (!$evenement->start) {
                $evenement->start = $today->modify('first day of january')->format('Y-m-d');
            }

            $evts = [];
            $start = new \DateTime($evenement->start);
            $end = new \DateTime($evenement->end);

            if(in_array($evenement->rrule, array('mensuel', 'trimestriel', 'semestriel', 'annuel'))) {
                while($end <= $stop || $start <= $stop) {
                   if ($end->format('Y') >= $today->format('Y')) {
                       $evts[] = ['start' => $start->format('Y-m-d'), 'end' => $end->format('Y-m-d'), 'nom' => $evenement->nom, 'id' => $evenement->id, 'isDate' => $isDate];
                   }
                   if ($evenement->rrule == 'mensuel') {
                        $start->modify('+1 month');
                        $end->modify('+1 month');
                   }
                   if ($evenement->rrule == 'trimestriel') {
                       $start->modify('+3 months');
                       $end->modify('+3 months');
                   }
                   if ($evenement->rrule == 'semestriel') {
                       $start->modify('+6 months');
                       $end->modify('+6 months');
                   }
                   if ($evenement->rrule == 'annuel') {
                       $start->modify('+1 year');
                       $end->modify('+1 year');
                   }
                 }
            } else {
                if ($end->format('Y') >= $today->format('Y')) {
                    $evts[] = ['start' => $evenement->start, 'end' => $evenement->end, 'nom' => $evenement->nom, 'id' => $evenement->id, 'isDate' => $isDate];
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
