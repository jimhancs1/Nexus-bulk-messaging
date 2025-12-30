<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php'; 
protect_page(); 

// Handle Group Deletion
if (isset($_GET['delete_group'])) {
    $group_id = intval($_GET['delete_group']);
    $conn->query("DELETE FROM groups WHERE id = $group_id");
    log_activity('group_delete', "Deleted group ID: $group_id");
    header("Location: groups.php?status=deleted");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Groups</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; padding-top: 6rem; }
        .glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .group-card:hover { transform: translateY(-4px); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="text-slate-900">
    <?php include 'navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-6 pb-12">
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Contact Groups</h1>
                <p class="text-slate-500 mt-1">Organize your broadcasts by departments or categories.</p>
            </div>
            <button onclick="toggleModal('addGroupModal')" class="flex items-center justify-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                <i data-lucide="plus" class="w-5 h-5"></i> Create New Group
            </button>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $groups = $conn->query("SELECT g.*, (SELECT COUNT(*) FROM group_members WHERE group_id = g.id) as member_count FROM groups g ORDER BY g.name ASC");
            while($row = $groups->fetch_assoc()):
            ?>
            <div class="group-card glass rounded-3xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                        <button onclick="confirmDeleteGroup(<?= $row['id'] ?>, '<?= addslashes($row['name']) ?>')" class="p-2 text-slate-300 hover:text-red-500 transition">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900"><?= htmlspecialchars($row['name']) ?></h3>
                    <p class="text-sm text-slate-500 mt-1 line-clamp-2"><?= htmlspecialchars($row['description'] ?: 'No description provided.') ?></p>
                </div>
                
                <div class="mt-6">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl font-bold text-slate-900"><?= $row['member_count'] ?></span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Members</span>
                    </div>
                    
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <a href="view_group_members.php?group_id=<?= $row['id'] ?>" class="flex-1 text-center py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition">
                            Manage
                        </a>
                        <a href="messages.php?type=group&group_id=<?= $row['id'] ?>" class="flex-1 text-center py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold hover:bg-indigo-100 transition flex items-center justify-center gap-1">
                            <i data-lucide="send" class="w-3 h-3"></i> Broadcast
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </main>

    <div id="deleteConfirmModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative z-10 p-8 text-center animate-in fade-in zoom-in duration-200">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="alert-circle" class="w-10 h-10"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Delete Group?</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                You are about to delete <span id="deleteGroupName" class="font-bold text-slate-800"></span>. This action cannot be undone and all member associations will be removed.
            </p>
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Cancel</button>
                <a id="confirmDeleteBtn" href="#" class="flex-1 px-6 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 transition shadow-lg shadow-red-200">Yes, Delete</a>
            </div>
        </div>
    </div>

    <div id="addGroupModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="toggleModal('addGroupModal')"></div>
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl relative z-10 overflow-hidden">
            <form action="new_group.php" method="POST">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-xl font-bold">Create New Group</h3>
                    <button type="button" onclick="toggleModal('addGroupModal')" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>
                <div class="p-8 space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Group Name</label>
                        <input type="text" name="name" required class="w-full bg-slate-50 border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-50 border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                <div class="p-6 bg-slate-50 flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition">Save Group</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function toggleModal(id) {
            document.getElementById(id).classList.toggle('hidden');
        }

        function confirmDeleteGroup(id, name) {
            document.getElementById('deleteGroupName').textContent = name;
            document.getElementById('confirmDeleteBtn').href = 'groups.php?delete_group=' + id;
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        }
    </script>
</body>
</html>