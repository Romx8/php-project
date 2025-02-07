# 🎾 Plateforme de Gestion de Tournois

Bienvenue sur la plateforme de gestion de tournois ! Ce projet permet aux utilisateurs de créer, rejoindre et suivre des tournois, ainsi que de gérer leur progression à travers un système d'élimination directe. Une interface administrateur permet la gestion complète des utilisateurs, équipes et tournois.

---

## 🚀 Installation et Configuration

### 📋 **1. Prérequis**

Avant de commencer, assure-toi d'avoir installé :

- [PHP 8.1+](https://www.php.net/)
- [Composer](https://getcomposer.org/download/)
- [Symfony CLI](https://symfony.com/download)
- [MySQL](https://www.mysql.com/)

---

### ⚙️ **2. Cloner le projet**

```sh
git clone https://github.com/Romx8/php-project.git
cd php-project
```

---

### 📦 **3. Installer les dépendances**

```sh
composer install
```

---

### 🛠 **4. Configurer la base de données**

1. **Créer un fichier **`` et modifier la ligne suivante :

   ```
   DATABASE_URL="mysql://root:@127.0.0.1:3306/tournament_db?serverVersion=8.0"
   ```

   ⚠️ **Remplace **``** par ton utilisateur MySQL et ajoute ton mot de passe si nécessaire.**

2. **Créer la base de données et exécuter les migrations :**

   ```sh
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

3. **(Facultatif) Charger des données de test :**

   ```sh
   php bin/console doctrine:fixtures:load
   ```

---

### 🌐 **5. Lancer le serveur Symfony**

```sh
symfony serve
```

📍 L'application est maintenant accessible sur :\
👉 [**http://127.0.0.1:8000/**](http://127.0.0.1:8000/)

---

## 📌 **Utilisation**

### 🎮 **Utilisateur non connecté**

- Accéder à la **landing page**
- **Créer un compte**
- **Se connecter**

### 👤 **Utilisateur connecté**

- **Voir son profil et le modifier**
- **Voir la liste des tournois**
- **Créer une équipe**
- **Rejoindre une équipe**
- **Inscrire une équipe à un tournoi**
- **Voir l’avancement des tournois**

### 🔧 **Administrateur**

- Accéder au **Panel Admin** (`/admin`)
- **Gérer les utilisateurs, équipes, tournois et matchs**
- **Faire avancer les phases des tournois**
- **Désigner le gagnant du tournoi**

---

## 🔒 **Sécurité**

- Les routes sensibles (`/admin`, `/create-tournament`, etc.) sont protégées par des **rôles utilisateurs (**``**, **``**)**.
- **Seuls les administrateurs** peuvent accéder au panel admin et gérer les entités.
- Un utilisateur ne peut pas rejoindre un tournoi **si les inscriptions sont fermées**.

---

## 🛠 **Développement**

### 📚 **Générer une nouvelle migration**

```sh
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### 🛠 **Vider le cache**

```sh
php bin/console cache:clear
```
---

## 👤 **Auteur**

👨‍💻 **Bernard Roméo**\
📧 [**romeo.bernard@ynov.com**](mailto\:romeo.bernard@ynov.com)\

