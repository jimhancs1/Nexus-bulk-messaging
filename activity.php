<?php
require_once 'config.php';

// Helper for dynamic styling
if (!function_exists('getLogStyle')) {
    function getLogStyle($type) {
        $type = strtolower($type);
        if (strpos($type, 'delete') !== false) return ['color' => 'text-rose-600', 'bg' => 'bg-rose-50', 'icon' => 'trash-2'];
        if (strpos($type, 'add') !== false) return ['color' => 'text-emerald-600', 'bg' => 'bg-emerald-50', 'icon' => 'plus-circle'];
        if (strpos($type, 'message') !== false) return ['color' => 'text-blue-600', 'bg' => 'bg-blue-50', 'icon' => 'send'];
        return ['color' => 'text-slate-600', 'bg' => 'bg-slate-100', 'icon' => 'database'];
    }
}

// Filter Inputs
$search = $_GET['search'] ?? '';
$type_filter = $_GET['type'] ?? '';

// Build Query
$where = "WHERE 1=1";
if (!empty($search)) $where .= " AND details LIKE '%" . $conn->real_escape_string($search) . "%'";
if (!empty($type_filter)) $where .= " AND action_type = '" . $conn->real_escape_string($type_filter) . "'";

$logs = $conn->query("SELECT * FROM activity_log $where ORDER BY timestamp DESC LIMIT 100");
?>

<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-900">Activity History</h2>
            <p class="text-slate-500 text-sm">Filter and browse past system actions</p>
        </div>
        
        <form method="GET" action="dashboard.php" class="flex flex-wrap gap-2 w-full md:w-auto">
            <input type="hidden" name="page" value="activity">
            <div class="relative flex-1 md:w-64">
                <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-slate-400"></i>
                <input type="text" name="search" placeholder="Search logs..." value="<?= htmlspecialchars($search) ?>"
                       class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <select name="type" class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none">
                <option value="">All Actions</option>
                <option value="contact_add" <?= $type_filter=='contact_add'?'selected':'' ?>>Contact Added</option>
                <option value="message_sent" <?= $type_filter=='message_sent'?'selected':'' ?>>Messages</option>
                <option value="template_delete" <?= $type_filter=='template_delete'?'selected':'' ?>>Deletions</option>
            </select>
            <button type="submit" class="bg-indigo-600 text-white p-2 rounded-xl hover:bg-indigo-700">
                <i data-lucide="filter" class="w-5 h-5"></i>
            </button>
        </form>
    </div>

    <div class="glass-panel overflow-hidden">
        <div class="p-2">
            <?php if($logs->num_rows > 0): ?>
                <?php while($l = $logs->fetch_assoc()): $style = getLogStyle($l['action_type']); ?>
                    <div class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-2xl transition-all">
                        <div class="<?= $style['bg'] ?> <?= $style['color'] ?> p-3 rounded-xl">
                            <i data-lucide="<?= $style['icon'] ?>" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($l['details']) ?></p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">
                                <?= date('d M Y, H:i', strtotime($l['timestamp'])) ?> • <?= str_replace('_', ' ', $l['action_type']) ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="py-20 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="database-zap" class="w-8 h-8 text-slate-200"></i>
                    </div>
                    <p class="text-slate-400 font-bold">No logs found matching your criteria</p>
                    <a href="dashboard.php?page=activity" class="text-indigo-600 text-xs font-bold mt-2 inline-block">Reset Filters</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>lucide.createIcons();</script>