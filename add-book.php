<?php
$db = new PDO('sqlite:database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'] ?? null;
    $pages = (int) $_POST['pages'];
    $publication_year = $_POST['publication_year'] ?? null;
    $genre = $_POST['genre'] ?? null;
    $reading_status = $_POST['reading_status'] ?? null;
    $cover_url = $_POST['cover_url'] ?? null;
    $description = $_POST['description'] ?? null;
    $personal_notes = $_POST['personal_notes'] ?? null;
    $progress = (int) ($_POST['progress'] ?? 0);
    $started_at = $_POST['start_date'] ?? null;

    $stmt = $db->prepare("
        INSERT INTO books 
        (title, author, isbn, pages, publication_year, genre, reading_status, cover_url, description, personal_notes, progress, started_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $title, $author, $isbn, $pages, $publication_year, $genre, $reading_status, $cover_url, $description, $personal_notes, $progress, $started_at
    ]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book - My Reading Tracker</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="index.php" class="btn secondary">
            <i data-lucide="arrow-left" class="icon"></i>
            Back
        </a>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="card-title" style="margin-bottom:15px;">Add a New Book</h2>
        <form method="POST">
            <div class="form-group">
                <label for="title">Book Title</label>
                <input type="text" id="title" name="title" class="input" required>
            </div>

            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" id="author" name="author" class="input" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" class="input">
            </div>

            <div class="form-group">
                <label for="pages">Number of Pages</label>
                <input type="number" id="pages" name="pages" class="input" required>
            </div>

            <div class="form-group">
                <label for="publication_year">Publication Year</label>
                <input type="number" id="publication_year" name="publication_year" class="input">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" class="input">
            </div>

            <div class="form-group">
                <label for="reading_status">Reading Status</label>
                <select id="reading_status" name="reading_status" class="input">
                    <option value="">Select status</option>
                    <option value="reading">Reading</option>
                    <option value="read">Read</option>
                    <option value="want_to_read">Want to Read</option>
                </select>
            </div>

            <div class="form-group">
                <label for="cover_url">Cover URL</label>
                <input type="url" id="cover_url" name="cover_url" class="input">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="input"></textarea>
            </div>

            <div class="form-group">
                <label for="personal_notes">Personal Notes</label>
                <textarea id="personal_notes" name="personal_notes" class="input"></textarea>
            </div>

            <div class="form-group">
                <label for="progress">Progress (%)</label>
                <input type="number" id="progress" name="progress" class="input" min="0" max="100">
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="input">
            </div>

            <button type="submit" class="btn primary" style="width:100%; margin-top:20px;">
                <i data-lucide="book-plus" class="icon"></i>
                Add Book
            </button>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
