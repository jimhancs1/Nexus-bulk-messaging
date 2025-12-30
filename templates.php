<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php'; 
protect_page(); 
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Templates</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; padding-top: 6rem; }
        .glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .template-preview { background-image: radial-gradient(#e2e8f0 1px, transparent 1px); background-size: 16px 16px; }
    </style>
</head>
<body class="text-slate-900">
    <?php include 'navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-6 pb-12">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Message Templates</h1>
                <p class="text-slate-500 text-sm">Save time with pre-written message snippets.</p>
            </div>
            <button onclick="toggleModal('addTemplateModal')" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 hover:bg-indigo-700 shadow-lg transition-all">
                <i data-lucide="file-plus" class="w-5 h-5"></i> New Template
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $res = $conn->query("SELECT * FROM templates ORDER BY name ASC");
            while($t = $res->fetch_assoc()):
            ?>
            <div class="glass rounded-3xl overflow-hidden border border-slate-100 flex flex-col">
                <div class="p-6 border-b border-slate-50">
                    <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-indigo-500"></i>
                        <?= htmlspecialchars($t['name']) ?>
                    </h3>
                </div>
                <div class="p-6 template-preview flex-1">
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 text-sm text-slate-600 italic leading-relaxed shadow-sm">
                        "<?= nl2br(htmlspecialchars($t['content'])) ?>"
                    </div>
                </div>
                <div class="p-4 bg-slate-50/50 flex justify-end gap-2">
                    <button class="p-2 text-slate-400 hover:text-indigo-600 transition"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                    <a href="delete_template.php?id=<?= $t['id'] ?>" class="p-2 text-slate-400 hover:text-red-500 transition"><i data-lucide="trash-2" class="w-4 h-4"></i></a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </main>

    <div id="addTemplateModal" class="fixed inset-0 z-[150] hidden">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="toggleModal('addTemplateModal')"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg p-4">
            <form action="new_template.php" method="POST" class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-xl font-bold">New Template</h3>
                    <button type="button" onclick="toggleModal('addTemplateModal')"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Template Title</label>
                        <input type="text" name="name" required placeholder="e.g., Welcome Message" class="w-full bg-slate-50 border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Message Content</label>
                        <textarea name="content" rows="6" required placeholder="Use {name} to personalize..." class="w-full bg-slate-50 border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                <div class="p-6 bg-slate-50 flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-indigo-100">Save Template</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
        function toggleModal(id) { document.getElementById(id).classList.toggle('hidden'); }
    </script>
</body>
</html>