<?php
require_once 'config.php';

if (!function_exists('getLogStyle')) {
    function getLogStyle($type) {
        if (strpos($type, 'delete') !== false) return ['color' => 'text-rose-600', 'bg' => 'bg-rose-50', 'icon' => 'trash-2'];
        if (strpos($type, 'add') !== false) return ['color' => 'text-emerald-600', 'bg' => 'bg-emerald-50', 'icon' => 'plus-circle'];
        return ['color' => 'text-indigo-600', 'bg' => 'bg-indigo-50', 'icon' => 'bell'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['notif_action'])) {
    if ($_POST['notif_action'] == 'mark_read') $conn->query("UPDATE activity_log SET is_read = 1");
    if ($_POST['notif_action'] == 'clear') $conn->query("DELETE FROM activity_log WHERE is_read = 1");
    header("Location: dashboard.php?page=notifications"); exit;
}

$limit = 10;
$page_num = isset($_GET['p']) ? (int)$GET['p'] : 1;
$offset = ($page_num - 1) * $limit;

$total_rows = $conn->query("SELECT COUNT(*) FROM activity_log WHERE is_read = 0")->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);
$notifs = $conn->query("SELECT * FROM activity_log ORDER BY is_read ASC, timestamp DESC LIMIT $offset, $limit");
?>

<div class="glass-panel p-8 shadow-sm border border-white max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-bold text-slate-900">System Notifications</h2>
        <form method="POST" class="flex gap-2">
            <button name="notif_action" value="mark_read" class="text-[10px] font-bold uppercase px-4 py-2 bg-slate-100 rounded-lg">Mark All Read</button>
            <button name="notif_action" value="clear" class="text-[10px] font-bold uppercase px-4 py-2 bg-rose-50 text-rose-600 rounded-lg">Clear History</button>
        </form>
    </div>

    <div class="space-y-3">
        <?php while($n = $notifs->fetch_assoc()): 
            $style = getLogStyle($n['action_type']);
        ?>
        <div class="flex items-center gap-4 p-5 rounded-3xl border <?= $n['is_read'] ? 'bg-white border-slate-50' : 'bg-indigo-50/40 border-indigo-100 shadow-sm' ?>">
            <div class="<?= $style['bg'] ?> <?= $style['color'] ?> p-3 rounded-2xl">
                <i data-lucide="<?= $style['icon'] ?>" class="w-5 h-5"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($n['details']) ?></p>
                <p class="text-[10px] font-bold text-slate-400 uppercase mt-1"><?= date('M d, H:i', strtotime($n['timestamp'])) ?></p>
            </div>
            <?php if(!$n['is_read']): ?>
                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
</div>