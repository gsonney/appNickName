# Application des surnoms des enseignants

## Technologies

- PHP version 8.x.x
- MySQL version 8

## Installation

- Charger le dump de la base de données grâce à la commande suivante : `mysql -uroot -proot < dump_db_nickname.sql`

- Vous devez éditer le fichier `config.php` et renseigner les informations pour la base de données MySQL.

- Ensuite vous devez renommer le fichier `secrets_example.json` en `secrets.json` et renseigner le mot de passe de l'utilisateur de la DB

- Vous pouvez lancer le serveur web de l'interpreter PHP : `php -S localhost:3000`

- Et ouvrir votre navigateur préféré à l'adresse `localhost:3000`