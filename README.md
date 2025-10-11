# ManageVMFront

App MVC qui fait office d'application frontend pour la gestion des machines virtuelles Proxmox VE. 
Ce service fait appelle au middleware [ManageVMBack](https://github.com/ClemLcs/ManageVMBack/tree/develop) pour lister, surveiller et contrôler les VMs Proxmox sur plusieurs nœuds.

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- Symfony 7.x

## 🚀 Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/ClemLcs/ManageVMFront.git
cd ManageVMFront
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer les variables d'environnement

Le fichier `.env` devrait déjà exister. Éditez-le avec vos identifiants Proxmox :

```bash
# Éditer le fichier .env
nano .env
```

**Configurations requises :**

```env
###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=changeme_this_is_a_secret_key_change_it_in_production
###< symfony/framework-bundle ###

###> symfony/routing ###
DEFAULT_URI=http://localhost:8000
###< symfony/routing ###

###> nelmio/cors-bundle ###
# Ajustez cette regex pour correspondre au domaine de votre frontend
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
###< nelmio/cors-bundle ###

```

**⚠️ Notes importantes :**

- `APP_SECRET` : Générez un secret aléatoire pour la production : `php bin/console secrets:generate-keys`


### 4. Vider le cache

```bash
php bin/console cache:clear
```

## 🎮 Démarrage de l'Application

### Serveur de Développement

**Option 1 : Utiliser Symfony CLI (recommandé)**
```bash
symfony server:start
```

**Option 2 : Utiliser le serveur PHP intégré**
```bash
php -S localhost:8000 -t public/
```

L'API sera disponible sur : `http://localhost:8000`

### Production

Pour le déploiement en production, utilisez un serveur web approprié (Apache/Nginx) avec PHP-FPM. Voir la [documentation de déploiement Symfony](https://symfony.com/doc/current/deployment.html).

## 📚 Documentation de l'API

### URL de Base
```
http://localhost:8000/api/v1
```
## 🔒 Considérations de Sécurité

1. **Ne jamais commiter le fichier `.env`** - Il contient des identifiants sensibles
2. **Mettre à jour `CORS_ALLOW_ORIGIN`** pour correspondre uniquement au domaine de votre frontend
3. **Changer `APP_SECRET`** pour une valeur aléatoire en production


## 🐛 Dépannage

### Erreurs "Environment variable not found"

Assurez-vous que toutes les variables requises sont définies dans `.env` :
- `APP_SECRET`
- `DEFAULT_URI`
- `CORS_ALLOW_ORIGIN`


### Erreurs CORS dans le navigateur

Mettez à jour `CORS_ALLOW_ORIGIN` dans `.env` pour correspondre au domaine de votre frontend :
```env
# Pour le développement local sur le port 3000
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'

# Pour un domaine de production
CORS_ALLOW_ORIGIN='^https?://(www\.)?votredomaine\.com$'
```

### Erreurs 500

1. Vérifiez les logs Symfony : `var/log/dev.log`
2Videz le cache : `php bin/console cache:clear`

## 🤝 Contribution

1. Créer une branche de fonctionnalité
2. Effectuer vos modifications
3. Tester minutieusement avec votre environnement Proxmox
4. Créer une pull request

## 📄 Licence

Voir le fichier LICENSE pour plus de détails.


## 🔗 Liens Utiles

- [Documentation Symfony](https://symfony.com/doc/current/index.html)
- [Server-Sent Events (SSE)](https://developer.mozilla.org/fr/docs/Web/API/Server-sent_events)
