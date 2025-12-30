<?php
require_once 'config.php';

// --- DATA AGGREGATION FOR REPORTS ---

// 1. Total Counts
$total_contacts = $conn->query("SELECT COUNT(*) FROM contacts")->fetch_row()[0];
$total_groups = $conn->query("SELECT COUNT(*) FROM groups")->fetch_row()[0];
$total_messages = $conn->query("SELECT COUNT(*) FROM sent_messages")->fetch_row()[0];

// 2. Messaging Volume (Last 7 Days) - For Trend Analysis
$seven_days_ago = date('Y-m-d', strtotime('-7 days'));
$weekly_vol = $conn->query("SELECT COUNT(*) FROM sent_messages WHERE sent_at >= '$seven_days_ago'")->fetch_row()[0];

// 3. Top Groups by Member Count (Decision: Which groups are most engaged?)
$top_groups = $conn->query("
    SELECT g.name, COUNT(gm.contact_id) as member_count 
    FROM groups g 
    LEFT JOIN group_members gm ON g.id = gm.group_id 
    GROUP BY g.id 
    ORDER BY member_count DESC 
    LIMIT 4
");

// 4. Activity Breakdown (Decision: What actions are most frequent?)
$activity_stats = $conn->query("
    SELECT action_type, COUNT(*) as total 
    FROM activity_log 
    GROUP BY action_type 
    ORDER BY total DESC 
    LIMIT 5
");
?>

<div class="space-y-8">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">System Reports</h2>
        <p class="text-slate-500">Analytics and data insights to guide your next communication.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-panel p-6 border-l-4 border-indigo-600 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase">Database Size</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800"><?= number_format($total_contacts) ?></h3>
            <p class="text-xs text-slate-500 mt-1 font-medium text-indigo-600">Total Contacts</p>
        </div>

        <div class="glass-panel p-6 border-l-4 border-emerald-500 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                    <i data-lucide="send" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase">Throughput</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800"><?= number_format($total_messages) ?></h3>
            <p class="text-xs text-slate-500 mt-1 font-medium text-emerald-600">Messages Sent</p>
        </div>

        <div class="glass-panel p-6 border-l-4 border-amber-500 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                    <i data-lucide="layers" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase">Organization</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800"><?= number_format($total_groups) ?></h3>
            <p class="text-xs text-slate-500 mt-1 font-medium text-amber-600">Active Groups</p>
        </div>

        <div class="glass-panel p-6 border-l-4 border-rose-500 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-rose-50 text-rose-600 rounded-lg">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase">7-Day Velocity</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800"><?= number_format($weekly_vol) ?></h3>
            <p class="text-xs text-slate-500 mt-1 font-medium text-rose-600">Recent Messages</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="glass-panel p-8">
            <div class="flex items-center gap-3 mb-6">
                <i data-lucide="pie-chart" class="w-6 h-6 text-indigo-600"></i>
                <h3 class="text-xl font-bold text-slate-800">Group Reach</h3>
            </div>
            <div class="space-y-5">
                <?php while($g = $top_groups->fetch_assoc()): 
                    $percent = ($total_contacts > 0) ? ($g['member_count'] / $total_contacts) * 100 : 0;
                ?>
                <div>
                    <div class="flex justify-between text-sm font-bold mb-2">
                        <span class="text-slate-700"><?= htmlspecialchars($g['name']) ?></span>
                        <span class="text-slate-400"><?= $g['member_count'] ?> Members</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: <?= $percent ?>%"></div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="mt-8 pt-6 border-t border-slate-50">
                <p class="text-xs text-slate-400 italic">Insight: Larger groups may require targeted template messaging.</p>
            </div>
        </div>

        <div class="glass-panel p-8">
            <div class="flex items-center gap-3 mb-6">
                <i data-lucide="bar-chart-3" class="w-6 h-6 text-emerald-600"></i>
                <h3 class="text-xl font-bold text-slate-800">Usage Patterns</h3>
            </div>
            <div class="space-y-4">
                <?php while($act = $activity_stats->fetch_assoc()): ?>
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <span class="text-sm font-bold text-slate-600 capitalize"><?= str_replace('_', ' ', $act['action_type']) ?></span>
                    <span class="bg-white px-3 py-1 rounded-lg border border-slate-200 text-xs font-black text-slate-800">
                        <?= $act['total'] ?>
                    </span>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="mt-8">
                <a href="dashboard.php?page=activity" class="text-indigo-600 text-xs font-bold uppercase tracking-widest hover:underline">Full Activity Audit &rarr;</a>
            </div>
        </div>

    </div>

    <div class="space-y-12 pt-8">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <i data-lucide="clock" class="w-5 h-5 text-slate-400"></i>
            <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Messaging Preview</h3>
        </div>
        <?php include 'outgoing_live.php'; ?>
    </div>
</div>

<script>lucide.createIcons();</script>