# projet-clicks-n-co

## Cloner le projet
git clone git@github.com:O-clock-Wonderland/projet-clicks-n-co.git

## Installation des dépendances
composer install

## Fichier d'environnement local
- Création d'un fichier .env.local
- DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7" (modifier db_user:db_password, db_name, et serverVersion)

## Création de la base de données
bin/console d:d:c

## Migration en bdd
bin/console d:mi:mi

## Envoi de fixtures en bdd
bin/console d:f:l

## lancement serveur local
php -S 0.0.0.0:8080 -t public
