# Gusto Coffee - Coffee-Shop Coworking


## Introduction
Gusto Coffee est une application web conçue pour faciliter la réservation des espaces de travail collaboratifs au sein du nouveau coffee-shop coworking de Gusto Coffee situé à Paris. En plus de la réservation, les utilisateurs peuvent choisir parmi différents forfaits de café et de douceurs sucrées.

## Fonctionnalités
- Présentation du coffee-shop, services et tarifs
- Réservation d'espaces de travail individuels ou de salons privés
- Sélection de forfaits café et douceurs
- Authentification persistante
- Interface optimisée pour les appareils mobiles

## Prérequis
- PHP 7.4 ou supérieur
- Composer
- Symfony CLI
- Une base de données MySQL

## Installation
1. Clonez le dépôt
    ```
    git clone https://github.com/Gusto-Coffee/Gusto-Coffee-Coworking.git
    cd Gusto-Coffee-Coworking
    ```
2. Installez les dépendances
    ```
    composer install
    ```
3. Configurez votre base de données dans le fichier `.env`. Par exemple:
    ```
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
    ```
4. Créez la base de données et lancez les migrations
    ```
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```
5. Démarrez le serveur Symfony
    ```
    symfony server:start
    ```
