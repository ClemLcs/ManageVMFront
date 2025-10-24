# ManageVMFront - Interface de Gestion de Machines Virtuelles

## 📋 Description

**ManageVMFront** est une interface web moderne développée avec Symfony pour la gestion et le monitoring de machines virtuelles. L'application offre une interface intuitive pour visualiser les VMs, leurs statistiques, snapshots et événements.

## 🚀 Fonctionnalités

### ✅ Actuellement Implémentées
- **Liste des VMs** avec informations détaillées (nom, statut, IP, CPU, RAM)
- **Page de détails VM** avec onglets :
  - 📊 **Résumé** : Statistiques en temps réel (CPU, RAM, disque, uptime)
  - 💻 **Console** : Interface de console VNC (préparée)
  - 📸 **Snapshots** : Gestion des snapshots avec historique
  - 📋 **Événements** : Journal des événements et actions
- **Interface responsive** avec design moderne
- **Données statiques** pour démonstration

### 🔄 Architecture Flexible

L'application est conçue pour supporter **deux modes de fonctionnement** :

#### 1. **Mode Démonstration (Actuel)**
- Données en dur dans le contrôleur PHP
- Affichage immédiat sans dépendance API
- Parfait pour les démonstrations et le développement

#### 2. **Mode Dynamique (Préparé)**
- Intégration avec API backend Proxmox
- Données en temps réel
- Actions dynamiques (démarrage/arrêt VM, création snapshots)

## 🛠️ Technologies Utilisées

- **Backend** : Symfony 7.3
- **Frontend** : Twig, CSS3, JavaScript ES6
- **Design** : Interface moderne avec CSS Grid/Flexbox
- **Charts** : Chart.js (préparé pour les graphiques)
- **API** : Architecture REST prête pour intégration

## 📦 Installation

### Prérequis
- PHP 8.2+
- Composer
- Symfony CLI (optionnel)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd ManageVMFront
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Démarrer le serveur de développement**
```bash
# Avec Symfony CLI (recommandé)
symfony serve

# Ou avec le serveur PHP intégré
php -S localhost:8000 -t public
```

4. **Accéder à l'application**
```
http://127.0.0.1:8000
```

## 🔧 Configuration

### Mode Démonstration (Par défaut)
Aucune configuration requise. Les données sont directement intégrées dans le contrôleur.

### Mode Dynamique (Optionnel)
Pour activer le mode dynamique avec API backend :

1. **Configurer l'API backend** dans `.env` :
```env
API_BASE_URL=http://localhost:8001
```

2. **Modifier le contrôleur** pour utiliser l'API au lieu des données statiques
3. **Décommenter le JavaScript** dans les templates pour l'interactivité

## 📁 Structure du Projet

```
ManageVMFront/
├── src/
│   └── Controller/
│       └── ListVMsController.php    # Contrôleur principal avec données statiques
├── templates/
│   ├── base.html.twig              # Template de base
│   ├── list_v_ms/
│   │   └── index.html.twig         # Liste des VMs
│   └── vm/
│       ├── details.html.twig      # Page de détails VM
│       └── create.html.twig        # Création de VM
├── assets/
│   ├── app.js                     # JavaScript principal
│   ├── api-service.js             # Service API
│   └── styles/
│       └── app.css                # Styles personnalisés
└── public/
    └── index.php                   # Point d'entrée
```

## 🎯 Utilisation

### Navigation
1. **Page d'accueil** : Redirige automatiquement vers la liste des VMs
2. **Liste des VMs** : `/list/v/ms` - Vue d'ensemble de toutes les VMs
3. **Détails VM** : `/vm/{id}` - Page détaillée d'une VM spécifique

### Fonctionnalités Disponibles
- **Visualisation** : Informations complètes sur chaque VM
- **Statistiques** : Métriques de performance en temps réel
- **Historique** : Événements et actions passées
- **Snapshots** : Gestion des sauvegardes

## 🔄 Passage au Mode Dynamique

### Étapes pour Activer les Données Dynamiques

1. **Modifier le contrôleur** (`src/Controller/ListVMsController.php`) :
```php
// Remplacer les données statiques par des appels API
public function details(int $vmid): Response
{
    // Au lieu de données en dur, faire des appels API
    $vmData = $this->apiService->getVM($vmid);
    $snapshots = $this->apiService->getSnapshots($vmid);
    $events = $this->apiService->getEvents($vmid);
    
    return $this->render('vm/details.html.twig', [
        'vm' => $vmData,
        'snapshots' => $snapshots,
        'events' => $events,
    ]);
}
```

2. **Activer le JavaScript** dans les templates :
```twig
{# Décommenter les sections JavaScript pour l'interactivité #}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Code JavaScript pour les graphiques et actions dynamiques
</script>
```

3. **Configurer l'API backend** :
```env
API_BASE_URL=http://votre-api-backend:port
```

### Avantages du Mode Dynamique
- **Données en temps réel** depuis Proxmox
- **Actions interactives** (démarrage/arrêt VMs)
- **Graphiques dynamiques** avec métriques historiques
- **Notifications en temps réel** via WebSocket
- **Gestion complète des snapshots**

## 🎨 Personnalisation

### Styles
- Modifier `assets/styles/app.css` pour les styles personnalisés
- Variables CSS disponibles pour la cohérence des couleurs
- Design responsive avec breakpoints mobiles

### Données
- Ajouter/modifier des VMs dans `ListVMsController.php`
- Personnaliser les événements et snapshots
- Adapter les métriques selon vos besoins

## 🚀 Déploiement

### Production
1. **Optimiser l'autoloader** :
```bash
composer install --no-dev --optimize-autoloader
```

2. **Vider le cache** :
```bash
php bin/console cache:clear --env=prod
```

3. **Configurer le serveur web** (Apache/Nginx) pour pointer vers le dossier `public/`

### Docker (Optionnel)
```dockerfile
FROM php:8.2-fpm
# Configuration Docker pour production
```

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit les changements (`git commit -am 'Ajout nouvelle fonctionnalité'`)
4. Push vers la branche (`git push origin feature/nouvelle-fonctionnalite`)
5. Créer une Pull Request

## 📝 Notes de Développement

### Architecture Actuelle
- **Données statiques** : Parfait pour les démonstrations
- **Interface prête** : Design et fonctionnalités complètes
- **Code modulaire** : Facile à étendre

### Prochaines Étapes
- [ ] Intégration API Proxmox
- [ ] Authentification utilisateur
- [ ] Gestion des permissions
- [ ] Notifications temps réel
- [ ] Export de rapports

## 📞 Support

Pour toute question ou problème :
- Créer une issue sur le repository
- Consulter la documentation Symfony
- Vérifier les logs dans `var/log/`

---

**Développé avec ❤️ en Symfony 7.3**