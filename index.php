<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reading Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="bg-gray-50">
<div class="container mx-auto px-4 py-6">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">My Reading Tracker</h1>
            <p class="text-gray-500 mt-1">Track your reading progress and manage your personal library</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="add-book.php" class="inline-flex items-center bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                Add Book
            </a>
            <a href="settings.php" class="inline-flex items-center border px-3 py-2 rounded-lg bg-white hover:bg-gray-100">
                <i data-lucide="settings" class="h-4 w-4"></i>
                <span class="sr-only">Settings</span>
            </a>
        </div>
    </header>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
        <?php
        $db = new PDO('sqlite:database.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Nombre de livres en cours
        $stmt = $db->query("SELECT COUNT(*) FROM books WHERE reading_status = 'reading'");
        $currentlyReading = $stmt->fetchColumn();

        // Nombre de livres lus
        $stmt = $db->query("SELECT COUNT(*) FROM books WHERE reading_status = 'read'");
        $booksRead = $stmt->fetchColumn();

        // Nombre de pages lues cette semaine
        $stmt = $db->query("
            SELECT SUM(pages_read) 
            FROM reading_logs 
            WHERE date >= date('now', '-6 days')
        ");
        $pagesThisWeek = $stmt->fetchColumn() ?: 0;

        // Objectif de lecture (hardcodé ici à 40 livres)
        $stmt = $db->query("SELECT COUNT(*) FROM books WHERE reading_status = 'read'");
        $booksRead = $stmt->fetchColumn();
        $goal = 40;
        $progress = $booksRead > 0 ? round(($booksRead / $goal) * 100, 1) : 0;

        $stats = [
            ['title' => 'Currently Reading', 'value' => $currentlyReading],
            ['title' => 'Books Read', 'value' => $booksRead],
            ['title' => 'Pages This Week', 'value' => $pagesThisWeek],
            ['title' => 'Reading Goal', 'value' => "{$booksRead}/{$goal}", 'progress' => $progress]
        ];

        foreach ($stats as $stat): ?>
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm font-medium text-gray-600 mb-2"><?= htmlspecialchars($stat['title']) ?></h2>
                <div class="text-2xl font-bold"><?= htmlspecialchars($stat['value']) ?></div>
                <?php if(isset($stat['progress'])): ?>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                        <div class="bg-black h-2.5 rounded-full" style="width: <?= htmlspecialchars($stat['progress']) ?>%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($stat['progress']) ?>% complete</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mb-8">
        <div class="flex gap-2 border-b mb-6">
            <button class="inline-flex items-center gap-1 px-4 py-2 border-b-2 border-black font-medium">
                <i data-lucide="book-marked" class="h-4 w-4"></i>
                Library
            </button>
            <button class="inline-flex items-center gap-1 px-4 py-2 text-gray-500 hover:text-black">
                <i data-lucide="bar-chart-2" class="h-4 w-4"></i>
                Statistics
            </button>
        </div>

        <?php include 'components/book-list.php'; ?>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
