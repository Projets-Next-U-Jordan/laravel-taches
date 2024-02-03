# Projet Laravel | Validation de connaissance | Next-U
## Fait par Jordan. C

- Créer des tâches
- Les tâches ont un nom, une datetime et une catégorie
- Les catégories ont une couleur assigné
- Il faut pouvoir afficher les tâches dans un calendrier.
- CRUD Tâches + CRUD Catégories

# Installation

1. Cloner le dépôt

2. Installer les dépendances du projet:
```bash
cd laravel-taches
composer install
```

4. Copier .env.example en .env

5. Le configurer si nécéssaire

6. Lancer la migration de la base de donnée
```bash
php artisan migrate
```

7. Lancer le serveur de développement:
```bash
php artisan serve
```