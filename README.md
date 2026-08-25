# SYMBIOZ

**Application de gestion de demandes de devis pour une entreprise du bâtiment.**
Projet réalisé dans le cadre du Titre Professionnel *Développeur Web et Web Mobile* (DWWM, niveau 5).

 **Application en ligne :** [symbioz-production.up.railway.app](https://symbioz-production.up.railway.app)

---

## À propos

Une petite entreprise du bâtiment reçoit ses demandes de partout (téléphone, mail, bouche-à-oreille) : rien n'est centralisé, des demandes se perdent. SYMBIOZ répond à ce besoin réel avec deux espaces :

- **Un site vitrine public** où un prospect dépose une demande de devis ou une demande d'urgence, sans créer de compte.
- **Un back-office sécurisé** où le gérant centralise, suit et pilote chaque demande, du premier contact à l'archivage.

---

## Fonctionnalités

**Site public**
- Page d'accueil vitrine, présentation des services (6 corps de métier)
- Formulaire de demande de devis (multi-étapes, sélection multi-services, upload de photos)
- Formulaire de demande d'urgence (parcours court)
- Page de confirmation avec numéro de référence unique
- Rate limiting anti-spam sur les formulaires publics

**Back-office (accès protégé)**
- Authentification sécurisée (Laravel Breeze, bcrypt)
- Tableau de bord avec KPI et pipeline commercial
- Liste des demandes : recherche, filtres, tri, pagination
- Fiche détail : suivi de statut (Nouveau → En cours → Traité → Perdu), priorité, notes internes
- Gestion des clients avec historique
- Archivage (soft delete), restauration et suppression définitive (RGPD)
- Notification email à l'administrateur à chaque nouvelle demande (queue)
- Gestion des rôles avec principe de moindre privilège (`admin` / `technicien`)

---

## Stack technique

| Composant        | Choix                          |
|------------------|--------------------------------|
| Langage          | PHP 8.3                        |
| Framework        | Laravel 12                     |
| Templating       | Blade                          |
| CSS              | Tailwind CSS (mobile-first)    |
| JavaScript       | Alpine.js                      |
| ORM              | Eloquent                       |
| Authentification | Laravel Breeze (Blade)         |
| Base de données  | MySQL 8 (InnoDB)               |
| Queue            | Driver `database`              |
| Environnement    | Laravel Sail (Docker)          |
| Tests            | PHPUnit                        |
| Déploiement      | Railway                        |

---

## Architecture

- **Modèle de données relationnel** : 7 tables + 2 tables pivots, avec **2 relations N-N**
  (`request_service` : une demande ↔ plusieurs services ; `project_user` : un chantier ↔ plusieurs intervenants).
- **Architecture en couches** : `Controller → Service → Model`. La logique métier est isolée dans des classes de service (`RequestService`, `ClientService`, `PhotoService`, `DashboardService`).
- **Validation** côté serveur via Form Requests ; **scopes** Eloquent réutilisables ; montants en `DECIMAL(10,2)`.

---

## Prérequis

- [Docker](https://www.docker.com/) et Docker Compose
- Git

*(Aucune installation locale de PHP, Composer ou MySQL nécessaire : tout tourne dans les conteneurs Sail.)*

---

## Installation

```bash
# 1. Cloner le dépôt
git clone https://github.com/abed31-Cyber/symbioz.git
cd symbioz

# 2. Préparer l'environnement
cp .env.example .env

# 3. Installer les dépendances PHP (via un conteneur temporaire)
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# 4. Démarrer les conteneurs (app, MySQL, Mailpit)
./vendor/bin/sail up -d

# 5. Générer la clé d'application et préparer la base
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed

# 6. Compiler les assets front
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

L'application est disponible sur [http://localhost](http://localhost).
Compte administrateur de démonstration : voir `database/seeders/UserSeeder.php`.

---

## Lancer les tests

```bash
./vendor/bin/sail artisan test
```

Les tests couvrent les parcours critiques : soumission de devis et d'urgence, validation, upload de photos, authentification et accès back-office, changement de statut, archivage / restauration (RGPD), tableau de bord et historique client.

---

## Structure du projet

```
app/
├── Enums/            # RequestStatus, RequestPriority, UserRole, ...
├── Http/
│   ├── Controllers/  # Front, Admin, Auth
│   └── Requests/     # StoreQuoteRequest, StoreQuickRequest, UpdateRequestRequest
├── Models/           # Request, Client, Service, Project, Photo, Quote, User
└── Services/         # RequestService, ClientService, PhotoService, DashboardService
database/
├── factories/
├── migrations/       # 7 tables + 2 pivots
└── seeders/
```

---

## Déploiement

L'application est déployée sur **Railway**, connecté à ce dépôt : chaque `push` sur la branche `dev` déclenche un redéploiement automatique.

- Les variables sensibles (`APP_KEY`, accès base de données, `APP_ENV=production`, `APP_DEBUG=false`) sont gérées dans les variables d'environnement Railway. Le fichier `.env` n'est jamais versionné.
- La compilation des assets front au déploiement est configurée dans `nixpacks.toml`.
- Le HTTPS est forcé en production (`URL::forceScheme('https')` dans `AppServiceProvider`) pour gérer le proxy HTTPS de Railway et éviter les erreurs de contenu mixte.

---

## Stratégie de branches

- `main` : version stable et documentée du projet livré.
- `dev` : branche d'intégration (déployée sur Railway). Le développement se fait par branche d'Épic, mergée sur `dev` via Pull Request.

---

## Contexte pédagogique

Projet de fin de formation présenté pour l'obtention du Titre Professionnel DWWM.
Le périmètre a été volontairement resserré autour d'un MVP solide, complet et testé. Certaines évolutions (interface de gestion des chantiers, génération de devis) sont prévues au niveau du modèle de données mais hors périmètre de cette version.

*Auteur : Abed Bekkouche.*
