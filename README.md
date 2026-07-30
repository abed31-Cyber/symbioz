# SYMBIOZ

> Application web de gestion de demandes de devis et d'interventions urgentes pour une entreprise du bâtiment multi-métiers (plomberie, électricité, peinture, plâtrerie, menuiserie).

Projet réalisé dans le cadre du titre professionnel **Développeur Web et Web Mobile (DWWM — niveau 5)**.

**Lien de l'application** : {{ symbioz-production.up.railway.app}}

---

## Sommaire

- [Présentation](#présentation)
- [Fonctionnalités](#fonctionnalités)
- [Captures d'écran](#captures-décran)
- [Stack technique](#stack-technique)
- [Architecture](#architecture)
- [Installation locale](#installation-locale)
- [Compte de démonstration](#compte-de-démonstration)
- [Tests](#tests)
- [Modèle de données](#modèle-de-données)

---

## Présentation

SYMBIOZ répond à un besoin concret : une petite entreprise du bâtiment reçoit ses demandes par téléphone, e-mail et bouche-à-oreille, sans centralisation. L'application offre :

- un **site vitrine public** où un prospect dépose une demande de devis (multi-services, photos) ou signale une **urgence** ;
- un **back-office sécurisé** où le gérant pilote chaque demande de sa réception à sa clôture, gère sa base clients et archive l'historique.

Le rendez-vous se prend par téléphone et se consigne dans les notes internes : l'application ne gère volontairement **aucun calendrier** (voir la décision d'architecture correspondante dans le dossier projet).

---

## Fonctionnalités

### Espace public
- Formulaire de **demande de devis** : coordonnées, description, sélection de plusieurs services, upload de photos.
- Formulaire d'**urgence** : version allégée, priorité forcée côté serveur.
- Page de **confirmation** avec numéro de référence unique (ex. `REF-0051`).
- Accusé de réception par e-mail (si le prospect a fourni une adresse).
- Limitation anti-spam sur les soumissions.

### Back-office (accès authentifié)
- **Tableau de bord** : indicateurs clés (CA potentiel, demandes actives, taux de traitement), pipeline commercial par statut, alerte sur la demande urgente la plus ancienne.
- **Liste des demandes** : recherche client, filtres par statut et par service, pagination.
- **Fiche demande** : détail en lecture seule, galerie photos, et pilotage (statut, priorité, notes internes).
- **Base clients** : liste avec compteur de demandes, fiche client avec historique complet.
- **Archives** : archivage réversible (soft delete), restauration et suppression définitive conforme RGPD.
- Notification e-mail de l'administrateur à chaque nouvelle demande.

---

## Captures d'écran

| Site vitrine | Formulaire de devis |
|:---:|:---:|
| _{{ screenshot_accueil }}_ | _{{ screenshot_devis }}_ |

| Tableau de bord | Fiche demande |
|:---:|:---:|
| _{{ screenshot_dashboard }}_ | _{{ screenshot_fiche }}_ |

> Remplacer par vos captures : déposez-les dans `docs/screenshots/` et référencez-les ici avec `![Description](docs/screenshots/nom.png)`.

---

## Stack technique

| Domaine | Technologie | Justification |
|---|---|---|
| Langage | **PHP 8.3** | Typage strict, enums natifs pour les statuts et priorités. |
| Framework | **Laravel 12** | Eloquent (ORM), routing, validation, notifications — productivité et sécurité par défaut. |
| Vues | **Blade** | Moteur de templates natif, composants réutilisables (badges, tags). |
| CSS | **Tailwind CSS** | Approche mobile-first, cohérence visuelle sans CSS custom dispersé. |
| Interactivité | **Alpine.js** | Dynamique côté client légère (confirmations, affichage conditionnel) sans framework lourd. |
| Base de données | **MySQL 8** | Source de vérité, contraintes d'intégrité et `ON DELETE CASCADE`. |
| Authentification | **Laravel Breeze** | Auth par session, éprouvée, sans sur-ingénierie (pas de JWT/API token inutile ici). |
| Environnement | **Laravel Sail (Docker)** | Environnement reproductible identique en local et en CI. |
| Tests | **PHPUnit** | Tests de fonctionnalités et de règles de gestion. |
| Hébergement | **Railway** | Déploiement continu depuis le dépôt Git. |

Le choix de cette stack privilégie la **simplicité maîtrisée** : chaque brique répond à un besoin réel du cahier des charges, sans abstraction superflue (pas de Repository pattern, pas de DDD).

---

## Architecture

Le flux d'une requête suit une chaîne claire, avec un contrôleur volontairement fin :

```
Route → Form Request (validation) → Controller (10-15 lignes) → Service (logique métier) → Model (Eloquent) → MySQL
```

La **logique métier est centralisée dans des services** (`RequestService`, `ClientService`, `PhotoService`, `DashboardService`) : les contrôleurs se contentent d'orchestrer, ce qui rend la logique testable indépendamment du HTTP.

Les **statuts et priorités** sont des enums PHP portant leur propre libellé et couleur d'affichage : une source unique de vérité, réutilisée par des composants Blade sur tous les écrans.

---

## Installation locale

### Prérequis
- [Docker](https://www.docker.com/) et Docker Compose
- Git

### Étapes

```bash
# 1. Cloner le dépôt
git clone {{ URL_DEPOT }} symbioz
cd symbioz

# 2. Copier le fichier d'environnement
cp .env.example .env

# 3. Installer les dépendances PHP via un conteneur jetable
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# 4. Démarrer les conteneurs Sail
./vendor/bin/sail up -d

# 5. Générer la clé d'application
./vendor/bin/sail artisan key:generate

# 6. Créer les tables et injecter les données de démonstration
./vendor/bin/sail artisan migrate --seed

# 7. Créer le lien symbolique pour les photos uploadées
./vendor/bin/sail artisan storage:link

# 8. Installer et compiler les assets front
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

L'application est accessible sur **http://localhost** (ou **http://127.0.0.1**).
Les e-mails sortants sont capturés par **Mailpit** sur **http://localhost:8025**.

> Astuce : ajoutez `alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'` à votre shell pour taper `sail` au lieu de `./vendor/bin/sail`.

---

## Compte de démonstration

Un compte administrateur est créé automatiquement par les seeders :

| Champ | Valeur |
|---|---|
| E-mail | `{{ EMAIL_DEMO }}` |
| Mot de passe | `{{ MOT_DE_PASSE_DEMO }}` |

Accès au back-office : **{{ URL_RAILWAY }}/login**

---

## Tests

La suite de tests couvre les parcours publics, la sécurité d'accès au back-office et les règles de gestion (validation, archivage, relation many-to-many, envoi de notifications).

```bash
# Lancer toute la suite
./vendor/bin/sail artisan test

# Lancer un fichier ciblé
./vendor/bin/sail artisan test --filter=AdminArchiveTest
```

**{{ NB_TESTS }} tests** — {{ NB_ASSERTIONS }} assertions.

---

## Modèle de données

Le schéma repose sur **7 tables** et **2 tables pivots**, avec deux relations _many-to-many_ :

- `request_service` : une demande peut concerner plusieurs services, un service peut figurer dans plusieurs demandes.
- `project_user` : un chantier peut mobiliser plusieurs intervenants (extension prévue).

Les diagrammes MCD, MLD et MPD figurent dans le dossier projet.

---

_Projet pédagogique — titre professionnel DWWM._
