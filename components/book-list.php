<div class="mb-4 flex flex-col md:flex-row gap-2">
    <form method="GET" action="index.php" class="flex gap-2 w-full">
        <input type="text" name="search" placeholder="Search books..." class="border rounded-lg px-3 py-2 flex-1">
        <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 inline-flex items-center">
            <i data-lucide="search" class="h-4 w-4 mr-2"></i>
            Search
        </button>
        <button type="button" class="border px-4 py-2 rounded-lg bg-white hover:bg-gray-100 inline-flex items-center">
            <i data-lucide="filter" class="h-4 w-4 mr-2"></i>
            Filter
        </button>
    </form>
</div>

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    <?php
    $db = new PDO('sqlite:database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $db->query("SELECT id, title, author, cover_url, progress FROM books ORDER BY created_at DESC");
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($books as $book): ?>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <img src="<?= htmlspecialchars($book['cover_url']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-bold text-lg"><?= htmlspecialchars($book['title']) ?></h3>
                <p class="text-gray-500 text-sm">by <?= htmlspecialchars($book['author']) ?></p>
            </div>
            <div class="px-4 pb-4">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-black h-2.5 rounded-full" style="width: <?= htmlspecialchars($book['progress']) ?>%;"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($book['progress']) ?>% read</p>
            </div>
            <div class="px-4 pb-4 flex justify-between">
                <a href="book-details.php?id=<?= htmlspecialchars($book['id']) ?>" class="text-sm text-blue-500 hover:text-blue-700">View details</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    lucide.createIcons();
</script>