<?php
require_once 'config.php';
$live_res = $conn->query("SELECT * FROM sent_messages ORDER BY sent_at DESC LIMIT 5");
?>
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-bold text-slate-800">Outgoing (Recent)</h3>
        <a href="dashboard.php?page=outgoing_live" class="text-xs font-bold text-indigo-600 hover:underline">View All Queue</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php while($row = $live_res->fetch_assoc()): ?>
            <div class="glass-panel p-5 border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status: Sent</p>
                    <p class="text-sm font-bold text-slate-700">Ref: SMS-<?= $row['id'] ?></p>
                </div>
                <div class="bg-emerald-100 text-emerald-600 p-2 rounded-lg">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>