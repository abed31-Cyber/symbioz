# Cahier des charges SYMBIOZ v7.0

**Application web de gestion des demandes clients et des chantiers pour artisans du BTP**
Version 7.0 (Laravel — modèle relationnel enrichi) — 14 juillet 2026
Auteur : Abed BEKKOUCHE — École La Plateforme Toulouse — Formation DWWM

---

## 1. Contexte

### 1.1 Contexte professionnel
SYMBIOZ est une application web monolithique développée dans le cadre de la formation DWWM. Le projet répond à un besoin métier du BTP second œuvre : les artisans solo gèrent leur acquisition client de manière désorganisée (post-it, Excel, WhatsApp), entraînant une perte de 30-40 % des prospects.

### 1.2 Objectifs
| Objectif | Métrique |
|---|---|
| Centralisation des demandes | 100 % des demandes entrantes |
| Temps de traitement | < 2 min de réception au statut « En cours » |
| Réactivité différenciée | Rappel 2h (urgence) / 48h (devis) |
| Visibilité commerciale | KPI temps réel sur dashboard |
| Historique client | Retrouver toutes les demandes d'un client |
| Préparation de la délégation | Assigner des compagnons à des chantiers |

### 1.3 Périmètre

**IN SCOPE (v7.0)** :
- Site vitrine + 2 formulaires publics (devis et demande urgente)
- Upload de photos (plusieurs par demande)
- Sélection multiple de services par demande
- Back-office sécurisé (Laravel Breeze)
- Fiche client avec historique des demandes
- Pipeline commercial (Nouveau → En cours → Traité / Perdu)
- Gestion des chantiers + assignation de compagnons
- Gestion des devis (montant, statut, relances)
- Calendrier + prise de RDV côté administrateur + génération `.ics`
- Recherche, filtres, pagination
- Archivage (soft delete) et suppression définitive RGPD
- Notification email (admin + accusé de réception client)
- Dashboard KPI

**OUT SCOPE (v7.0)** :
- **Réservation de créneau en ligne par le client** (self-booking type Doctolib) — le RDV est posé par l'administrateur après qualification téléphonique (cf. §2.7 et ADR-007)
- **Espace de connexion pour les compagnons** — le compagnon est une ressource assignable, non un utilisateur connecté (cf. ADR-008). Le champ `role` prépare cette évolution (phase 2)
- API REST publique
- SMS, paiement, mobile natif

### 1.4 Personas
- **Karim** (42 ans) : gérant artisan, administrateur unique, mobile-first. Veut centraliser, suivre le pipeline, retrouver l'historique d'un client, et **préparer la délégation** à son conducteur de travaux.
- **Sophie** (35 ans) : cliente urgente (fuite sous évier), iPhone. Veut décrire son problème **avec des photos** et être recontactée vite.
- **Pascal** (34 ans) : prospect exigeant (rénovation complète), MacBook. Veut cocher **plusieurs métiers** pour un seul projet, sans créer de compte.

---

## 2. Besoins fonctionnels

### 2.1 Objectifs fonctionnels
| Code | Objectif | Priorité | Couche |
|---|---|---|---|
| OF-1 | Soumission de demandes sans compte | MVP | 1 |
| OF-2 | Joindre des photos à une demande | MVP | 1 |
| OF-3 | Sélectionner plusieurs services par demande | MVP | 1 |
| OF-4 | Centraliser dans un tableau de bord | MVP | 1 |
| OF-5 | Consulter la fiche et l'historique d'un client | MVP | 1 |
| OF-6 | Suivre le pipeline commercial | MVP | 1 |
| OF-7 | Notifier admin + accusé de réception client | MVP | 1 |
| OF-8 | Archiver + supprimer RGPD | MVP | 1 |
| OF-9 | Gérer les chantiers + assigner des compagnons | Important | 2 |
| OF-10 | Gérer les devis + relances | Important | 3 |
| OF-11 | Planifier des RDV + calendrier + `.ics` | Souhaité | 4 |

### 2.2 Les 4 couches de livraison

Le développement est organisé en **couches empilables**. Chaque couche laisse un produit soutenable ; les couches supérieures s'ajoutent sans casser les inférieures.

| Couche | Contenu | État atteint |
|---|---|---|
| **1 — Socle** | `users` `clients` `requests` `services` `photos` + pivot `request_service` + emails | **Soutenable.** Pascal et Sophie soumettent, Karim traite de bout en bout. Contient déjà 1 relation N-N. |
| **2 — Chantiers** | `projects` + pivot `project_user` + 2 écrans | **Soutenable +.** 2e relation N-N. Justifie la délégation de Karim. |
| **3 — Devis** | `quotes` + relances | Le dashboard commercial (CA pipeline, devis à relancer) prend son sens. |
| **4 — Calendrier / RDV** | `appointments` + FullCalendar + `.ics` | La couche la plus lourde, donc la dernière. Coupable sans rien casser si le planning se tend. |

**Règle d'or** : le scope est la variable d'ajustement, jamais le planning. En cas de retard, on coupe la couche 4, puis la couche 3.

### 2.3 User Stories

**EPIC 1 — Public**
- US-1.1 : Visiteur → consulter l'accueil
- US-1.2 : Visiteur → consulter les services
- US-1.3 : Prospect → remplir le formulaire devis (**multi-services + photos**)
- US-1.4 : Prospect pressé → faire une demande urgente (**multi-services + photos**)
- US-1.5 : Prospect → recevoir un accusé de réception (si email fourni)

**EPIC 2 — Back-office demandes**
- US-2.1 : Se connecter (sécurisé)
- US-2.2 : Voir le dashboard
- US-2.3 : Consulter la liste des demandes (paginée, triée)
- US-2.4 : Filtrer et rechercher
- US-2.5 : Consulter le détail + galerie photos
- US-2.6 : Modifier le statut + la priorité
- US-2.7 : Ajouter des notes internes
- US-2.8 : Archiver / Restaurer / Supprimer (RGPD)
- US-2.9 : Recevoir une notification email
- US-2.10 : Se déconnecter

**EPIC 3 — Clients**
- US-3.1 : Consulter la fiche d'un client + historique de ses demandes

**EPIC 4 — Chantiers (couche 2)**
- US-4.1 : Créer et lister les chantiers
- US-4.2 : Assigner / retirer des compagnons sur un chantier (**N-N**)
- US-4.3 : Rattacher une demande à un chantier

**EPIC 5 — Devis (couche 3)**
- US-5.1 : Émettre un devis pour une demande
- US-5.2 : Suivre les devis à relancer

**EPIC 6 — Calendrier / RDV (couche 4)**
- US-6.1 : Planifier un RDV (rattaché ou non à une demande)
- US-6.2 : Consulter le calendrier (jour/semaine/mois)
- US-6.3 : Envoyer au client un email de confirmation + `.ics`

**Critères d'acceptation US-1.3 (devis)** :
- Coordonnées : prénom, nom, email (RFC), téléphone (10 chiffres), adresse, ville
- **Un ou plusieurs services** (cases à cocher, ≥ 1 requis)
- Description (min 10 car.), budget estimé optionnel
- **Photos optionnelles** (plusieurs, formats image, taille limitée)
- Rate limit 10/min/IP
- Confirmation visuelle + accusé de réception email si email fourni

### 2.4 Rôles
| Rôle | Permissions |
|---|---|
| Visiteur | Consulter accueil, services, formulaires |
| Prospect | Soumettre devis / demande urgente (sans compte) |
| Admin (Karim) | Accès complet back-office |
| Compagnon | *(phase 2)* ressource assignable à un chantier, sans connexion en v7.0 |

### 2.5 Règles de gestion
| ID | Condition | Action |
|---|---|---|
| RG-1 | Admin consulte une fiche demande | Données déclaratives = lecture seule |
| RG-2 | Statut = Perdu | `closing_reason` obligatoire |
| RG-3 | Suppression demandée | La demande doit d'abord être archivée (soft delete) |
| RG-4 | Archive présente | Actions Restaurer + Suppr. définitive disponibles |
| RG-5 | Formulaire public soumis | Rate limit 10 req/min/IP |
| RG-6 | Nouvelle demande créée | Notification email admin (queue) |
| RG-7 | Demande soumise **avec** email client | Accusé de réception envoyé au client |
| RG-8 | Demande soumise **sans** email (urgence) | Pas d'email client ; le rappel se fait par téléphone |
| RG-9 | Formulaire soumis | Au moins **un** service sélectionné |
| RG-10 | `is_quick` | Fixé par le canal (formulaire urgence = true), **non modifiable** ensuite |
| RG-11 | `priority` | Fixée par défaut selon `is_quick`, **modifiable** par l'admin |
| RG-12 | RDV planifié avec email client | Email de confirmation + pièce jointe `.ics` |
| RG-13 | RDV « interne » (réunion) | `request_id` peut être nul |

### 2.6 Distinction clé : `is_quick` ≠ `priority`

C'est le point de vigilance central du modèle. Deux notions à ne jamais confondre :

- **`is_quick`** (booléen) = **la source**. La demande vient-elle du formulaire urgence (`true`) ou du formulaire devis (`false`) ? C'est un **fait historique immuable**, affiché en lecture seule (`SOURCE : URGENTE`).
- **`priority`** (enum : normal / urgent) = **le jugement de l'administrateur**. Karim peut déclasser une fausse urgence ou surclasser un devis critique. **Modifiable** depuis la fiche détail.

**Punchline soutenance** : « `is_quick` enregistre le canal d'arrivée — une donnée factuelle. `priority` est l'appréciation de Karim, qu'il peut réviser. Les fusionner m'aurait fait perdre l'information de provenance. »

### 2.7 Choix métier — pas de self-booking client

La prise de RDV en ligne par le client (type Doctolib) est **hors périmètre**. Justification : dans le BTP, l'artisan qualifie le besoin par téléphone avant de bloquer un créneau (un dégât des eaux ne se réserve pas comme un rendez-vous médical). Le parcours de la persona Sophie le confirme : *« Le lendemain matin, Karim la contacte afin de convenir d'un rendez-vous. »* Le RDV est donc **créé par l'administrateur** après échange (option A). Aucune maquette ne prévoit d'écran de réservation publique.

---

## 3. Spécifications techniques

### 3.1 Stack

**Backend**
- PHP 8.3
- Laravel 12
- Eloquent ORM
- Laravel Breeze (auth Blade)
- Form Requests
- Laravel Queue (driver `database`)
- Laravel Notifications / Mailables

**Base de données**
- MySQL 8 (source de vérité)
- Queue driver `database`
- Session driver `database`

**Front**
- Blade (rendu serveur)
- Tailwind CSS (mobile-first)
- Alpine.js (dropdowns, modales, confirmations)
- FullCalendar.js (couche 4)
- Chart.js (dashboard)

**Stockage fichiers**
- Disque `public` Laravel (`storage/app/public`) + lien symbolique
- Validation MIME + taille pour les photos

**Outils**
- Laravel Sail (Docker préconfiguré)
- PHPUnit
- Git + GitHub (branches main / dev)
- Figma (maquettes)
- Mailpit (capture emails en dev)
- Railway (hébergement)

### 3.2 Architecture

**Pattern : MVC + couche Service**
```
Route → Form Request → Controller (fin, 10-15 lignes) → Service → Model → MySQL
```

Principes :
- Contrôleurs fins : orchestration uniquement
- Logique métier centralisée dans les Services (testable)
- Form Requests pour la validation déclarative
- Injection de dépendances via le service container (IoC)

### 3.3 Concepts Laravel défendus en soutenance
- Injection de dépendances (constructor + method injection)
- IoC container et service providers
- Façades (Auth, DB, Notification, Route, Storage)
- Form Requests avec `authorize()`, `rules()`, `messages()`
- Eloquent : casts d'enums, scopes locaux, SoftDeletes, **relations `belongsToMany`** (pivots), `hasMany`
- Middleware (auth, throttle)
- Laravel Notifications + Mailables (canal mail, pièce jointe `.ics`)
- File storage (upload, validation, disque public)
- Blade Components réutilisables

### 3.4 Sécurité
| Couche | Mesure | Implémentation |
|---|---|---|
| Auth | Bcrypt | Breeze natif |
| Session | Sécurisée | Driver database, régénération CSRF |
| Formulaires | CSRF token | `@csrf` natif |
| Validation | Stricte | Form Requests |
| Rate limiting | Throttle | `throttle:10,1` |
| Anti-énumération | Message générique | « Identifiants incorrects » |
| Données client | Lecture seule | RG-1 |
| Upload fichiers | Validation MIME + taille + noms générés | `Storage`, `mimes`, `max` |
| SQL Injection | Requêtes paramétrées | Eloquent PDO bindings |
| XSS | Échappement Blade | `{{ }}` échappe auto |
| RGPD | Soft + hard delete | Droit à l'oubli |

---

## 4. Base de données

### 4.1 MCD (Modèle Conceptuel)
**8 entités, 2 relations Many-to-Many.**

Entités : USER, CLIENT, PROJECT, REQUEST, PHOTO, QUOTE, APPOINTMENT, SERVICE.

Associations principales :
- CLIENT (0,n) — soumet — (1,1) REQUEST
- CLIENT (0,n) — possède — (1,1) PROJECT
- PROJECT (0,n) — regroupe — (0,1) REQUEST
- REQUEST (0,n) — illustre — (1,1) PHOTO
- REQUEST (0,n) — donne lieu à — (1,1) QUOTE
- REQUEST (0,n) — planifie — (0,1) APPOINTMENT
- USER (0,n) — assure — (1,1) APPOINTMENT
- **REQUEST (1,n) — concerne — (0,n) SERVICE** ← N-N n°1
- **USER (0,n) — intervient sur — (0,n) PROJECT** ← N-N n°2

### 4.2 MLD (Modèle Logique)

```
USER (#id, name, email, password, role)
CLIENT (#id, first_name, last_name, email, phone, address, city, status)
PROJECT (#id, label, status, #client_id => CLIENT)
REQUEST (#id, reference, description, is_quick, priority, budget_estimate,
         status, closing_reason, admin_notes, is_archived,
         created_at, updated_at, deleted_at,
         #client_id => CLIENT, #project_id => PROJECT)
PHOTO (#id, path, #request_id => REQUEST)
QUOTE (#id, amount, status, sent_at, #request_id => REQUEST)
APPOINTMENT (#id, title, type, start_at, end_at, location,
             #request_id => REQUEST, #user_id => USER)
SERVICE (#id, name, slug)

REQUEST_SERVICE (#request_id => REQUEST, #service_id => SERVICE)   -- pivot N-N n°1
PROJECT_USER    (#project_id => PROJECT, #user_id => USER)         -- pivot N-N n°2
```

**Notes** :
- Pas de FK `user_id` sur `REQUEST` : les demandes sont anonymes (visiteurs sans compte), l'admin les gère globalement.
- `REQUEST.project_id` **nullable** : une demande simple n'est pas forcément rattachée à un chantier.
- `APPOINTMENT.request_id` **nullable** : un RDV interne (réunion d'équipe) n'a pas de demande.
- `CLIENT.first_name` **nullable** : absorbe les cas « Ste BuildCorp », « Famille Mercier » (le nom va dans `last_name`).
- `CLIENT.email` **nullable** : le formulaire urgence rend l'email optionnel.

### 4.3 MPD (principales tables MySQL 8)

```sql
-- users (Breeze, étendu)
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','technicien') NOT NULL DEFAULT 'technicien',
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- clients
CREATE TABLE clients (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NULL,
  last_name VARCHAR(150) NOT NULL,
  email VARCHAR(255) NULL,
  phone VARCHAR(20) NOT NULL,
  address VARCHAR(255) NULL,
  city VARCHAR(100) NULL,
  status ENUM('prospect','client') NOT NULL DEFAULT 'prospect',
  created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL,
  INDEX idx_city (city)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- projects (chantiers)
CREATE TABLE projects (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id BIGINT UNSIGNED NOT NULL,
  label VARCHAR(150) NOT NULL,
  status ENUM('open','in_progress','closed') NOT NULL DEFAULT 'open',
  created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL,
  FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- requests (demandes — table fusionnée devis + urgence)
CREATE TABLE requests (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id BIGINT UNSIGNED NOT NULL,
  project_id BIGINT UNSIGNED NULL,
  reference VARCHAR(20) NOT NULL UNIQUE,
  description TEXT NOT NULL,
  is_quick BOOLEAN NOT NULL DEFAULT 0,
  priority ENUM('normal','urgent') NOT NULL DEFAULT 'normal',
  budget_estimate DECIMAL(10,2) NULL,
  status ENUM('nouveau','en_cours','traite','perdu') NOT NULL DEFAULT 'nouveau',
  closing_reason TEXT NULL,
  admin_notes TEXT NULL,
  is_archived BOOLEAN NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL,
  FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL,
  INDEX idx_status (status),
  INDEX idx_is_quick (is_quick),
  INDEX idx_is_archived (is_archived),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- photos
CREATE TABLE photos (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  request_id BIGINT UNSIGNED NOT NULL,
  path VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL,
  FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- quotes (devis)
CREATE TABLE quotes (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  request_id BIGINT UNSIGNED NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  status ENUM('draft','sent','accepted','refused','paid') NOT NULL DEFAULT 'draft',
  sent_at DATETIME NULL,
  created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL,
  FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE,
  INDEX idx_status (status),
  INDEX idx_sent_at (sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- appointments (RDV)
CREATE TABLE appointments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  request_id BIGINT UNSIGNED NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(150) NOT NULL,
  type ENUM('urgent','visite_tech','reunion') NOT NULL DEFAULT 'visite_tech',
  start_at DATETIME NOT NULL,
  end_at DATETIME NOT NULL,
  location VARCHAR(255) NULL,
  created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL,
  FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_start_at (start_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- services
CREATE TABLE services (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  slug VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- pivot N-N n°1 : request_service
CREATE TABLE request_service (
  request_id BIGINT UNSIGNED NOT NULL,
  service_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (request_id, service_id),
  FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- pivot N-N n°2 : project_user
CREATE TABLE project_user (
  project_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (project_id, user_id),
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4.4 Référentiel `services` (figé)
`Plomberie` · `Électricité` · `Peinture` · `Plâtrerie` · `Menuiserie` · `Rénovation globale`

Les chips du formulaire urgence (*Fuite d'eau, Panne électrique, Serrurerie, Toiture, Chauffage*) sont des **raccourcis de pré-remplissage de la description**, pas des services.

---

## 5. Contraintes non fonctionnelles

### 5.1 Performance
- Chargement page < 2 s (Lighthouse)
- Pagination 15/page (Laravel natif)
- Index sur les colonnes de filtre/tri (§4.3)
- Eager loading des relations (`with()`) pour éviter le N+1

### 5.2 Responsive (mobile-first)
- Mobile < 768px : Karim sur smartphone (sidebar collapsée, KPI empilés)
- Tablette 768-1024 : Sophie sur iPhone/iPad
- Desktop > 1024 : Pascal sur MacBook

### 5.3 Accessibilité
- Contraste WCAG AA
- Navigation clavier complète
- ARIA labels sur icônes et boutons
- Structure sémantique HTML5

### 5.4 Maintenabilité
- Architecture Controller → Service → Model
- Conventions Laravel strictes (cf. DEV_METHOD.md)
- README + PHPDoc
- 10-15 tests PHPUnit critiques
- Branches main / dev, conventional commits

### 5.5 Critères de validation
| Critère | Méthode |
|---|---|
| Fonctionnalité | Tests PHPUnit |
| Sécurité | Audit OWASP (CSRF, XSS, injection, throttle, upload) |
| Accessibilité | WAVE / axe DevTools |
| Performance | Lighthouse ≥ 90 |
| Responsive | Test iPhone SE, Pixel, iPad |

---

## 6. Planning (7 semaines de code + soutenance)

| Semaine | Dates | Sprint | Objectif | Couche |
|---|---|---|---|---|
| S1 | 14-20/07 | Sprint 0+1 | Refonte modèles/migrations/seeders + site vitrine + formulaire devis (multi-services + photos) | 1 |
| S2 | 21-27/07 | Sprint 2 | Formulaire urgence + login admin + accusés de réception | 1 |
| S3 | 28/07-03/08 | Sprint 3 | Dashboard + liste + filtres + fiche client | 1 |
| S4 | 04-10/08 | Sprint 4 | Fiche détail + galerie photos + statut/priorité + archivage + notif email | 1 |
| — | | | **→ Fin couche 1 : projet soutenable, 1 N-N livré** | |
| S5 | 11-17/08 | Sprint 5 | Chantiers + assignation compagnons (N-N n°2) + devis | 2 + 3 |
| S6 | 18-24/08 | Sprint 6 | Calendrier FullCalendar + RDV + `.ics` **OU** polish/tests si retard | 4 |
| S7 | 25-31/08 | Sprint 7 | Tests, accessibilité, doc, dossier pro, déploiement final | — |
| S8 | 01-07/09 | Soutenance | Simulations + passage du titre | — |

**Point de bascule** : à la fin de S4, la couche 1 est complète et le projet est déjà soutenable. S5 et S6 empilent les couches 2-3-4. Si S6 déborde, le calendrier est coupé et remplacé par du polish — sans rien casser.

### Matrice des risques
| Risque | Prob. | Impact | Mitigation |
|---|---|---|---|
| Refonte des tables casse le déploiement | Moyen | Élevé | `migrate:fresh` local d'abord, puis push ; migrations rejouées auto sur Railway |
| Couche 4 (calendrier) trop lourde | Élevé | Moyen | Placée en dernier, coupable sans impact sur le reste |
| Retard sur une couche | Élevé | Moyen | On coupe la couche, on ne décale pas |
| Scope creep (self-booking, espace compagnon) | Moyen | Élevé | Explicitement hors périmètre (ADR-007, ADR-008) |
| Bugs en soutenance | Moyen | Élevé | Tests + soutenance blanche |

---

## 7. Matrice de traçabilité

| User Story | OF | RG | Couche | Priorité |
|---|---|---|---|---|
| US-1.3 (devis) | OF-1, OF-2, OF-3 | RG-5, RG-9 | 1 | MVP |
| US-1.4 (urgence) | OF-1, OF-2, OF-3 | RG-5, RG-8, RG-9, RG-10 | 1 | MVP |
| US-1.5 (accusé réception) | OF-7 | RG-7 | 1 | MVP |
| US-2.1 à 2.4 | OF-4 | — | 1 | MVP |
| US-2.5 (détail + photos) | OF-2, OF-6 | RG-1 | 1 | MVP |
| US-2.6 (statut + priorité) | OF-6 | RG-1, RG-2, RG-11 | 1 | MVP |
| US-2.8 (archivage) | OF-8 | RG-3, RG-4 | 1 | MVP |
| US-2.9 (notif email) | OF-7 | RG-6 | 1 | MVP |
| US-3.1 (fiche client) | OF-5 | — | 1 | MVP |
| US-4.1 à 4.3 (chantiers) | OF-9 | — | 2 | Important |
| US-5.1, US-5.2 (devis) | OF-10 | — | 3 | Important |
| US-6.1 à 6.3 (RDV) | OF-11 | RG-12, RG-13 | 4 | Souhaité |

---

## 8. Annexes

### Annexe A — ADR (Architecture Decision Records)
| ID | Décision | Justification |
|---|---|---|
| ADR-001 | Laravel 12 + Blade + Alpine + Tailwind + MySQL | Cohérence stack, Breeze fournit l'auth, courbe adaptée |
| ADR-002 | Controller → Service → Model | Testabilité, séparation des responsabilités |
| ADR-003 | Fullstack Blade (pas de SPA React) | Simplicité, un seul serveur, matche le référentiel DWWM |
| **ADR-004 (révisé 14/07)** | **1 seule table `requests` + booléen `is_quick`** (remplace les 2 tables séparées) | **Les 2 tables partageaient 12 colonnes sur 14 : redondance. La fusion divise par 2 les contrôleurs, services, Form Requests, vues et tests. Le back-office traite les deux types dans un pipeline unique.** |
| ADR-005 | Pas de FK `user_id` sur `requests` | Demandes anonymes (visiteurs sans compte) |
| **ADR-006 (révisé 14/07)** | **Réintégration photos + RDV** (annule le retrait v6.0) | **Photos exigées par la persona Sophie (« des photos ») et la FAQ (« chiffrer sur photos ») ; RDV exigés par l'écran calendrier et l'UC « Planifier RDV ». Retrait v6.0 jugé incohérent avec les maquettes.** |
| **ADR-007 (nouveau)** | **RDV créés par l'admin, pas de self-booking client** | Dans le BTP, l'artisan qualifie par téléphone avant de bloquer un créneau. Le parcours de Sophie le confirme. Aucune maquette de réservation publique. |
| **ADR-008 (nouveau)** | **Compagnon = ressource assignable, sans connexion en v7.0** | Karim veut préparer une **future** délégation. Le champ `role` existe et prépare la phase 2, mais l'espace technicien (middleware de rôle, vues restreintes) est hors périmètre pour tenir le planning. |
| **ADR-009 (nouveau)** | **2 relations N-N : `request_service` et `project_user`** | Pascal coche plusieurs métiers pour un projet ; Karim assigne plusieurs compagnons à un chantier. Démontre la maîtrise du relationnel attendue par le référentiel. |
| **ADR-010 (nouveau)** | **Montants en `DECIMAL(10,2)`, jamais `FLOAT`** | Les flottants introduisent des erreurs d'arrondi inacceptables sur de l'argent. |

### Annexe B — Glossaire
- **Demande (`request`)** : demande entrante, de devis (`is_quick=false`) ou urgente (`is_quick=true`)
- **Chantier (`project`)** : regroupement de travaux pour un client, sur lequel on assigne des compagnons
- **Devis (`quote`)** : proposition chiffrée émise par l'admin pour une demande
- **Compagnon** : ouvrier salarié, ressource assignable à un chantier (pas de compte en v7.0)
- **Soft delete** : suppression logique (`deleted_at`)
- **Hard delete** : suppression physique irréversible (RGPD)
- **Pivot** : table de jonction matérialisant une relation Many-to-Many
- **Pipeline commercial** : Nouveau → En cours → Traité / Perdu
- **`.ics`** : fichier standard iCalendar (RFC 5545) joint aux emails de RDV
- **IoC container** : Inversion of Control, service container Laravel
- **Form Request** : classe Laravel encapsulant validation + autorisation

### Annexe C — Maquettes Figma
| Fichier | Page | Statut v7.0 |
|---|---|---|
| 01-HomePage-Vitrine | Accueil | Conservée |
| 02-devis | Formulaire devis | **Adaptée** : services en cases à cocher + zone upload photos |
| 03-urgence | Demande urgente | **Adaptée** : services en cases à cocher + zone upload photos |
| 04-login | Login admin | Conservée |
| 05-dashboard | Tableau de bord | Conservée + entrées sidebar Chantiers/Clients |
| 06-Demandes | Liste demandes | **Adaptée** : colonne services en tags multiples |
| 07-detail | Fiche détail | **Adaptée** : galerie photos + sélecteur priorité + sélecteur chantier + encart équipe |
| 08-calendrier | Calendrier | Conservée (couche 4) |
| 09-archives | Archives | Conservée |
| 10-not_found | 404 admin | Conservée |
| 11-not_found-public | 404 publique | **Adaptée** : « Nouvelle demande » → « Demander un devis » |
| 12-chantiers | Liste chantiers | **À créer** (couche 2) |
| 13-chantier-detail | Détail chantier + assignation | **À créer** (couche 2) — porte le N-N `project_user` |
| 14-client-detail | Fiche client + historique | **À créer** (couche 1) |
| 15-confirmation | Confirmation d'envoi | **À créer** (couche 1) — l'étape 3 du stepper |

### Annexe D — Changelog v6.0 → v7.0
1. **ADR-004 révisé** : fusion des tables `quote_requests` + `quick_requests` → table unique `requests` + `is_quick`
2. **ADR-006 révisé** : réintégration de l'upload photos (table `photos`, 1-N) et des RDV (table `appointments`)
3. **Nouvelle entité `clients`** : extraction des coordonnées hors de la demande → fiche + historique
4. **Nouvelle entité `projects`** (chantiers) + pivot `project_user` (N-N n°2)
5. **Nouvelle entité `services`** + pivot `request_service` (N-N n°1) : une demande peut concerner plusieurs métiers
6. **Nouvelle entité `quotes`** : gestion des devis et relances
7. **`role` sur `users`** : prépare la délégation (compagnons), sans connexion en v7.0 (ADR-008)
8. **`priority` distinguée de `is_quick`** (RG-10, RG-11)
9. **`lost_reason` → `closing_reason`** : une raison est saisie aussi pour les demandes traitées
10. **Nouvel ADR-007** : pas de self-booking client (RDV posés par l'admin)
11. **MCD** : 3 entités / 2 relations → **8 entités / 2 relations N-N**
12. **Planning** : réorganisé en 4 couches empilables sur 7 semaines de code
13. **Maquettes** : 4 écrans à créer (12, 13, 14, 15), 5 à adapter (02, 03, 06, 07, 11)
