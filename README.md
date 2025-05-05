# **I-EVENTS - Gestion des évenements **

## Description du Projet 🗒️ 

**I-EVENTS** est une application web développée avec **Symfony 6.4** et **PHP 8.2**, conçue pour simplifier la gestion des evenements  pour les utilisateurs et organisateurs.

**Contexte :**  ✨

La création de l’application I-EVENTS est motivée par les défis actuels rencontrés dans l’organisation d’événements. Ce domaine, bien que central dans la vie sociale et professionnelle, souffre souvent d’un manque d’outils adaptés,
Cette application vise à optimiser chaque aspect de l’organisation, en offrant une plateforme intuitive, collaborative et efficace. I-EVENTS ambitionne de transformer la manière dont les événements sont conçus et vécus, en simplifiant la coordination entre organisateurs, participants et prestataires.

**Fonctionnalités principales :**

- ** Gestion des utilisateurs ** : CRUD, tri/recherche Ajax, statistiques (Chart.js), intégration Google OAUTH, re-captcha, Mailing, pagination. 
- ** Gestion des evenements ** : CRUD, tri/recherche Ajax, statistiques (Chart.js), intégration Gemini IA, calendrier (FullCalendar.js), pagination.
- **Gestion des réclamations ** : CRUD, pagination, statistiques (Chart.js), intégration d’API (détection de langue, envoi d’e-mails, filtrage intelligent des messages en temps réel via IA), traitement automatisé.
- **Gestion d'equipements ** : CRUD, pagination, statistiques (Chart.js), recherche Ajax, intégration d’API (envoi d’e-mails personalise ), code a barre , pdf (personalisé)
- **Gestion de réservations ** : CRUD, pagination, affichage des statistiques dynamiques (Chart.js), calcul automatique du taux de confirmation, filtrage par statut, Impression du ticket personnalisé avec les données de réservation ,Paiement sécurisé via Stripe API.

## Table des Matières 📋

- [Installation](#installation)  
- [Utilisation](#utilisation)  
- [Technologies](#technologies)  
- [Contributions](#contributions)  
- [Licence](#licence)

---

## Installation

### Prérequis 📦

- **XAMPP** (Apache, MySQL, PHP 8.2)  
  https://www.apachefriends.org/index.html  
- **Composer** (pour les dépendances Symfony)  
  https://getcomposer.org  

### Étapes

1. Clonez le repository :

   git clone https://github.com/rayssen1/symfonyprojet.git  
   cd I-Events

2. Si vous utilisez WAMP ou XAMPP :
   - Placez le projet dans le dossier `www` (WAMP) ou `htdocs` (XAMPP).
   - Démarrez Apache et MySQL depuis l'interface de WAMP/XAMPP.

3. Installez les dépendances :

   composer install  
   npm install

4. Configurez la base de données :
   - Créez une base MySQL via phpMyAdmin.
   - Modifiez le fichier `.env` :

     DATABASE_URL="mysql://root:@localhost:3306/I-events"

   - Migrez les entités :

     php bin/console doctrine:migrations:migrate

5. Lancez le serveur :

   symfony serve

---

## Utilisation

### Accès 🔑

- Frontend : http://localhost:8000  
- Admin : http://localhost:8000/Dashboard (identifiants à configurer)

### Fonctionnalités clés

- **Réservation de evenements :**  
  Sélectionnez un evenement, vérifiez les disponibilités via Ajax, générez un ticket PDF avec QR code.

- **Gestion des evenements :**  
  creation des evenements avec la synchronisation via google calendar - **Tableau de bord :**  
  Visualisez les statistiques (Chart.js) et les calendriers (FullCalendar.js).
-** Authentification via Google OAuth et creation du compte avec vérification reCAPTCHA pour plus de sécurité. Envoi d’e-mails de confirmation et de notifications automatisées.
 - **Gestion des réclamations :**  
Soumission et suivi des réclamations avec filtrage intelligent en temps réel via IA, validation automatique des messages rédigés en anglais grâce à une API de détection de langue, envoi de notifications par e-mail, traitement automatisé des contenus, et affichage des statistiques dynamiques (Chart.js).
-  **Gestion des équipements :**  
Soumission et suivi des équipements avec envoi de notifications par e-mail du stock manquants , traitement automatisé des contenus, et affichage des statistiques dynamiques (Chart.js).
-  **Gestion des réservations :** 
Suivi des réservations (confirmées, annulées, en attente), filtrage par statut, calcul du taux de confirmation, génération de tickets à imprimer, et intégration du paiement par Stripe.


  **Tableau de bord :**  
  Visualisez les statistiques des utilisateur et des session (Chart.js)
---

## Technologies

- **Backend** : Symfony 6.4, PHP 8.2,Ajax,API GoogleCalendar  
- **Frontend** : Twig, Ajax, Chart.js,API Gemini
- **Base de données** : MySQL  
- **Outils** : XAMPP, Composer, WebSocket

---

## Contributions

Les contributions sont bienvenues ! Suivez ces étapes :

1. Forkez le projet.
2. Créez une branche :

   git checkout -b feature/nouvelle-fonctionnalite

3. Committez vos modifications :

   git commit -m "Ajout d'une fonctionnalité"

4. Poussez vers la branche :

   git push origin feature/nouvelle-fonctionnalite

5. Ouvrez une Pull Request.

### Contributeurs 👥

Nous remercions tous ceux qui ont contribué à ce projet !  
Les personnes suivantes ont contribué à ce projet en ajoutant des fonctionnalités, en corrigeant des bugs ou en améliorant la documentation :

- [Kliche Alaeddine](https://github.com/rayssen1) – Développement de gestion Utilisateur 
- [Draouil Rayssen](https://github.com/rayssen1) – Développement de gestion Evenements
- [Mohamed Rabeh](https://github.com/MohamedRabeh1) – Développement de la gestion des réclamations  
- [Amal Trad](https://github.com/AmalTrad16) – Développement de la gestion des équipements
- [Baya Khouini](https://github.com/Batta0102) – Développement de la gestion des réservations

---

## Licence

Ce projet est sous licence ROC. Pour plus de détails, consultez le fichier [LICENSE](./LICENSE).

---

## Topics GitHub

#symfony #php #sport #webapp #ajax #chartjs #websocket #python #qrcode #stripe 
