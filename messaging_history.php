<?php
require_once 'config.php';

// Logic for search, pagination, and limits (5, 10, 20, etc.)
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$p_num = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($p_num - 1) * $limit;
$search = $_GET['search'] ?? '';
$error = (empty($search) || strlen($search) >= 2) ? "" : "Invalid Search: Please check your query.";

$where = "WHERE 1=1";
if (!empty($search) && empty($error)) {
    $s = $conn->real_escape_string($search);
    $where .= " AND (message_content LIKE '%$s%' OR recipients LIKE '%$s%')";
}

$res = $conn->query("SELECT * FROM sent_messages $where ORDER BY sent_at DESC LIMIT $offset, $limit");
?>
<div class="space-y-6">
    <div class="text-center md:text-left">
        <h2 class="text-4xl font-extrabold text-slate-800">Messaging History</h2>
        <p class="text-slate-500 mt-2">Monitor and track sent communications</p>
    </div>

    <form method="GET" action="dashboard.php" class="space-y-4">
        <input type="hidden" name="page" value="<?= $page ?>">
        <div class="flex shadow-sm rounded-2xl overflow-hidden border border-slate-200 bg-white">
            <div class="flex items-center px-4 text-slate-400"><i data-lucide="search" class="w-5 h-5"></i></div>
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search recipients or messages..." class="flex-1 py-4 px-2 outline-none">
            <button type="submit" class="bg-[#1e3a5f] text-white px-8 font-bold">Search</button>
        </div>
        
        <div class="flex gap-4 text-xs font-bold text-slate-400 uppercase tracking-widest">
            <span>Show:</span>
            <?php foreach([5, 10, 20, 50, 100] as $v): ?>
                <a href="dashboard.php?page=<?= $page ?>&limit=<?= $v ?>" class="<?= $limit == $v ? 'text-indigo-600' : '' ?>"><?= $v ?></a>
            <?php endforeach; ?>
        </div>
    </form>

    <?php if($error): ?>
        <div class="border-2 border-red-500 bg-white p-4 text-center rounded-xl text-red-600 font-bold"><?= $error ?></div>
    <?php endif; ?>

    <div class="glass-panel overflow-hidden border border-slate-100">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-900 font-bold text-sm">
                <tr>
                    <th class="px-6 py-5">Recipient</th>
                    <th class="px-6 py-5">Content</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-600 text-sm">
                <?php while($m = $res->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-4 font-bold text-indigo-600">User #<?= $m['recipients'] ?></td>
                    <td class="px-6 py-4 truncate max-w-xs"><?= htmlspecialchars($m['message_content']) ?></td>
                    <td class="px-6 py-4"><span class="bg-emerald-500 text-white px-2 py-0.5 rounded text-[10px] font-bold">SENT</span></td>
                    <td class="px-6 py-4 text-slate-400"><?= date('H:i A', strtotime($m['sent_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>