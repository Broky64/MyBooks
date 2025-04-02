<?php
session_start();

// Chemin du fichier de sauvegarde
$settingsFile = 'user_settings.json';

// Sauvegarde si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'yearly_goal' => (int)$_POST['yearly_goal'],
        'weekly_goal' => (int)$_POST['weekly_goal'],
        'daily_goal' => (int)$_POST['daily_goal'],
        'default_view' => $_POST['default_view'],
        'default_sort' => $_POST['default_sort'],
        'show_completed' => isset($_POST['show_completed']),
        'show_dnf' => isset($_POST['show_dnf']),
    ];
    file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT));
}

// Chargement des paramètres
$settings = file_exists($settingsFile) ? json_decode(file_get_contents($settingsFile), true) : [
    'yearly_goal' => 40,
    'weekly_goal' => 0,
    'daily_goal' => 0,
    'default_view' => 'Grid',
    'default_sort' => 'Title',
    'show_completed' => true,
    'show_dnf' => false,
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - My Reading Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="bg-gray-50">
<div class="container mx-auto px-4 py-6">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">Settings</h1>
            <p class="text-gray-500 mt-1">Manage your reading preferences and application settings</p>
        </div>
        <a href="index.php" class="inline-flex items-center border px-3 py-2 rounded-lg bg-white hover:bg-gray-100">
            <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
            Back to Library
        </a>
    </header>

    <form method="POST" class="bg-white rounded-lg shadow p-6 space-y-6">
        <div>
            <h2 class="text-lg font-semibold mb-4">Reading Goals</h2>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Yearly Goal (Books)</label>
                    <input type="number" name="yearly_goal" value="<?= htmlspecialchars($settings['yearly_goal']) ?>" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-black focus:ring-black">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Weekly Goal (Pages)</label>
                    <input type="number" name="weekly_goal" value="<?= htmlspecialchars($settings['weekly_goal']) ?>" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-black focus:ring-black">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Daily Goal (Minutes)</label>
                    <input type="number" name="daily_goal" value="<?= htmlspecialchars($settings['daily_goal']) ?>" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-black focus:ring-black">
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold mb-4">Display Preferences</h2>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Default Library View</label>
                    <select name="default_view" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-black focus:ring-black">
                        <option <?= $settings['default_view'] === 'Grid' ? 'selected' : '' ?>>Grid</option>
                        <option <?= $settings['default_view'] === 'List' ? 'selected' : '' ?>>List</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Default Sort Order</label>
                    <select name="default_sort" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-black focus:ring-black">
                        <option <?= $settings['default_sort'] === 'Title' ? 'selected' : '' ?>>Title</option>
                        <option <?= $settings['default_sort'] === 'Author' ? 'selected' : '' ?>>Author</option>
                        <option <?= $settings['default_sort'] === 'Progress' ? 'selected' : '' ?>>Progress</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="show_completed" <?= $settings['show_completed'] ? 'checked' : '' ?> class="rounded border-gray-300 text-black focus:ring-black">
                    <label class="text-sm font-medium text-gray-700">Show Completed Books</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="show_dnf" <?= $settings['show_dnf'] ? 'checked' : '' ?> class="rounded border-gray-300 text-black focus:ring-black">
                    <label class="text-sm font-medium text-gray-700">Show Did Not Finish Books</label>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold mb-4">Data Management</h2>
            <p class="text-gray-600">Your reading data is stored locally on this server. We recommend regularly exporting your data as a backup.</p>
        </div>

        <div class="flex flex-col md:flex-row gap-4 mt-4">
            <a href="user_settings.json" download class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded text-center">
                Export Settings
            </a>

            <form id="importForm" class="flex items-center gap-2">
                <label for="importFile" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded cursor-pointer">
                    Import Settings
                </label>
                <input type="file" id="importFile" name="importFile" accept=".json" class="hidden">
            </form>
        </div>

        <button type="submit" class="bg-black text-white mt-4 px-4 py-2 rounded hover:bg-gray-800">Save Settings</button>
    </form>
</div>

<script>
    lucide.createIcons();

    const importFile = document.getElementById('importFile');
    importFile.addEventListener('change', async (event) => {
        const file = event.target.files[0];
        if (!file) return;

        const text = await file.text();
        try {
            const data = JSON.parse(text);
            document.querySelector('input[name="yearly_goal"]').value = data.yearly_goal;
            document.querySelector('input[name="weekly_goal"]').value = data.weekly_goal;
            document.querySelector('input[name="daily_goal"]').value = data.daily_goal;
            document.querySelector('select[name="default_view"]').value = data.default_view;
            document.querySelector('select[name="default_sort"]').value = data.default_sort;
            document.querySelector('input[name="show_completed"]').checked = data.show_completed;
            document.querySelector('input[name="show_dnf"]').checked = data.show_dnf;
            alert('Settings imported! Don\'t forget to click "Save Settings" to apply.');
        } catch (e) {
            alert('Invalid settings file.');
        }
    });
</script>
</body>
</html>