# Readme .md / .txt

- Chargement des images publiques de la NASA par Astres du systeme solaire

# Choix Techniques

- Symfony / MySQL /Twig

# Prérequis 

- php 
- mysql
- composer
- symfony

# Installation

- git clone :https://github.com/davidBoyaval/evalBack.git
- .env: ajouter les parametre de votre BDD

customize this line!
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

console dans dossier du projet:

- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate

#Utilisation 

-symfony server:start

-localhost:8000 

# Initialisation (script quelconque de remplissage de quelques données)

- localhost:8000/astre/api_getAstre


- Objectifs bonus visés

