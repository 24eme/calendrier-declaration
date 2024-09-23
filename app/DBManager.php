<?php

class DBManager
{
    const DATASET_FILE = '../sql/dataset.sql';

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

            if (file_exists(self::DATASET_FILE)) {
                if ($dataset = file_get_contents(self::DATASET_FILE)) {
                    $result = $db->exec(explode(PHP_EOL, $dataset));
                }
            }
        }

        return $db;
    }
}
