<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application React avec Tailwind CDN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="bg-gray-100">
<div id="root" class="p-6"></div>

<script type="text/javascript">
    const { useState } = React;

    function App() {
        const [activeTab, setActiveTab] = useState("dashboard");

        return React.createElement("div", { className: "max-w-5xl mx-auto" },
            React.createElement("div", { className: "flex justify-between items-center mb-4" },
                React.createElement("h1", { className: "text-2xl font-bold" }, "Mon Application"),
                React.createElement("button", {
                    className: "bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded inline-flex items-center"
                },
                    React.createElement(lucide.Plus, { class: "w-4 h-4 mr-2" }), "Ajouter"
                )
            ),
            React.createElement("div", { className: "mb-4 flex gap-2" },
                ["dashboard", "library", "settings"].map(tab =>
                    React.createElement("button", {
                        key: tab,
                        className: `px-4 py-2 rounded ${activeTab === tab ? 'bg-blue-500 text-white' : 'bg-gray-200'}`,
                        onClick: () => setActiveTab(tab)
                    }, tab === "dashboard" ? "Tableau de bord" : tab === "library" ? "Bibliothèque" : "Paramètres")
                )
            ),
            activeTab === "dashboard" && React.createElement("div", { className: "bg-white shadow rounded-lg p-6" },
                React.createElement("h2", { className: "text-xl font-semibold mb-2 flex items-center" },
                    React.createElement(lucide.BarChart2, { class: "w-5 h-5 mr-2" }), "Statistiques"
                ),
                React.createElement("div", { className: "w-full bg-gray-200 rounded-full h-2.5" },
                    React.createElement("div", {
                        className: "bg-blue-500 h-2.5 rounded-full",
                        style: { width: "60%" }
                    })
                )
            ),
            activeTab === "library" && React.createElement("div", { className: "bg-white shadow rounded-lg p-6" },
                React.createElement("h2", { className: "text-xl font-semibold mb-2 flex items-center" },
                    React.createElement(lucide.BookMarked, { class: "w-5 h-5 mr-2" }), "Bibliothèque"
                ),
                React.createElement("p", null, "Liste des livres chargée depuis le backend PHP ici.")
            ),
            activeTab === "settings" && React.createElement("div", { className: "bg-white shadow rounded-lg p-6" },
                React.createElement("h2", { className: "text-xl font-semibold mb-2 flex items-center" },
                    React.createElement(lucide.Settings, { class: "w-5 h-5 mr-2" }), "Paramètres"
                ),
                React.createElement("p", null, "Paramètres utilisateurs à gérer avec PHP.")
            )
        );
    }

    const root = ReactDOM.createRoot(document.getElementById('root'));
    root.render(React.createElement(App));
</script>

</body>
</html>
