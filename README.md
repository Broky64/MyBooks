# 📚 MyBooks - Gestionnaire de bibliothèque personnelle

MyBooks est une application web simple qui vous permet de suivre et organiser vos lectures.  
Vous pouvez ajouter, rechercher, consulter les détails et suivre la progression de lecture de vos livres.

## 🚀 Fonctionnalités

- Ajouter un livre avec :
  - Titre
  - Auteur
  - ISBN
  - Nombre de pages
  - Année de publication
  - Genre
  - Statut de lecture (En cours, Lu, À lire)
  - URL de couverture
  - Description
  - Notes personnelles
  - Progression (%)
  - Date de début de lecture

- Visualisation de la liste de livres
- Recherche par titre ou auteur
- Détails d'un livre
- Statistiques de lecture (livres lus, en cours, pages lues cette semaine, progression globale)
- Sauvegarde des données en **SQLite** (en local)

## 🗂️ Structure du projet

```bash
📂 travaux-d-apop
├── components/
│   └── book-list.php         → Liste des livres
├── database.sqlite          → Base de données SQLite
├── add-book.php             → Formulaire d'ajout de livre
├── book-details.php         → Page de détails d'un livre
├── index.php                → Page d'accueil
└── README.md                → Ce fichier
```

## ⚙️ Installation

1. **Cloner le projet**
```bash
git clone https://github.com/Broky64/MyBooks
cd travaux-d-apop
```

2. **Lancer un serveur PHP local**
```bash
php -S localhost:8000
```

3. **Accéder à l'application**
Ouvrir http://localhost:8000 dans votre navigateur.
