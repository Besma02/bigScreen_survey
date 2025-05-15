# 📊 Projet  Bigscreen_survey

Application web pour l’entreprise **Bigscreen VR**. Il s'agit d'une plateforme de sondage en ligne divisée en trois interfaces : une interface publique pour répondre à un sondage,
une page de consultation des réponses via un lien unique, et une interface d'administration sécurisée permettant d'examiner les résultats.

## 🧾 Sommaire

- [Présentation](#présentation)
- [Technologies utilisées](#technologies-utilisées)
- [Fonctionnalités](#fonctionnalités)
- [Déploiement local](#déploiement-local)
- [Structure du projet](#structure-du-projet)


---

## 🧠 Présentation

**Nom du projet :** Bigscreen_survey 
**Date :** Mai 2025  
**Client :** Bigscreen VR (https://bigscreenvr.com/)  
**But :** Recueillir des informations précieuses auprès des utilisateurs pour orienter les futures évolutions de l'application VR Bigscreen.

---

## 🛠 Technologies utilisées

### Frontend
- Vue.js 3
- Vue Router
- Chart.js (statistiques)
- TailwindCSS 

### Backend
- Laravel 10
- MySQL
- Sanctum (authentification )
- Faker (données de test)

---

## ✅ Fonctionnalités

### Interface publique
- Affichage des 20 questions
- Réponses obligatoires avec validation de l’email
- Génération d’un lien unique après soumission

### Page de consultation
- Accès via une URL sécurisée sans ID utilisateur
- Affichage des réponses enregistrées

### Interface administrateur
- Authentification (login/mot de passe)
- Dashboard avec graphiques (Chart.js)
- Tableau des questions
- Liste des réponses avec détail par utilisateur

---

## 🚀 Déploiement local

### Prérequis
- PHP >= 8.1
- Node.js >= 16
- Composer
- MySQL
- Git hub

### Étapes

```bash
# Cloner le repo
git clone https://github.com/Besma02/bigScreen_survey
cd sondage-bigscreen

# Installer les dépendances backend
composer install
cp .env.example .env
php artisan key:generate

# Configurer la base de données dans le fichier .env
# Puis lancer les migrations :
php artisan migrate --seed

# Installer les dépendances frontend
cd frontend
npm install
npm run dev
