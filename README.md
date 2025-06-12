# Backend API - Projet Quiz & Duel

## Présentation
Ce backend Laravel fournit une API REST pour gérer les utilisateurs, quiz, tentatives, duels (quiz-match) et résultats d’activité. Il utilise SQLite en local pour simplifier l’installation.

## Prérequis
- PHP 8.x (avec l’extension `pdo_sqlite` activée)
- Composer
- Git
- (Optionnel) PHPUnit pour exécuter les tests
- Node.js/npm ou autre si vous intégrez via des outils frontend, mais ici seul le backend est concerné.

## Installation locale

1. **Cloner le dépôt**
   ```bash
   git clone <URL_DU_REPO_BACKEND> backend
   cd backend
````

2. **Copier le fichier d’environnement**

   ```bash
   cp .env.example .env
   ```

3. **Configurer SQLite**

   * Créer le fichier de base de données :

     ```bash
     touch database/database.sqlite
     ```
   * Vérifier que le dossier `database/` est accessible en écriture.
   * Dans le fichier `.env`, ajuster :

     ```
     DB_CONNECTION=sqlite
     DB_DATABASE=database/database.sqlite
     ```
   * Supprimer ou commenter les autres variables de connexion (MySQL, Postgres…) si présentes.

4. **Installer les dépendances PHP**

   ```bash
   composer install
   ```

5. **Générer la clé d’application Laravel**

   ```bash
   php artisan key:generate
   ```

6. **Lancer les migrations et les seeders**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

   * Vérifier qu’aucune erreur ne survient et que les tables et données initiales sont bien créées.

7. **Droits sur les dossiers**

   * Vérifier que les dossiers `storage/`, `bootstrap/cache/`, et la base SQLite ont les permissions adéquates pour être lus/écrits.

## Lancement du serveur

* Démarrer le serveur de développement Laravel :

  ```bash
  php artisan serve
  ```

  Par défaut, l’API sera accessible sur `http://127.0.0.1:8000`.

* Tester un endpoint basique :

  * Par exemple, exécuter dans un navigateur ou via cURL/Postman :
    `GET http://127.0.0.1:8000/api/users`

## Variables d’environnement essentielles

Dans `.env` :

```dotenv
APP_NAME="Quiz Duel API"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

> **Important** : Ne pas versionner le fichier `.env`. Ajouter `database/database.sqlite` à `.gitignore`.

## Structure du projet

* **Routes API** : `routes/api.php`
* **Contrôleurs** : `app/Http/Controllers/API/`
* **Form Requests** : `app/Http/Requests/`
* **Modèles Eloquent** : `app/Models/`
* **Migrations** : `database/migrations/`
* **Seeders** : `database/seeders/` (ex. `DatabaseSeeder`, `JsonQuestionSeeder`, `ChallengeSeeder`)
* **Factories** : `database/factories/` pour générer des données lors du seeding ou des tests
* **Configuration** : `config/*.php` (notamment `database.php` pour SQLite)