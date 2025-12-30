<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php'; 
protect_page(); 
$group_id = intval($_GET['group_id'] ?? 0);
if (!$group_id) { header('Location: groups.php'); exit; }

// Handle Member Removal
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bulk_remove'])) {
    $to_remove = $_POST['selected'] ?? [];
    if (!empty($to_remove)) {
        $ids = implode(',', array_map('intval', $to_remove));
        $conn->query("DELETE FROM group_members WHERE group_id = $group_id AND contact_id IN ($ids)");
        // Optional: Update contact status/meta here if you track "No Group" explicitly in contacts table
    }
    header("Location: view_group_members.php?group_id=$group_id");
    exit;
}

// Fetch Group Info
$group_res = $conn->query("SELECT name FROM groups WHERE id = $group_id");
if ($group_res->num_rows === 0) { header('Location: groups.php'); exit; }
$group = $group_res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | <?= htmlspecialchars($group['name']) ?> Members</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; padding-top: 6rem; }
        .glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .member-row:hover { background: rgba(99, 102, 241, 0.03); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-900">
    <?php include 'navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-6 pb-12">
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-4">
            <a href="groups.php" class="hover:text-indigo-600 transition">Groups</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-slate-900"><?= htmlspecialchars($group['name']) ?></span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1">
                <div class="glass rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <h2 class="text-xl font-bold">Group Members</h2>
                        <span class="text-xs font-bold bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full uppercase tracking-tighter">
                            Active Directory
                        </span>
                    </div>

                    <form method="POST" id="bulkForm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">#</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Contact</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Role</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">Select</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php
                                    $members = $conn->query("SELECT c.*, gm.role FROM contacts c JOIN group_members gm ON c.id = gm.contact_id WHERE gm.group_id = $group_id ORDER BY c.name ASC");
                                    $serial = 1;
                                    if($members->num_rows > 0):
                                        while ($m = $members->fetch_assoc()):
                                    ?>
                                    <tr class="member-row transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-400"><?= $serial++ ?></td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold">
                                                    <?= strtoupper(substr($m['name'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-900"><?= htmlspecialchars($m['name']) ?></p>
                                                    <p class="text-[11px] text-slate-400"><?= htmlspecialchars($m['phone']) ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <select onchange="updateRole(<?= $m['id'] ?>, this.value)" class="bg-transparent text-xs font-semibold text-slate-600 outline-none cursor-pointer hover:text-indigo-600">
                                                <option value="member" <?= $m['role'] == 'member' ? 'selected' : '' ?>>Member</option>
                                                <option value="admin" <?= $m['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <input type="checkbox" name="selected[]" value="<?= $m['id'] ?>" class="select-item rounded border-slate-300 text-red-600 focus:ring-red-500">
                                        </td>
                                    </tr>
                                    <?php endwhile; else: ?>
                                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 text-sm italic">No members in this group yet.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="selectAll" class="rounded border-slate-300">
                                <span class="text-xs font-bold text-slate-500 uppercase">Select All</span>
                            </label>
                            <button type="button" onclick="openDeleteModal()" class="text-xs font-bold text-red-500 hover:text-red-700 transition flex items-center gap-2">
                                <i data-lucide="trash-2" class="w-3 h-3"></i> Remove Selected
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-full lg:w-80 space-y-6">
                <div class="glass rounded-3xl p-6 shadow-lg">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <i data-lucide="user-plus" class="w-5 h-5 text-indigo-600"></i> Add Member
                    </h3>
                    <form method="POST" class="space-y-4">
                        <div>
                            <input type="text" id="contactFilter" placeholder="Search contacts..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 mb-3">
                            <div class="max-h-60 overflow-y-auto custom-scrollbar space-y-1 pr-1" id="availableContacts">
                                <?php
                                $existing = $conn->query("SELECT contact_id FROM group_members WHERE group_id = $group_id");
                                $exclude = [];
                                while($e = $existing->fetch_assoc()) $exclude[] = $e['contact_id'];
                                $exclude_str = !empty($exclude) ? "WHERE id NOT IN (".implode(',', $exclude).")" : "";
                                
                                $contacts = $conn->query("SELECT id, name FROM contacts $exclude_str ORDER BY name ASC");
                                while($c = $contacts->fetch_assoc()):
                                ?>
                                <label class="flex items-center justify-between p-2 hover:bg-indigo-50 rounded-lg cursor-pointer group transition">
                                    <span class="text-sm font-medium text-slate-600 group-hover:text-indigo-700"><?= htmlspecialchars($c['name']) ?></span>
                                    <input type="checkbox" name="contact_ids[]" value="<?= $c['id'] ?>" class="rounded text-indigo-600">
                                </label>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <button type="submit" name="add_members" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            Add Selected
                        </button>
                    </form>
                </div>

                <div class="glass rounded-3xl p-6 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white shadow-xl">
                    <p class="text-indigo-200 text-[10px] font-bold uppercase tracking-widest mb-1">Total Reach</p>
                    <h4 class="text-3xl font-bold"><?= $members->num_rows ?> <span class="text-sm font-normal text-indigo-200">Members</span></h4>
                    <div class="mt-6 pt-6 border-t border-indigo-500/30 flex justify-between">
                        <a href="messages.php?type=group&group_id=<?= $group_id ?>" class="text-xs font-bold hover:underline flex items-center gap-1">
                            <i data-lucide="send" class="w-3 h-3"></i> Broadcast to Group
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="deleteModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl relative z-10 p-8 text-center">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="alert-triangle" class="w-10 h-10"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Remove Members?</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                The selected contacts will be removed from <span class="font-semibold text-slate-800"><?= htmlspecialchars($group['name']) ?></span> and assigned a <span class="font-bold text-red-500 uppercase text-[10px]">No Group Joined</span> designation.
            </p>
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Cancel</button>
                <button type="button" onclick="submitBulkDelete()" class="flex-1 px-6 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 transition shadow-lg shadow-red-200">Confirm Removal</button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
        });

        document.getElementById('contactFilter').addEventListener('input', function(e) {
            const val = e.target.value.toLowerCase();
            document.querySelectorAll('#availableContacts label').forEach(item => {
                item.style.display = item.textContent.toLowerCase().includes(val) ? 'flex' : 'none';
            });
        });

        function openDeleteModal() {
            const checked = document.querySelectorAll('.select-item:checked').length;
            if (checked === 0) return alert('Please select at least one member to remove.');
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function submitBulkDelete() {
            document.getElementById('bulkForm').submit();
        }

        function updateRole(cid, role) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `<input type="hidden" name="update_role" value="${cid}"><input type="hidden" name="roles[${cid}]" value="${role}">`;
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>