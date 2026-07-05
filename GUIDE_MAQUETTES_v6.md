# SYMBIOZ — Guide de refonte des maquettes Figma pour la v6.0

Les maquettes existantes sont **très bonnes visuellement** mais contiennent des éléments hors périmètre v6.0.
Voici les modifications précises à faire, maquette par maquette.

**Astuce Figma** : ne supprime pas les blocs, mets-les dans une frame "Archive v5.1" pour garder la trace. Duplique tes pages et travaille sur les copies v6.0.

---

## 01 — Accueil vitrine
✅ **Aucun changement.** Conservée telle quelle.

## 02 — Formulaire demande de devis
🔧 **Retirer** :
- Tout le bloc "Photos du chantier (Optionnel)" avec la zone drag & drop.

🔧 **Ajuster** :
- Rapprocher le bouton "Envoyer ma demande de devis" du bloc "Votre projet".

## 03 — Formulaire Quick Demande
🔧 **Retirer** :
- Tout le bloc "Photo du problème (Recommandé)" avec la zone drag & drop.

🔧 **Ajuster** :
- Ligne d'infos du bas : garder "Rappel sous 2 min" et "Compagnons assurés", retirer "Tarifs annoncés avant intervention" si tu veux (facultatif).

## 04 — Login admin
✅ **Aucun changement.** Conservée telle quelle.

## 05 — Dashboard
🔧 **Retirer** :
- Bloc "MES PROCHAINS RDV" (avec les 3 lignes 09:00, 14:00, 16:30).
- Bloc "STATISTIQUES MOIS" (12 chantiers terminés +14%).

🔧 **Adapter les KPI** :
- Remplacer "TAUX CONVERSION" par "DEMANDES ARCHIVÉES" (compteur simple).
- Ou garder les 4 KPI actuels si tu implémentes le calcul (DEMANDES CE MOIS, CA POTENTIEL, TAUX CONVERSION, DELAI MOYEN).

🔧 **Garder** :
- Graphique évolution des demandes (Chart.js optionnel)
- Bandeau "A TRAITER EN PRIORITÉ"
- Pipeline commercial en colonnes
- Bloc "Devis à relancer"
- Bloc "CONSEIL PIPELINE"

## 06 — Liste des demandes
✅ **Aucun changement majeur.** Conservée.

🔧 **Petit ajustement** :
- Colonne "PRIORITÉ" avec badge "Urgent" : la conserver en la calculant depuis la table `quick_requests` (toute Quick Demande = urgente).

## 07 — Fiche détail
🔧 **Retirer** :
- Bloc "Photos jointes" avec les 2 images bleues et le bouton "+ Ajouter".
- Bloc "Rendez-vous planifié" (20 Juin 2026 à 14:00 + bouton "Générer l'invitation").
- Champ "DATE DE VISITE TECHNIQUE" avec date-time picker.

🔧 **Conserver** :
- L'étape du pipeline commercial en haut (Nouveau → En cours → Traité → Perdu)
- Données prospect (lecture seule)
- Description du projet
- Bloc "Gestion commerciale" (changement de statut)
- Champ "RAISON SI PERDU"
- Champ "NOTES INTERNES"
- Actions Archiver / Supprimer / Enregistrer

## 08 — Calendrier
❌ **ABANDONNÉE en v6.0.**

Ne pas mentionner dans le DP sauf en Annexe D (changelog v5.1 → v6.0).

## 09 — Archives
✅ **Conservée.** Belle maquette.

🔧 **Petits ajustements possibles** :
- KPI en haut : "TOTAL ARCHIVE", "TRAITÉS", "PERDUS" — parfait tel quel.
- Actions Restaurer + Supprimer définitivement : parfaites.

## 10 — 404 admin
✅ **Aucun changement.** Conservée.

## 11 — 404 publique
✅ **Aucun changement.** Conservée.

---

## Priorisation pratique

Si tu manques de temps sur Figma, **priorise** les ajustements dans cet ordre :

1. **Maquettes 02, 03, 07** (impact fort — visibles en démo)
2. **Maquette 05** (dashboard — visible en démo)
3. **Le reste** (visibles mais moins critique)

**Alternative pragmatique** : ne modifie pas Figma, mais **dans ton dossier professionnel, ajoute une note** :

> "Les maquettes Figma initiales couvraient un périmètre plus large (v5.1) incluant la prise de RDV et l'upload photo. Ces fonctionnalités ont été retirées en v6.0 (voir §2.7 du CDC). Les éléments correspondants dans les maquettes n'ont pas été implémentés."

Cette approche est **totalement acceptable en soutenance** et t'économise du temps Figma pour le code.
