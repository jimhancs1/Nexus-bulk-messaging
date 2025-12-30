<?php
require_once 'config.php';
$u_id = $_SESSION['user_id'] ?? 1;

// Handle Plan Selection (Upgrade Logic)
if (isset($_POST['upgrade_plan'])) {
    $plan = $_POST['plan_name'];
    $duration = ($plan == 'Enterprise') ? '+1 year' : '+1 month';
    $new_renewal = date('Y-m-d', strtotime($duration));
    
    $conn->query("UPDATE users SET subscription_plan = '$plan', renewal_date = '$new_renewal', subscription_status = 'Active' WHERE id = $u_id");
    echo "<script>window.location.href='dashboard.php?page=subscriptions&success=1';</script>";
}

// Fetch Subscription Data
$user = $conn->query("SELECT subscription_plan, renewal_date, subscription_status FROM users WHERE id = $u_id")->fetch_assoc();

// Calculate Time Left
$days_left = 0;
if ($user['renewal_date']) {
    $today = new DateTime();
    $renewal = new DateTime($user['renewal_date']);
    $interval = $today->diff($renewal);
    $days_left = $renewal > $today ? $interval->format('%a') : 0;
}
?>

<div class="space-y-8">
    <div class="glass-panel p-8 flex flex-col md:flex-row justify-between items-center gap-6 border-slate-100 shadow-sm">
        <div>
            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">Current Status</p>
            <h2 class="text-3xl font-black text-slate-800">
                <?= $user['subscription_plan'] ?> <span class="text-slate-300 font-light">Plan</span>
            </h2>
        </div>
        
        <div class="flex gap-4">
            <div class="text-center px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase">Days Remaining</p>
                <p class="text-xl font-black text-indigo-600"><?= $days_left ?> Days</p>
            </div>
            <div class="text-center px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase">Renewal Date</p>
                <p class="text-sm font-black text-slate-700"><?= $user['renewal_date'] ?? 'N/A' ?></p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <form method="POST" class="glass-panel p-8 border-2 <?= $user['subscription_plan'] == 'Pro' ? 'border-indigo-500 shadow-indigo-100' : 'border-transparent hover:border-slate-200' ?> transition-all">
            <input type="hidden" name="plan_name" value="Pro">
            <h3 class="text-xl font-bold text-slate-800">Pro</h3>
            <p class="text-slate-400 text-sm mt-2 mb-6">Perfect for growing teams.</p>
            <div class="text-3xl font-black text-slate-800 mb-6">$29<span class="text-sm font-medium text-slate-400">/mo</span></div>
            
            <ul class="space-y-3 mb-8 text-sm text-slate-600 font-medium">
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Unlimited Contacts</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Analytics Reports</li>
            </ul>

            <button type="submit" name="upgrade_plan" class="w-full py-4 rounded-xl font-bold transition-all <?= $user['subscription_plan'] == 'Pro' ? 'bg-slate-100 text-slate-400 cursor-default' : 'bg-[#1e3a5f] text-white hover:bg-slate-800 shadow-lg shadow-indigo-100' ?>">
                <?= $user['subscription_plan'] == 'Pro' ? 'Current Plan' : 'Select Pro' ?>
            </button>
        </form>

        <form method="POST" class="glass-panel p-8 border-2 <?= $user['subscription_plan'] == 'Enterprise' ? 'border-indigo-500 shadow-indigo-100' : 'border-transparent hover:border-slate-200' ?> relative overflow-hidden">
            <div class="absolute top-4 right-[-35px] rotate-45 bg-indigo-600 text-white text-[10px] font-black px-10 py-1">BEST VALUE</div>
            <input type="hidden" name="plan_name" value="Enterprise">
            <h3 class="text-xl font-bold text-slate-800">Enterprise</h3>
            <p class="text-slate-400 text-sm mt-2 mb-6">Advanced power features.</p>
            <div class="text-3xl font-black text-slate-800 mb-6">$299<span class="text-sm font-medium text-slate-400">/yr</span></div>
            
            <ul class="space-y-3 mb-8 text-sm text-slate-600 font-medium">
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Priority API Access</li>
                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> Dedicated Support</li>
            </ul>

            <button type="submit" name="upgrade_plan" class="w-full py-4 rounded-xl font-bold transition-all <?= $user['subscription_plan'] == 'Enterprise' ? 'bg-slate-100 text-slate-400 cursor-default' : 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200' ?>">
                <?= $user['subscription_plan'] == 'Enterprise' ? 'Current Plan' : 'Select Enterprise' ?>
            </button>
        </form>
    </div>
</div>
<script>lucide.createIcons();</script>