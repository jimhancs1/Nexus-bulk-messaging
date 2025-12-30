<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php'; 
protect_page(); // Redirects to login.php if not logged in
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nexus | Global Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style> 
        body { background-color: #f8fafc; padding-top: 6rem; } 
        .highlight { background: #fef08a; padding: 0 2px; border-radius: 2px; font-weight: 600; }
    </style>
</head>
<body class="text-slate-900">
    <?php include 'navbar.php'; ?>

    <main class="max-w-4xl mx-auto px-6">
        <?php
        $query = trim($_GET['q'] ?? '');
        if (empty($query)):
        ?>
            <div class="text-center py-20">
                <i data-lucide="search-x" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                <h2 class="text-2xl font-bold text-slate-400">No search term entered</h2>
            </div>
        <?php else: 
            $term = "%$query%";
            echo "<h2 class='text-2xl font-bold mb-8'>Results for <span class='text-indigo-600'>\"".htmlspecialchars($query)."\"</span></h2>";
        ?>

        <section class="mb-10">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                <i data-lucide="users" class="w-4 h-4"></i> Contacts
            </h3>
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 divide-y divide-slate-100">
                <?php
                $stmt = $conn->prepare("SELECT id, name, phone FROM contacts WHERE name LIKE ? OR phone LIKE ? LIMIT 5");
                $stmt->bind_param("ss", $term, $term);
                $stmt->execute();
                $res = $stmt->get_result();
                if($res->num_rows > 0):
                    while($c = $res->fetch_assoc()):
                ?>
                    <a href="contacts.php#contact-<?= $c['id'] ?>" class="flex items-center justify-between p-4 hover:bg-slate-50 transition">
                        <span class="font-semibold"><?= str_ireplace($query, "<span class='highlight'>$query</span>", htmlspecialchars($c['name'])) ?></span>
                        <span class="text-sm text-slate-400"><?= htmlspecialchars($c['phone']) ?></span>
                    </a>
                <?php endwhile; else: echo "<p class='p-4 text-sm text-slate-400'>No matches found.</p>"; endif; ?>
            </div>
        </section>

        <?php endif; ?>
    </main>
    <script>lucide.createIcons();</script>
</body>
</html>