# SYMBIOZ — Périmètre du projet (v6.0)

**Date de figeage** : 4 juillet 2026
**Statut** : Périmètre définitif — plus aucune modification autorisée avant la soutenance.

Ce fichier est la **source de vérité** du périmètre. En cas de contradiction avec un autre document, c'est ce fichier qui prime.

---

## Stack technique

| Composant | Choix |
|---|---|
| Langage | PHP 8.3 |
| Framework | Laravel 12 |
| Templating | Blade |
| CSS | Tailwind CSS |
| JS | Alpine.js |
| ORM | Eloquent |
| Auth | Laravel Breeze (blade) |
| BDD | MySQL 8 |
| Queue | Driver `database` |
| Dev env | Laravel Sail (Docker) |
| Tests | PHPUnit |
| Deploy | Railway |

---

## ✅ Dans le périmètre (IN SCOPE)

### Site vitrine public
- Page d'accueil (maquette 01)
- Page services (section ou page dédiée selon maquette)
- Formulaire demande de devis (maquette 02) — **retirer le bloc "Photos du chantier"**
- Formulaire Quick Demande (maquette 03) — **retirer le bloc "Photo du problème"**
- Page de confirmation après soumission
- Rate limiting `throttle:10,1` sur les formulaires publics
- Page 404 publique (maquette 11)

### Back-office administrateur
- Login sécurisé (maquette 04) via Breeze
- Dashboard avec KPI (maquette 05) — **retirer bloc "Mes prochains RDV" et "Statistiques mois"**
- Liste des demandes avec recherche, filtres, tri, pagination (maquette 06)
- Fiche détail (maquette 07) — **retirer blocs "Photos jointes" et "Rendez-vous planifié" / "Date de visite technique"**
- Changement de statut : Nouveau → En cours → Traité → Perdu
- `lost_reason` obligatoire si statut = Perdu
- Notes admin internes
- Archivage (soft delete Laravel)
- Page archives (maquette 09) : Restaurer + Supprimer définitivement
- Page 404 admin (maquette 10)
- Notification email admin à chaque nouvelle demande (queue database)

### Transversal
- Docker via Sail
- Tests PHPUnit (8-12 sur les parcours critiques)
- Déploiement en ligne (Railway)
- Git + GitHub, branches `main` / `dev`

---

## ❌ Hors périmètre (OUT SCOPE) — retirés en v6.0

- **Prise de rendez-vous** (pas de `appointment_date`)
- **Vue calendrier** (pas de FullCalendar.js) → **maquette 08 abandonnée**
- **Génération iCal (.ics)**
- **Upload de photos** (pas de `photo_path`) — justification métier §2.7 du CDC
- **API REST** (les 3 endpoints du CDC v5.1)
- **Multi-utilisateurs / rôles avancés** (juste un admin via Breeze)
- **Notifications SMS**
- **Paiement en ligne**

---

## 🎁 Optionnel si en avance (fin sprint 6, uniquement si tout le reste est propre)

- Petit graphique Chart.js sur le dashboard
- Export CSV de la liste des demandes
- Email de confirmation au prospect après soumission
- **Intégration IA légère** (bouton "Résumer cette demande" via API Claude ou Mistral)

---

## Base de données (2 tables métier)

- `users` (Breeze) — administrateur unique
- `quote_requests` — demandes de devis complètes
- `quick_requests` — Quick Demandes rapides

**Pas de FK `user_id`** sur les demandes (visiteurs anonymes).
**Pas de champs** `appointment_date`, `photo_path`.

---

## Règle d'or

> **Le scope est la variable d'ajustement, pas le planning.**

Si un sprint prend du retard, on **coupe une fonctionnalité optionnelle**, on ne décale pas la soutenance.
