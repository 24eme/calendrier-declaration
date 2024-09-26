# Calendrier des déclarations viticoles et vinicoles

## Installation

Installation des dépendances :
```
sudo apt-get install php php-sqlite3
```

Lancer le projet, via la console :

```
php -S localhost:8000 -t public
```

Personnaliser la configuration en créant le fichier `app/config.ini` (les valeurs par défaut sont ici : [https://github.com/24eme/calendrier-declaration/tree/master/app](https://github.com/24eme/calendrier-declaration/blob/master/app/default.ini)) :

```
# Changer le niveau de debug : 0 (by default) sans debug et 3 le plus verbeux :
DEBUG=3

# Changer le thème relatif à un dossier existant ici https://github.com/24eme/calendrier-declaration/tree/master/views/themes :
theme=yourtheme

 # Changer le nom l'emplacement de la base de données sqlite :
dsn=sqlite:../db/yourdatabasename.sqlite
```

## License

Logiciel libre sous license AGPL V3
