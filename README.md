# Projet Société d'espionnage TRT Conseil

# Sommaire

* [Détails du projet](#détails-du-projet)
* [Déploiement](#déploiement)
* [Installation en local](#installation-en-local)

# Détails du projet

## Objectif/Exigences

L’objectif est de créer un site internet permettant la gestion des données d'une société d'espionnage.

## Exigences

Les agents ont un nom, un prénom, une date de naissance, un code d'identification, une nationalité, 1 ou plusieurs spécialités.
- Les cibles ont un nom, un prénom, une date de naissance, un nom de code, une nationalité.
- Les contacts ont un nom, un prénom, une date de naissance, un nom de code, une nationalité.
- Les planques ont un code, une adresse, un pays, un type.
- Les missions ont un titre, une description, un nom de code, un pays, 1 ou plusieurs agents, 1 ou plusieurs contacts, 1 ou plusieurs cibles, un type de mission (Surveillance, Assassinat, Infiltration …), un statut (En préparation, en cours, terminé, échec), 0 ou plusieurs planque, 1 spécialité requise, date de début, date de fin.
-  Les administrateurs ont un nom, un prénom, une adresse mail, un mot de passe, une date de création.


Règle métier :
- Sur une mission, la ou les cibles ne peuvent pas avoir la même nationalité que le ou les agents.
- Sur une mission, les contacts sont obligatoirement de la nationalité du pays de la mission.
- Sur une mission, la planque est obligatoirement dans le même pays que la mission.
- Sur une mission, il faut assigner au moins 1 agent disposant de la spécialité requise.

## Descriptions des fonctionnalités

- créer une interface front-office, accessible à tous, permettant de consulter la liste de toutes les missions, ainsi qu’une page permettant de voir le détail d’une mission.
- créer une interface back-office, uniquement accessible aux utilisateurs de rôle ADMIN, qui va permettre de gérer la base de données de la bibliothèque. Ce back-office va permettre de lister, créer, modifier et supprimer chaque donnée des différentes tables, grâce à des formulaires et des tableaux.

# Déploiement

## Environnement de développement

### Pré-requis

* PHP 8.1
* Symfony 6.1
* Composer
* Symfony CLI
* nodejs et npm

Vous pouvez vérifier les pré-requis avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirements
```

## Installation en local

Pour installer le projet en local. Vous devez avoir un [environnement de développement](https://symfony.com/doc/current/setup.html) correctement configuré.

### Etapes

* Créer votre dossier de travail et cloner le projet.
    ```
    git clone https://github.com/sebastienmariette74/espion.git
    ```
* Créer une copie du .env en le nommant .env.local et modifier le fichier .env.local afin de le rendre compatible avec votre environement. Y intégrer votre propre variable d'environnement ```DATABASE_URL```.

* Installer les dépendances php
    ```
    composer install
    ```
* Installer les dépendances javascript
    ```
    npm install
    ```
* Exécuter les migrations sur la base de données
    ```
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    ```
* Créer un compte administrateur en lançant les fixtures
    ```
    symfony console doctrine:fixtures:load --no-interaction
    ```

* Compiler le javascript
    ```
    npm run build
    ```
* Lancer le projet
    ```
    symfony server:start
    ```
* S'identifier :

    * email : ````admin@gmail.com````
    * mot de passe : ````admin````

## Déploiement sur Heroku

Afin de déployer le projet sur Heroku. Il est important d'avoir créer un compte sur celui-ci.

* Créer une nouvelle aplication avec la cli
    ```
    heroku create (nom de l'appli)
    ```
* Configurer les variables d'environnement
    ```
    heroku config:set APP_ENV=prod
    ```
* Lancer le déploiement
    ```
    git push heroku main
    ```

Pour garantir un déploiement sur Heroku réussi, je vous conseille de passer par le bunddle [nat/deploy](https://packagist.org/packages/nat/deploy). Suivez-les étapes décrites sur le site.
