[![Codacy Badge](https://api.codacy.com/project/badge/Grade/05b4e0c584d142d2b01718a445b835c8)](https://www.codacy.com/app/Etheram68/NAO_Projet5?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Etheram68/NAO_Projet5&amp;utm_campaign=Badge_Grade)

Nao
===

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/9c30e3214b4b47f8ae98e838099f6d52)](https://app.codacy.com/app/Etheram68/NAO_Projet5?utm_source=github.com&utm_medium=referral&utm_content=Etheram68/NAO_Projet5&utm_campaign=badger)

A Symfony project created on June 3, 2018, 10:26 am.

# Installation
## 1. Récupérer le code
Vous avez deux solutions pour le faire :

1. Via Git, en clonant ce dépôt ;
2. Via le téléchargement du code source en une archive ZIP, à cette adresse : https://github.com/winzou/mooc-symfony/archive/master.zip

*Attention, le code est divisé en plusieurs branches `iteration-XX`. Sur la branche `master` vous n'avez que le tout début du cours, n'hésitez pas à [changer de branche](https://github.com/winzou/mooc-symfony/branches) !*

## 2. Définir vos paramètres d'application
Pour ne pas qu'on se partage tous nos mots de passe, le fichier `app/config/parameters.yml` est ignoré dans ce dépôt. A la place, vous avez le fichier `parameters.yml.dist` que vous devez renommer (enlevez le `.dist`) et modifier.

## 3. Télécharger les vendors
Avec Composer bien évidemment :

    php composer.phar install

## 4. Créez la base de données
Si la base de données que vous avez renseignée dans l'étape 2 n'existe pas déjà, créez-la :

    php bin/console doctrine:database:create

Puis créez les tables correspondantes au schéma Doctrine :

    php bin/console doctrine:schema:update --dump-sql
    php bin/console doctrine:schema:update --force

Enfin, éventuellement, ajoutez les fixtures :

    php bin/console doctrine:fixtures:load

## 5. Publiez les assets
Publiez les assets dans le répertoire web :

    php bin/console assets:install web

