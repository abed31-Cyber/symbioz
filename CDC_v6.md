# Cahier des charges SYMBIOZ v6.0

**Application web de gestion des demandes clients pour artisans du BTP**
Version 6.0 (Laravel — périmètre resserré) — 4 juillet 2026
Auteur : Abed BEKKOUCHE — École La Plateforme Toulouse — Formation DWWM

---

## 1. Contexte

### 1.1 Contexte professionnel
SYMBIOZ est une application web monolithique développée dans le cadre de la formation DWWM. Le projet répond à un besoin métier du BTP second œuvre : les artisans solo gèrent leur acquisition client de manière désorganisée (post-it, Excel, WhatsApp), entraînant une perte de 30-40% des prospects.

### 1.2 Objectifs
| Objectif | Métrique |
|---|---|
| Centralisation des demandes | 100% des demandes entrantes |
| Temps de traitement | < 2 min de réception au statut "En cours" |
| Réactivité différenciée | Rappel 2h (Quick) / 48h (devis) |
| Visibilité commerciale | KPI temps réel sur dashboard |

### 1.3 Périmètre

**IN SCOPE** :
- Site vitrine + 2 formulaires publics (devis et Quick Demande)
- Back-office sécurisé (Laravel Breeze)
- Pipeline commercial (Nouveau → En cours → Traité / Perdu)
- Recherche, filtres, pagination
- Archivage (soft delete) et suppression définitive RGPD
- Notification email admin à chaque nouvelle demande
- Dashboard KPI par statut

**OUT SCOPE (retirés en v6.0)** :
- Prise de RDV, calendrier, iCal
- Upload photos
- API REST publique
- Multi-utilisateurs / rôles
- SMS, paiement, mobile natif

### 1.4 Personas
- **Karim** (42 ans) : artisan plombier admin, mobile-first
- **Sophie** (34 ans) : cliente urgente, iPad
- **Pascal** (38 ans) : prospect exigeant, compare plusieurs sites

---

## 2. Besoins fonctionnels

### 2.1 Objectifs fonctionnels
| Code | Objectif | Priorité |
|---|---|---|
| OF-1 | Soumission de demandes sans compte | MVP |
| OF-2 | Centraliser dans un tableau de bord | MVP |
| OF-3 | Suivre le pipeline commercial | MVP |
| OF-4 | Notifier admin par email | MVP |
| OF-5 | Archiver + supprimer RGPD | MVP |

### 2.2 User Stories

**EPIC 1 — Public**
- US-1.1 : Visiteur → consulter accueil
- US-1.2 : Visiteur → consulter services
- US-1.3 : Prospect → remplir formulaire devis
- US-1.4 : Prospect pressé → faire Quick Demande

**EPIC 2 — Admin**
- US-2.1 : Se connecter sécurisé
- US-2.2 : Voir dashboard
- US-2.3 : Consulter liste des demandes (paginée, triée)
- US-2.4 : Filtrer et rechercher
- US-2.5 : Modifier statut d'une demande
- US-2.6 : Consulter détail + ajouter notes
- US-2.7 : Archiver une demande
- US-2.8 : Supprimer définitivement (RGPD)
- US-2.9 : Restaurer une archive
- US-2.10 : Se déconnecter
- US-2.11 : Recevoir notification email

**Critères d'acceptation US-1.3 (devis)** :
- Champs : prénom, nom, email (RFC), téléphone (10 chiffres), adresse, service, description (min 10 car.), budget optionnel
- Rate limit 10/min/IP
- Confirmation visuelle après soumission

### 2.3 Rôles
| Rôle | Permissions |
|---|---|
| Visiteur | Consulter accueil, services, formulaires |
| Prospect | Soumettre devis / Quick Demande (sans compte) |
| Admin | Accès complet back-office |

### 2.4 Règles de gestion
| ID | Condition | Action |
|---|---|---|
| RG-1 | Admin consulte fiche | Données déclaratives = lecture seule |
| RG-2 | Statut = Perdu | `lost_reason` obligatoire |
| RG-3 | Suppression demandée | Doit être archivée d'abord (soft delete) |
| RG-4 | Archive présente | Actions Restaurer + Suppr définitive dispo |
| RG-5 | Formulaire public soumis | Rate limit 10 req/min/IP |
| RG-6 | Nouvelle demande créée | Notification email admin (queue) |

### 2.5 Cas d'utilisation

**UC-1 : Demander un devis (Prospect)**
1. Accès formulaire devis
2. Saisie coordonnées + service + description + budget optionnel
3. Soumission → Form Request valide
4. Création en base avec status=nouveau
5. Notification email admin dispatchée en queue

**UC-2 : Faire une Quick Demande (Prospect pressé)**
1. Accès page urgence
2. Saisie nom + service + description + téléphone (email/adresse optionnels)
3. Soumission → création avec status=nouveau
4. Notification admin

**UC-3 : Traiter une demande (Admin)**
1. Ouvre fiche
2. Consulte données déclaratives (lecture seule)
3. Ajoute/modifie notes internes
4. Change statut (Nouveau → En cours → Traité / Perdu)
5. Si Perdu : raison obligatoire
6. Enregistre

### 2.6 Choix métier — retraits v6.0

**Retrait upload photos** : dans le BTP, un artisan sérieux se déplace pour chiffrer sur place. Photos à distance peu fiables (cadrage, lumière). Pour urgence, échange téléphonique + SMS/WhatsApp suffit. Éviter la complexité (validation MIME, compression, stockage, sécurité, hash) sans valeur métier réelle. Principe KISS.

**Retrait prise de RDV / calendrier / iCal** : la partie techniquement la plus lourde du projet initial. Pour un artisan solo, un champ notes internes suffit. Le pipeline commercial reste le cœur métier. Simplification pour tenir les délais et livrer un projet fini de qualité.

---

## 3. Spécifications techniques

### 3.1 Stack

**Backend**
- PHP 8.3
- Laravel 12
- Eloquent ORM
- Laravel Breeze (auth blade)
- Form Requests
- Laravel Queue (driver `database`)
- Laravel Notifications

**Base de données**
- MySQL 8 (source de vérité)
- Queue driver `database`
- Session driver `database`

**Front**
- Blade (rendu serveur)
- Tailwind CSS (mobile-first)
- Alpine.js (dropdowns, modales)
- Chart.js (optionnel dashboard)

**Outils**
- Laravel Sail (Docker préconfiguré)
- PHPUnit
- Git + GitHub (branches main / dev)
- Figma (maquettes réalisées)
- Mailpit (capture emails dev)
- Railway ou Render (hébergement)

### 3.2 Architecture

**Pattern : MVC + couche Service**
```
Route → Form Request → Controller (fin, 10-15 lignes) → Service → Model → MySQL
```

Principes :
- Contrôleurs fins : orchestration uniquement
- Logique métier centralisée dans Services (testable)
- Form Requests pour validation déclarative
- Injection de dépendances via service container (IoC)

### 3.3 Concepts Laravel défendus en soutenance
- Injection de dépendances (constructor + method injection)
- IoC container et service providers
- Façades (Auth, DB, Notification, Route)
- Form Requests avec `authorize()`, `rules()`, `messages()`
- Eloquent : casts d'enums, scopes locaux, SoftDeletes
- Middleware (auth, throttle)
- Laravel Notifications (canal mail)
- Blade Components réutilisables

### 3.4 Sécurité
| Couche | Mesure | Implémentation |
|---|---|---|
| Auth | Bcrypt | Breeze natif |
| Session | Sécurisée | Driver database, régén CSRF |
| Formulaires | CSRF token | @csrf natif |
| Validation | Stricte | Form Requests |
| Rate limiting | Throttle | `throttle:10,1` |
| Anti-énumération | Message générique | "Identifiants incorrects" |
| Données client | Lecture seule | RG-1 |
| SQL Injection | Requêtes paramétrées | Eloquent PDO bindings |
| XSS | Échappement Blade | `{{ }}` échappe auto |
| RGPD | Soft + hard delete | Droit à l'oubli |

---

## 4. Base de données

### 4.1 MCD (Modèle Conceptuel)
3 entités, 2 relations.

**Entités** : USER, DEMANDE_DEVIS, DEMANDE_URGENTE

**Relations** :
- USER (1,1) — gère — (0,n) DEMANDE_DEVIS
- USER (1,1) — gère — (0,n) DEMANDE_URGENTE

Note : entité RENDEZ_VOUS supprimée en v6.0.

### 4.2 MLD (Modèle Logique)

**users** (généré par Breeze)
- id (PK), name, email (UNIQUE), email_verified_at, password (bcrypt), remember_token, timestamps

**quote_requests**
- id (PK)
- first_name, last_name (VARCHAR 100, NOT NULL)
- email, phone (NOT NULL)
- address (NULL)
- service_type (ENUM 5 valeurs, NOT NULL)
- description (TEXT NOT NULL, min 10 car.)
- budget_estimate (DECIMAL 10,2, NULL)
- status (ENUM 4 valeurs, DEFAULT 'nouveau')
- admin_notes (TEXT NULL)
- lost_reason (TEXT NULL — obligatoire si status=perdu)
- timestamps + deleted_at (SoftDeletes)
- INDEX : status, created_at

**quick_requests**
- id (PK)
- contact_name, contact_phone (NOT NULL)
- contact_email (NULL)
- address (NULL)
- service_type (ENUM NOT NULL)
- description (TEXT NOT NULL)
- status (ENUM DEFAULT 'nouveau')
- admin_notes, lost_reason (NULL)
- timestamps + deleted_at
- INDEX : status, created_at

**Note importante** : pas de FK `user_id` sur les demandes. Les demandes sont anonymes (visiteurs sans compte), l'admin les gère globalement.

### 4.3 MPD (SQL)

```sql
-- Table users (Breeze)
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table quote_requests
CREATE TABLE quote_requests (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address VARCHAR(255) NULL,
  service_type ENUM('plomberie','electricite','peinture','platrerie','menuiserie') NOT NULL,
  description TEXT NOT NULL,
  budget_estimate DECIMAL(10,2) NULL,
  status ENUM('nouveau','en_cours','traite','perdu') NOT NULL DEFAULT 'nouveau',
  admin_notes TEXT NULL,
  lost_reason TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  INDEX idx_status (status),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table quick_requests
CREATE TABLE quick_requests (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  contact_name VARCHAR(100) NOT NULL,
  contact_phone VARCHAR(20) NOT NULL,
  contact_email VARCHAR(255) NULL,
  address VARCHAR(255) NULL,
  service_type ENUM('plomberie','electricite','peinture','platrerie','menuiserie') NOT NULL,
  description TEXT NOT NULL,
  status ENUM('nouveau','en_cours','traite','perdu') NOT NULL DEFAULT 'nouveau',
  admin_notes TEXT NULL,
  lost_reason TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  INDEX idx_status (status),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 5. Contraintes non fonctionnelles

### 5.1 Performance
- Chargement page < 2s (Lighthouse)
- Pagination 15/page (Laravel natif)
- Volumes MVP < 1000 lignes (pas de cache)

### 5.2 Responsive (mobile-first)
- Mobile < 768px : Karim sur téléphone (sidebar collapsée, KPI empilés)
- Tablette 768-1024 : Sophie sur iPad
- Desktop > 1024 : Pascal sur ordinateur

### 5.3 Accessibilité
- Contraste WCAG AA
- Navigation clavier complète
- ARIA labels sur icônes
- Structure sémantique HTML5

### 5.4 Maintenabilité
- Architecture Controller → Service → Model
- Conventions Laravel strictes
- README + PHPDoc
- 8-12 tests PHPUnit critiques
- Branches main / dev, conventional commits

### 5.5 Critères de validation
| Critère | Méthode |
|---|---|
| Fonctionnalité | Tests PHPUnit |
| Sécurité | Audit OWASP (CSRF, XSS, injection, throttle) |
| Accessibilité | WAVE / axe DevTools |
| Performance | Lighthouse ≥ 90 |
| Responsive | Test iPhone SE, Pixel |

---

## 6. Planning (8 semaines de code + soutenance)

| Semaine | Dates | Sprint | Objectif |
|---|---|---|---|
| S1 | 07-13/07 | Sprint 0 | Setup Laravel + Sail + Breeze + Migrations + Modèles + Seeders + Deploy à blanc |
| S2 | 14-20/07 | Sprint 1 | Site vitrine (accueil, services, formulaire devis) + Form Requests + Confirmation |
| S3 | 21-27/07 | Sprint 2 | Quick Demande + Layout admin + Login + Middleware |
| S4 | 28/07-03/08 | Sprint 3 | Dashboard KPI + Liste demandes + Recherche + Filtres + Pagination |
| S5 | 04-10/08 | Sprint 4 | Fiche détail + Changement statut + lost_reason + Notes admin |
| S6 | 11-17/08 | Sprint 5 | Archivage (soft delete) + Restauration + Suppr définitive + Notif email |
| S7 | 18-24/08 | Sprint 6 | Tests PHPUnit + Polish (responsive, a11y) + Refactoring |
| S8 | 25-31/08 | Sprint 7 | Doc, dossier professionnel, déploiement final Railway |
| S9 | 01-07/09 | Soutenance | Simulations + Passage du titre |

**Règle d'or : le scope est la variable d'ajustement, pas le planning.**

### Matrice des risques
| Risque | Prob. | Impact | Mitigation |
|---|---|---|---|
| Déploiement échoue | Moyen | Élevé | Deploy à blanc dès S1 |
| Retard sur feature | Élevé | Moyen | On coupe, on ne décale pas |
| Bugs en soutenance | Moyen | Élevé | Tests + soutenance blanche |
| Scope creep | Élevé | Élevé | Périmètre v6.0 figé au 04/07 |

---

## 7. Matrice de traçabilité

| User Story | OF | RG | UC | Priorité |
|---|---|---|---|---|
| US-1.3 | OF-1 | RG-5 | UC-1 | MVP |
| US-1.4 | OF-1 | RG-5 | UC-2 | MVP |
| US-2.1 à 2.4 | OF-2 | — | — | MVP |
| US-2.5 | OF-3 | RG-1, RG-2 | UC-3 | MVP |
| US-2.6 | OF-3 | RG-1 | UC-3 | MVP |
| US-2.7 | OF-5 | RG-3 | — | MVP |
| US-2.8 | OF-5 | RG-4 | — | MVP |
| US-2.9 | OF-5 | RG-4 | — | MVP |
| US-2.11 | OF-4 | RG-6 | — | MVP |

---

## 8. Annexes

### Annexe A — ADR (Architecture Decision Records)
| ID | Décision | Justification |
|---|---|---|
| ADR-001 | Laravel 12 + Blade + Alpine + Tailwind + MySQL | Cohérence stack, Breeze fournit auth, courbe adaptée |
| ADR-002 | Controller → Service → Model | Testabilité, séparation responsabilités |
| ADR-003 | Fullstack Blade (pas SPA React) | Simplicité, un serveur, matche référentiel DWWM |
| ADR-004 | 2 tables séparées (quote/quick) | Entités métier distinctes, contraintes différentes |
| ADR-005 | Pas de FK user_id sur demandes | Demandes anonymes (visiteurs) |
| ADR-006 | Retrait RDV + upload photo | Simplification métier §2.6, respect planning |

### Annexe B — Glossaire
- **Quick Demande** : demande urgente rapide (sans photo en v6.0)
- **Soft delete** : suppression logique (deleted_at)
- **Hard delete** : suppression physique irréversible
- **Pipeline commercial** : Nouveau → En cours → Traité / Perdu
- **MVP** : Minimum Viable Product
- **IoC container** : Inversion of Control, service container Laravel
- **Form Request** : classe Laravel encapsulant validation + autorisation

### Annexe C — Maquettes Figma
| Fichier | Page | Statut v6.0 |
|---|---|---|
| 01-HomePage-Vitrine | Accueil | Conservée |
| 02-devis | Formulaire devis | Conservée (retirer bloc "Photos") |
| 03-urgence | Quick Demande | Conservée (retirer bloc "Photo") |
| 04-login | Login admin | Conservée |
| 05-dashboard | Tableau de bord | Conservée (retirer RDV/stats mois) |
| 06-Demandes | Liste demandes | Conservée |
| 07-detail | Fiche détail | Adaptée (retirer photos + RDV) |
| 08-calendrier | Calendrier | **RETIRÉE** en v6.0 |
| 09-archives | Archives | Conservée |
| 10-not_found | 404 admin | Conservée |
| 11-not_found-public | 404 publique | Conservée |

### Annexe D — Changelog v5.1 → v6.0
1. Stack : Symfony 7 → **Laravel 12**. Twig → Blade. Doctrine → Eloquent. FormRequest → Form Request.
2. Périmètre : retrait RDV, calendrier, iCal
3. Périmètre : retrait upload photo
4. Périmètre : retrait API REST (post-MVP)
5. MCD : suppression entité RENDEZ_VOUS, renommage ADMINISTRATEUR → USER
6. MLD/MPD : suppression appointment_date, photo_path, FK user_id
7. Objectifs : refonte (OF-4 = notif email, OF-5 = RGPD)
8. Règles gestion : nouvelles RG-4 (archive/restauration) et RG-6 (notif email)
9. User Stories : suppression US-2.7 (RDV), US-2.8 (calendrier), ajout US-2.9 (restauration)
10. Maquettes : maquette 08 retirée, 02/03/07 à adapter
11. Planning : réorganisé sur 8 semaines de code
