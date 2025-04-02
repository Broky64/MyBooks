<?php

$db = new SQLite3('database.sqlite');

// Création de la table "books" avec toutes tes spécifications
$db->exec('CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    author TEXT NOT NULL,
    isbn TEXT,
    pages INTEGER NOT NULL,
    publication_year INTEGER,
    genre TEXT,
    reading_status TEXT,
    cover_url TEXT,
    description TEXT,
    personal_notes TEXT,
    progress INTEGER DEFAULT 0,
    started_at DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');

// Création de la table pour le suivi détaillé des lectures (logs)
$db->exec('CREATE TABLE IF NOT EXISTS reading_logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    book_id INTEGER NOT NULL,
    date DATE NOT NULL,
    pages_read INTEGER NOT NULL,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
)');

echo "Base de données initialisée avec succès !";
