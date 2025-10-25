# ManageVMFront – Application SaaS (Front-End)

## Présentation du projet

Ce projet correspond à la partie **Front** d’une application SaaS destinée à la gestion de machines virtuelles connectée à **Proxmox** via son API.
Le but principal est d’offrir une interface web simple permettant à un utilisateur de :

* créer un compte et se connecter (système d’authentification),
* accéder à un tableau de bord affichant les VMs disponibles,
* visualiser leur état (en ligne, hors ligne, en maintenance),
* interagir avec elles (démarrer, arrêter, supprimer – côté back).

Ce dépôt correspond à la partie **front-end**, développée sous **Symfony**.

## Fonctionnalités réalisées

* Page d’inscription (création de compte) connectée à une base **MariaDB** via Doctrine ORM.
* Page de connexion utilisateur avec gestion d’erreur et persistance de session (option “remember me”).
* Possibilité de connexion via **GitHub OAuth2**.
* Page “tableau de bord” simulée listant des VMs (visuel uniquement pour cette version).
* Protection d’accès : le tableau de bord n’est accessible qu’à un utilisateur connecté.
* Intégration d’un en-tête commun (barre de navigation) affichant le nom de l’utilisateur connecté.

## Structure principale du projet

```
/bin/             → Console Symfony
/config/          → Configuration générale (routes, services, sécurité)
/public/          → Point d’entrée web (index.php, assets publics)
/src/             → Code source principal (contrôleurs, entités, formulaires)
/templates/       → Pages et templates Twig
/var/             → Cache et logs (à ne pas versionner)
/vendor/          → Dépendances installées par Composer
```

## Technologies utilisées

* **Symfony 6**
* **PHP 8**
* **MariaDB**
* **Twig**
* **Pico.css** (mise en forme simple du front)
* **KnpU OAuth2 Client Bundle** (connexion GitHub)
* **Doctrine ORM**

## Configuration minimale

1. Cloner le projet :

   ```bash
   git clone <url_du_repo>
   cd ManageVMFront
   ```

2. Installer les dépendances :

   ```bash
   composer install
   ```

3. Configurer la base de données dans `.env` :

   ```
   DATABASE_URL="mysql://user:password@127.0.0.1:3306/managevm"
   ```

4. Créer la base :

   ```bash
   symfony console doctrine:database:create
   symfony console doctrine:migrations:migrate
   ```

5. Lancer le serveur :

   ```bash
   symfony serve -d
   ```

6. Accès à l’application :

   ```
   http://127.0.0.1:8000
   ```


## Fichiers inutiles à supprimer (optimisation)

Certaines ressources sont générées automatiquement et ne doivent pas être conservées pour alléger le projet.

```
var/cache/
var/log/
vendor/
node_modules/
public/build/
public/bundles/
.idea/
.vscode/
Thumbs.db
.DS_Store
.env.dev.local
.env.test.local
phpunit.xml.dist
```

Ces répertoires peuvent être supprimés avant l’archivage ou le push sur GitHub.
Ils seront régénérés automatiquement par Symfony ou Composer.

## Points d’amélioration

* Connecter réellement le tableau de bord à l’API REST du back-end.
* Intégrer les actions de gestion de VM (start, stop, delete) depuis le front.
* Améliorer la gestion des rôles utilisateurs.
* Ajouter un système de logs plus complet pour le suivi des connexions.

## Auteurs et contexte

Projet réalisé dans le cadre du module **Développement d’une application SaaS**,
avec pour objectif la mise en place d’un **front-end fonctionnel et sécurisé** permettant de s’interfacer avec le back-end Proxmox.

Ce projet m’a permis d’apprendre à :

* utiliser Symfony pour gérer des formulaires et l’authentification,
* comprendre la logique de sécurité et de sessions utilisateur,
* intégrer une authentification externe via GitHub,
* structurer un projet complet avec MVC et Twig.
