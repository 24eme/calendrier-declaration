<?php

class DBManager
{
    public static function init($dsn)
    {
        $db = null;

        try {
            $db = new \DB\SQL($dsn);
            \Base::instance()->set('DB', $db);
        } catch (PDOException $e) {
            die("Fatal error while creating PDO connexion: ".$e->getMessage());
        }

        if (! $db->schema('evenements') && \Base::instance()->get('db.create') === true) {
            \Models\Evenement::setup();
            \Models\Organisme::setup();
            \Models\Type::setup();
            \Models\Tag::setup();
            \Models\Famille::setup();

            foreach (['Obligation', 'Autre'] as $type) {
                $t = new \Models\Type();
                $t->nom = $type;
                $t->save();
            }
        }

        return $db;
    }
}
