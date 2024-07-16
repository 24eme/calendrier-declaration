<?php

namespace Models;

use \DB\Cortex;

class Evenement extends Cortex
{
    use EmptyArrayFindTrait;

    protected $db = 'DB';
    protected $table = 'evenements';

    public $fillable = ['type_id', 'organismes', 'familles', 'title', 'description', 'start', 'end', 'textedeloi', 'liendeclaration', 'active', 'rrule'];

    public static $rrules = [
        '' => 'Aucune',
        'mensuel' => 'Tous les mois',
        'trimestriel' => 'Tous les 3 mois',
        'semestriel' => 'Tous les 6 mois',
        'annuel' => 'Tous les ans'
    ];

    protected $fieldConf = [
        'title' => ['type' => \DB\SQL\Schema::DT_VARCHAR256, 'nullable' => false, 'index' => true],
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
                $tagModel->slug = $tag;
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

    public function getPourCalendrier($year, $filters = [])
    {
        $evenementsDates = [];
        $evenementsNonDates = [];

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
            $isDate = $evenement->isDate();
            if (!$evenement->end) {
                $evenement->end = date('Y').'-12-31';
            }
            if (!$evenement->start) {
                $evenement->start = date('Y').'-01-01';
            }
            $evts = [];
            $start = new \DateTime($evenement->start);
            $end = new \DateTime($evenement->end);
            if(in_array($evenement->rrule, array('mensuel', 'trimestriel', 'semestriel', 'annuel'))) {
                $stop = date('Y').'-12-31';
                while($end->format('Y-m-d') < $stop) {
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
                   if ($end->format('Y') >= $year) {
                       $evts[] = ['start' => $start->format('Y-m-d'), 'end' => $end->format('Y-m-d'), 'title' => $evenement->title, 'id' => $evenement->id, 'isDate' => $isDate];
                   }
                 }
            } else {
                if ($end->format('Y') >= $year) {
                    $evts[] = ['start' => $evenement->start, 'end' => $evenement->end, 'title' => $evenement->title, 'id' => $evenement->id, 'isDate' => $isDate];
                }
            }
            if (!$evts) continue;
            if ($isDate) {
                $evenementsDates[$evenement->title] = $evts;
            } else {
                $evenementsNonDates[$evenement->title] = $evts;
            }
        }
        ksort($evenementsDates);
        ksort($evenementsNonDates);
        return $evenementsDates + $evenementsNonDates;
    }
}
