<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'config.php'; 

$user_id = $_SESSION['user_id'] ?? 1;
$status_msg = "";
$status_type = "";

// Handle Preferences Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_global_settings'])) {
    $two_fa = isset($_POST['two_fa']) ? 1 : 0;
    $n_sys = isset($_POST['n_system']) ? 1 : 0;
    $n_sec = isset($_POST['n_security']) ? 1 : 0;
    $n_msg = isset($_POST['n_messaging']) ? 1 : 0;
    $n_act = isset($_POST['n_activity']) ? 1 : 0;
    $weather_city = $conn->real_escape_string($_POST['weather_city'] ?? 'Nairobi');

    $stmt = $conn->prepare("UPDATE users SET two_fa_enabled = ?, notify_system = ?, notify_security = ?, notify_messaging = ?, notify_activity = ?, weather_city = ? WHERE id = ?");
    $stmt->bind_param("iiiiisi", $two_fa, $n_sys, $n_sec, $n_msg, $n_act, $weather_city, $user_id);
    
    if($stmt->execute()) {
        $status_msg = "Settings updated successfully.";
        $status_type = "success";
    }
}

$prefs = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
?>

<div class="glass-panel p-8 md:p-12 shadow-sm animate-in fade-in duration-500">
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-slate-900">System Settings</h2>
        <p class="text-slate-500 font-medium">Configure system behavior, security protocols, and localization.</p>
    </div>

    <?php if ($status_msg): ?>
        <div class="mb-8 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-2xl flex items-center gap-3 font-bold text-sm">
            <i data-lucide="check-circle" class="w-5 h-5"></i> <?= $status_msg ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="grid grid-cols-1 xl:grid-cols-2 gap-12">
        
        <div class="space-y-10">
            <section class="space-y-6">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-5 h-5 text-indigo-500"></i> Security Preferences
                </h3>
                <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[2rem] border border-white">
                    <div>
                        <p class="font-bold text-slate-800 text-sm">Two-Factor Authentication</p>
                        <p class="text-[10px] font-bold uppercase <?= $prefs['two_fa_enabled'] ? 'text-indigo-600' : 'text-slate-400' ?>">
                            <?= $prefs['two_fa_enabled'] ? 'Enabled via Email' : 'Not Enabled' ?>
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="two_fa" class="sr-only peer" <?= $prefs['two_fa_enabled'] ? 'checked' : '' ?>>
                        <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>
            </section>

            <section class="space-y-6">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-5 h-5 text-indigo-500"></i> Local Preferences
                </h3>
                <div class="p-6 bg-slate-50 rounded-[2rem] border border-white">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Weather Display City</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="text" name="weather_city" 
                               value="<?= htmlspecialchars($prefs['weather_city'] ?? 'Nairobi') ?>" 
                               placeholder="Enter city name..."
                               class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-bold focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    <p class="mt-2 text-[10px] text-slate-400 font-medium ml-1 italic">Updates the weather information in the top navigation bar.</p>
                </div>
            </section>
        </div>

        <section class="space-y-6">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="bell-ring" class="w-5 h-5 text-indigo-500"></i> Notification Channels
            </h3>
            <div class="grid gap-3">
                <?php
                $items = [
                    ['n_system', 'System Alerts', 'notify_system'], 
                    ['n_security', 'Security Updates', 'notify_security'], 
                    ['n_messaging', 'Messages', 'notify_messaging'], 
                    ['n_activity', 'Activity Logs', 'notify_activity']
                ];
                foreach ($items as $i): ?>
                <div class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-2xl">
                    <span class="text-sm font-bold text-slate-700"><?= $i[1] ?></span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="<?= $i[0] ?>" class="sr-only peer" <?= $prefs[$i[2]] ? 'checked' : '' ?>>
                        <div class="w-9 h-5 bg-slate-200 rounded-full peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="xl:col-span-2 pt-10 mt-6 border-t border-slate-100/50">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3 text-slate-900"> 
                    <i data-lucide="info" class="w-4 h-4 text-indigo-500"></i>
                    <p class="text-[11px] font-bold uppercase tracking-wider">Changes will take effect immediately upon saving</p>
                </div>
                
                <button type="submit" name="update_global_settings" class="group relative w-full md:w-auto overflow-hidden bg-slate-900 text-white px-12 py-4 rounded-2xl font-bold transition-all duration-300 hover:shadow-[0_20px_40px_-12px_rgba(79,70,229,0.35)] hover:-translate-y-1 active:scale-95">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-violet-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center justify-center gap-3">
                        <span class="tracking-tight">Save All Preferences</span>
                        <i data-lucide="arrow-right" class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1"></i>
                    </div>
                </button>
            </div>
        </div>
    </form>
</div>