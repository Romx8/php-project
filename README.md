# 🎾 Plateforme de Gestion de Tournois

Bienvenue sur la plateforme de gestion de tournois ! Ce projet Symfony permet aux utilisateurs de créer, rejoindre et suivre des tournois, ainsi que de gérer leur progression à travers un système d'élimination directe. Une interface administrateur permet la gestion complète des utilisateurs, équipes et tournois.

---

## 🚀 Installation et Configuration

### 📋 **1. Cloner le projet**
```sh
git clone https://github.com/Romx8/php-project.git
cd php-project
```

### ⚙️ **2. Installer les dépendances nécessaires**
Assurez-vous d'avoir installé :
- **PHP >8.3**
- **Composer >2.8.1**
- **Symfony >7.0**
- **Faker**

Installez ensuite les dépendances du projet :
```sh
composer install
```

### 🛠 **3. Configurer la base de données**
1. **Modifier le fichier `.env`** avec vos informations MySQL :
   ```
   DATABASE_URL="mysql://utilisateur:MDP@127.0.0.1:3306/NOMDELADB"
   ```

2. **Démarrer MySQL et phpMyAdmin**
   ```sh
   sudo systemctl start mysqld
   sudo systemctl enable --now httpd
   ```

3. **Créer la base de données et mettre à jour le schéma :**
   ```sh
   php bin/console doctrine:database:create
   php bin/console doctrine:schema:update --force
   ```

### 📊 **4. Remplir la base de données avec Faker**
```sh
php bin/console doctrine:fixtures:load
```

---

## 🔑 **Comptes Utiles**
### Admin
- **Email:** `admin@admin.com`
- **Mot de passe:** `admin123`

---

## 🌐 **Lancer le projet**
```sh
symfony serve
```
📍 L'application est maintenant accessible sur :
👉 **http://127.0.0.1:8000/**

---

## 👤 **Auteur**
👨‍💻 **Roméo Bernard**

