<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

/**
 * --- WEATHER FETCHING LOGIC ---
 */
function get_weather_data($city, $apiKey) {
    if (!isset($_SESSION['weather_cache']) || (time() - $_SESSION['weather_last_fetch'] > 1800)) {
        $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid={$apiKey}&units=metric";
        $response = @file_get_contents($url);
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['cod']) && $data['cod'] == 200) {
                $_SESSION['weather_cache'] = $data;
                $_SESSION['weather_last_fetch'] = time();
            }
        }
    }
    return $_SESSION['weather_cache'] ?? null;
}

// Configuration
$apiKey = "6c87d3b90f47ade9246e727dfd0e9fc6"; 
$city = "Nairobi"; 
$weatherData = get_weather_data($city, $apiKey);

// User Data for conditional display (Role/Name/Pic)
$u_id = $_SESSION['user_id'] ?? 1;
$u_query = $conn->query("SELECT role, username, profile_pic FROM users WHERE id = $u_id");
$u_navbar = $u_query->fetch_assoc();
$p_pic_nav = !empty($u_navbar['profile_pic']) ? 'uploads/'.$u_navbar['profile_pic'] : 'https://api.dicebear.com/7.x/initials/svg?seed='.$u_navbar['username'];

// Navigation Items
$nav_items = [
    ['dashboard.php', 'layout-dashboard', 'Dashboard', 'View your analytics overview'],
    ['contacts.php', 'users', 'Contacts', 'Manage your saved contacts'],
    ['groups.php', 'folder-kanban', 'Groups', 'Organize contacts into groups'],
    ['messages.php', 'send', 'Messages', 'Send and manage SMS/Messages'],
    ['templates.php', 'file-text', 'Templates', 'Manage reusable message templates']
];

// Check if we are on dashboard to hide redundant account info
$is_dashboard = (basename($_SERVER['PHP_SELF']) == 'dashboard.php');
?>

<nav class="fixed top-0 w-full z-[100] bg-white/90 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            
            <div class="flex items-center gap-8">
                <button id="mobile-menu-button" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                
                <a href="dashboard.php" class="flex items-center gap-2 group">
                    <div class="bg-indigo-600 p-2 rounded-lg shadow-lg shadow-indigo-200 group-hover:rotate-12 transition-transform">
                        <i data-lucide="layers" class="text-white w-5 h-5"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 uppercase">NEXUS</span>
                </a>

                <div class="hidden xl:flex items-center gap-1">
                    <?php foreach ($nav_items as $item): ?>
                        <a href="<?= $item[0] ?>" class="px-4 py-2 rounded-xl text-sm font-bold text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/50 transition-all" title="<?= $item[3] ?>">
                            <?= $item[2] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex items-center gap-4 md:gap-6">
                
                <div class="hidden md:flex flex-col text-right">
                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider"><?= htmlspecialchars($city) ?></span>
                    <span class="text-xs font-semibold text-slate-700">
                        <?= $weatherData ? round($weatherData['main']['temp']) . '°C' : 'N/A' ?> 
                        <span class="text-slate-300 mx-1">•</span> 
                        <?= date('l, d M'); ?>
                    </span>
                </div>

                <?php if (!$is_dashboard): ?>
                <div class="flex items-center gap-3 border-l border-slate-200 pl-4">
                    <div class="hidden lg:flex flex-col text-right">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider"><?= htmlspecialchars($u_navbar['role'] ?? 'User') ?></span>
                        <span class="text-xs font-semibold text-slate-700"><?= htmlspecialchars($u_navbar['username'] ?? 'Guest') ?></span>
                    </div>
                    <a href="dashboard.php?page=profile" class="relative group">
                        <img src="<?= $p_pic_nav ?>" class="w-9 h-9 rounded-xl object-cover border border-slate-200 group-hover:border-indigo-500 transition-all shadow-sm">
                    </a>
                </div>
                <?php endif; ?>

                <a href="logout.php" class="p-2.5 bg-rose-50 text-rose-500 hover:bg-rose-100 rounded-xl transition-all" title="Logout">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-slate-200 px-4 py-6 space-y-2">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4 mb-4">Navigation</p>
        <?php foreach ($nav_items as $item): ?>
            <a href="<?= $item[0]; ?>" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all group">
                <div class="p-2 bg-slate-50 rounded-lg group-hover:bg-white group-hover:shadow-sm">
                    <i data-lucide="<?= $item[1]; ?>" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="block font-bold text-sm"><?= $item[2]; ?></span>
                    <span class="block text-[10px] text-slate-400"><?= $item[3]; ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</nav>

<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Mobile Menu Toggle
    const menuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>