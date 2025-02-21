# Luxury Services - Site de recrutement fictif en Symfony

## Description

**Luxury Services** est une plateforme fictive de recrutement développée en **Symfony 7**.  
Ce projet principalement **backend** s'intègre avec un **frontend fourni** et permet la gestion des offres d'emploi, des candidats et des recruteurs.

## Lien du projet

Le projet est disponible ici (wip)

![image](https://github.com/user-attachments/assets/d685b79a-f994-4962-a51f-17833a51415b)

---

## Fonctionnalités principales

### Dashboard Administrateur
- **Gestion des clients** via **EasyAdmin**.
- **Création et modification** des offres d'emploi.

### Dashboard Client (Recruteur)
- Accès aux **offres d'emploi spécifiques**.
- Création et gestion des offres avec **filtres dynamiques** en fonction de l'utilisateur connecté.
- **Système de gestion des candidatures**.

### Gestion des Offres d'Emploi
- **Affichage des offres** avec **pagination**.
- Utilisation de **QueryBuilders** pour générer des **DTO**, optimisant ainsi les requêtes.

### Système de Messagerie et Notifications
- Envoi de **mails** (contact, confirmation de compte) via **Symfony Mailer**.

### Gestion des Profils Candidats
- **Formulaires dynamiques** permettant aux candidats d'ajouter leurs informations et fichiers.
- **Calcul automatique** du **taux de complétion du profil**.
- **Postulation possible uniquement avec un profil complété à 100%**.

### Sécurité et Rôles
- Gestion des **permissions** selon le rôle utilisateur :
  - **Candidats** : Postuler aux offres.
  - **Recruteurs** : Accès à un **tableau de bord personnalisé**.

### 🗄Données et Persistance
- **Data Fixtures** pour remplir la base de données avec des données fictives.
- Utilisation d'**interfaces** pour structurer le code et garantir l'extensibilité.

---

## 🛠 Installation et Utilisation

### Prérequis

Avant d'installer le projet, assurez-vous d'avoir les éléments suivants :
- **PHP 8+**
- **Symfony CLI**
- **Composer**
- **Node.js** (pour la gestion des assets)
- **Base de données** MySQL

### Installation

#### 1️⃣ Cloner le dépôt  
```bash
git clone https://github.com/NaimDeb/G404_Symfony-LuxuryService.git
cd luxury-services
```
### 2️⃣ Installer les dépendances
```bash
composer install
```
### 3️⃣ Configurer l'environnement
```bash
cp .env .env.local
```
Modifier la ligne correspondante dans .env.local :

```bash
DATABASE_URL="mysql://user:password@127.0.0.1:3306/luxury_services"
```
4️⃣ Lancer la base de données et les migrations

```bash
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```
5️⃣ Ajouter des données fictives

```bash
symfony console doctrine:fixtures:load
```
6️⃣ Lancer le serveur Symfony
```bash
symfony server:start
```
Le projet est maintenant accessible sur http://127.0.0.1:8000.
