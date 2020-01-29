# Penguin Antartic Circus
For penguins in Antartica. 
A mobile circus to prevent the Penguin from the global warming. 

In a few years you will be obliged to live with Humans.
Prepare yourself and discover the Human way of life. 
##Know your enemy habits is the better way to win the battle !
After attending the show, continue to discover Human way on life with our website.

For each article you want to read again, you can choose to add this article to your favorite ones.

##Get started !
### Prerequisites

1. Check if composer is installed
2. Check if yarn & node are installed

### Install

1. Clone this project
2. Create `.env.local` from `.env` and update informations for database and mailer
2. Run `composer install`
3. Run `yarn install`
5. Create database and add fixtures if needed (doctrine:fixtures:load).
```
bin/console doctrine:database:create
bin/console doctrine:migration:migrate
bin/console doctrine:fixtures:load
```

### Working

1. Run `php bin/console server:start` to launch your local php web server
2. Run `yarn run dev --watch` to launch your local server for assets


Paramétrage
=====
### Roles (by Symfony) (security.yaml)

    * ROLE_ADMIN : accès aux routes commençant par admin/ et aux routes accessibles avec profil USER
    * ROLE_USER : accès aux routes publiques
    
### interface grand public
    * focus en page d'accueil sur les 3 articles/évènements du moment
    * lire les articles, découvrir les évènements (spectacle du cirque)
    * réserver pour un évènement depuis la consultation d'un article si connecté
    * mieux connaître le Penguin Antartica Circus
    * se connecter / s'inscrire
    
### interface administration
    * page d'accueil de l'interface d'administration
    * créer / éditer / lister / effacer les thèmes
    * créer / éditer / lister / effacer les mots-clés
    * créer / éditer / lister / effacer les articles
    * créer / éditer / lister / effacer des utilisateurs (admin ou user)
    * créer / éditer / lister / effacer les réservations pour les évènements

### technology framework and library used in this project
`PHP 7.3`, `Symfony5`, `Html5`, `SCSS`, `Bootstrap`, `fortawesome/fontawesome`

database `MySQL`, via `Doctrine` in `Symfony` 

entités : `user`, `article`, `theme`, `reservation`, `keyword`

tables intermédiaires générées : `article_keyword`, `article_theme`, `user_article`