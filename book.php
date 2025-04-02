<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details - My Reading Tracker</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>
<div class="container">
    <?php
    // Exemple de récupération de l'id via URL
    $bookId = $_GET['id'] ?? null;

    // À remplacer ultérieurement par une requête SQL
    $book = [
        'id' => $bookId,
        'title' => 'Atomic Habits',
        'author' => 'James Clear',
        'cover' => '/covers/atomic-habits.jpg',
        'pages' => 320,
        'started_at' => '2024-03-01',
        'progress' => 50
    ];
    ?>

    <div class="header">
        <a href="index.php" class="btn secondary">
            <i data-lucide="arrow-left" class="icon"></i> Back
        </a>

        <div class="actions">
            <a href="edit-book.php?id=<?= htmlspecialchars($book['id']) ?>" class="btn primary">
                <i data-lucide="edit" class="icon"></i> Edit
            </a>
            <a href="delete-book.php?id=<?= htmlspecialchars($book['id']) ?>" class="btn secondary" onclick="return confirm('Delete this book?');">
                <i data-lucide="trash-2" class="icon"></i> Delete
            </a>
        </div>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?> Cover" class="book-cover" style="width:100%;height:auto;border-radius:8px;">

        <div class="card-content">
            <h2 class="card-title" style="margin-top:20px;">
                <?= htmlspecialchars($book['title']) ?>
            </h2>
            <p class="card-description">
                <i data-lucide="user" class="icon"></i> <?= htmlspecialchars($book['author']) ?>
            </p>

            <div class="book-stats" style="margin-top:20px;">
                <p><i data-lucide="book-open" class="icon"></i> Pages: <?= htmlspecialchars($book['pages']) ?></p>
                <p><i data-lucide="calendar" class="icon"></i> Started on: <?= htmlspecialchars($book['started_at']) ?></p>
                <div class="progress" style="margin-top:10px;">
                    <div class="progress-bar" style="width: <?= htmlspecialchars($book['progress']) ?>%;"></div>
                </div>
                <p class="progress-text"><?= htmlspecialchars($book['progress']) ?>% completed</p>
            </div>
        </div>
    </div>

