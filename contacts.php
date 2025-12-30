<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'config.php'; 
protect_page();

// --- EXPORT FUNCTIONALITY ---
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="contacts_export_' . date('Y-m-d') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Name', 'Phone', 'Email', 'Address', 'Notes']);
    $query = $conn->query("SELECT * FROM contacts ORDER BY name ASC");
    while ($row = $query->fetch_assoc()) {
        fputcsv($output, [$row['id'], $row['name'], $row['phone'], $row['email'], $row['address'], $row['notes']]);
    }
    fclose($output);
    exit;
}

// --- PAGINATION LOGIC ---
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$whereClause = $search ? "WHERE name LIKE '%$search%' OR phone LIKE '%$search%' OR email LIKE '%$search%'" : "";
$total_res = $conn->query("SELECT COUNT(*) FROM contacts $whereClause");
$total_contacts = $total_res->fetch_row()[0];
$total_pages = ceil($total_contacts / $limit);

$result = $conn->query("SELECT * FROM contacts $whereClause ORDER BY name ASC LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nexus | Contacts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
        .selection-mode .contact-number { display: none; }
        .selection-mode .contact-checkbox { display: block !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans p-6">
    <?php include 'navbar.php'; ?>

    <main class="max-w-7xl mx-auto mt-20">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold">Contacts <span class="text-indigo-600"><?= $total_contacts ?></span></h1>
                <p class="text-slate-500">Manage your serialized network.</p>
            </div>
            <div class="flex gap-2">
                <button onclick="toggleModal('importModal')" class="px-4 py-2 bg-white border rounded-xl flex items-center gap-2 hover:bg-slate-50">
                    <i data-lucide="upload-cloud" class="w-4 h-4"></i> Import
                </button>
                <a href="?export=csv" class="px-4 py-2 bg-white border rounded-xl flex items-center gap-2 hover:bg-slate-50">
                    <i data-lucide="download-cloud" class="w-4 h-4 text-indigo-600"></i> Export
                </a>
                <button onclick="enterSelectionMode()" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl flex items-center gap-2 hover:bg-red-100">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                </button>
                <button onclick="toggleModal('addContactModal')" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200">
                    + Add Contact
                </button>
            </div>
        </div>

        <div class="glass p-4 rounded-2xl mb-6 flex flex-wrap items-center justify-between gap-4">
            <form action="" method="GET" class="flex-1 flex gap-2">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-slate-400"></i>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search contacts..." class="w-full pl-10 pr-4 py-2 rounded-xl border-none bg-slate-100 focus:ring-2 focus:ring-indigo-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl">Search</button>
            </form>
            
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500">Show:</span>
                <select onchange="location.href='?limit=' + this.value + '&search=<?= $search ?>'" class="bg-white border rounded-lg px-2 py-1 text-sm">
                    <?php foreach([5,10,20,50,100] as $l): ?>
                        <option value="<?= $l ?>" <?= $limit == $l ? 'selected' : '' ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div id="tableContainer" class="glass rounded-3xl overflow-hidden shadow-xl border border-slate-200">
            <form id="bulkDeleteForm" action="contact_actions.php" method="POST">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">#</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Identity</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Connection</th>
                            <th class="px-6 py-4 text-xs font-bold text-right text-slate-400 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $count = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <span class="contact-number text-slate-400 font-mono"><?= $count++ ?></span>
                                <input type="checkbox" name="ids[]" value="<?= $row['id'] ?>" class="contact-checkbox hidden rounded border-slate-300 text-red-600">
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                                    <?= strtoupper(substr($row['name'], 0, 1)) ?>
                                </div>
                                <span class="font-bold"><?= htmlspecialchars($row['name']) ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <div><?= htmlspecialchars($row['phone']) ?></div>
                                <div class="text-xs text-slate-400"><?= htmlspecialchars($row['email']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="viewContact(<?= $row['id'] ?>)" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-indigo-100 hover:text-indigo-600"><i data-lucide="eye" class="w-4 h-4"></i></button>
                                    <button type="button" onclick="editContact(<?= $row['id'] ?>)" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-amber-100 hover:text-amber-600"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                <div id="deleteBar" class="hidden p-4 bg-red-50 border-t border-red-100 flex justify-between items-center">
                    <span class="text-red-700 font-medium">Select contacts to remove</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="cancelSelection()" class="px-4 py-2 text-slate-600">Cancel</button>
                        <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-xl font-bold">Delete Selected</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6 flex justify-center gap-2">
            <?php for($i=1; $i<=$total_pages; $i++): ?>
                <a href="?page=<?= $i ?>&limit=<?= $limit ?>&search=<?= $search ?>" class="px-4 py-2 rounded-lg <?= $page == $i ? 'bg-indigo-600 text-white' : 'bg-white border' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </main>

    <?php include 'contact_modals.php'; ?>

    <script>
        lucide.createIcons();

        function enterSelectionMode() {
            document.getElementById('tableContainer').classList.add('selection-mode');
            document.getElementById('deleteBar').classList.remove('hidden');
        }

        function cancelSelection() {
            document.getElementById('tableContainer').classList.remove('selection-mode');
            document.getElementById('deleteBar').classList.add('hidden');
            document.querySelectorAll('.contact-checkbox').forEach(c => c.checked = false);
        }

        function confirmDelete() {
            const checked = document.querySelectorAll('.contact-checkbox:checked').length;
            if (checked === 0) return alert('Select at least one contact.');
            toggleModal('confirmDeleteModal');
        }

        // Live Search (Frontend refinement)
        document.querySelector('input[name="search"]').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(tr => {
                tr.style.display = tr.innerText.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    </script>
</body>
</html>