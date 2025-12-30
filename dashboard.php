<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'config.php';

// Fetch current user details
$user_id = $_SESSION['user_id'] ?? 1;
$page = $_GET['page'] ?? 'welcome';

$u_query = $conn->query("SELECT username, role, profile_pic FROM users WHERE id = $user_id");
$u_data = $u_query->fetch_assoc();

// Profile Picture Logic: Use upload if exists, otherwise a stylized initial avatar
$p_pic = !empty($u_data['profile_pic']) 
    ? 'uploads/' . $u_data['profile_pic'] 
    : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($u_data['username']) . '&backgroundColor=6366f1';

// Sidebar Navigation
$side_nav = [
    ['summary', 'layout-dashboard', 'Summary'],
    ['notifications', 'bell', 'Notifications'],
    ['outgoing_live', 'send', 'Outgoing Live'], 
    ['messaging_history', 'history', 'Messaging History'],
    ['activity', 'database', 'Activity Log'],
    ['settings', 'settings', 'Settings']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nexus | <?= ucfirst(str_replace('_', ' ', $page)) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-panel { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-radius: 1.5rem; border: 1px solid white; }
        
        /* Fixed Sidebar with flex-col to push profile to bottom */
        .sidebar-fixed { 
            position: fixed; top: 0; left: 0; height: 100vh; width: 18rem; 
            z-index: 50; background: white; border-right: 1px solid #f1f5f9; 
            display: flex; flex-direction: column; padding: 1.5rem;
        }

        .main-content { margin-left: 18rem; padding-top: 8rem; min-height: 100vh; }
        @media (max-width: 1024px) { .sidebar-fixed { display: none; } .main-content { margin-left: 0; padding-top: 6rem; } }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="flex">
        <aside class="sidebar-fixed">
            <a href="dashboard.php?page=welcome" class="mt-4 mb-10 px-4 flex items-center gap-3 group">
                <div class="bg-indigo-600 p-2.5 rounded-xl group-hover:rotate-12 transition-transform shadow-lg shadow-indigo-100">
                    <i data-lucide="layout-grid" class="w-5 h-5 text-white"></i>
                </div>
                <span class="font-black text-slate-800 tracking-tighter text-2xl uppercase">Nexus</span>
            </a>

            <nav class="space-y-1.5 flex-1">
                <?php foreach ($side_nav as $item): $active = ($page == $item[0]); ?>
                <a href="dashboard.php?page=<?= $item[0] ?>" 
                   class="flex items-center gap-4 px-5 py-4 rounded-2xl font-bold text-sm transition-all <?= $active ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-100' : 'text-slate-400 hover:bg-indigo-50 hover:text-indigo-600' ?>">
                    <i data-lucide="<?= $item[1] ?>" class="w-5 h-5"></i> <?= $item[2] ?>
                </a>
                <?php endforeach; ?>
            </nav>

            <div class="mt-auto pt-6 border-t border-slate-100">
                <a href="profile.php" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-50 transition-all group">
                    <div class="relative">
                        <img src="<?= $p_pic ?>" alt="Avatar" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-sm group-hover:border-indigo-200 transition-all">
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-bold text-slate-900 truncate">
                            <?= htmlspecialchars($u_data['username']) ?>
                        </p>
                        <p class="text-[10px] font-extrabold text-indigo-500 uppercase tracking-widest">
                            <?= htmlspecialchars($u_data['role']) ?>
                        </p>
                    </div>
                    <div class="text-slate-300 group-hover:text-indigo-500 transition-colors">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </div>
                </a>
            </div>
        </aside>

        <main class="main-content p-6 lg:p-12 w-full">
            <div class="max-w-6xl mx-auto">
                <?php 
                if($page == 'welcome') {
                    ?>
                    <div class="relative overflow-hidden rounded-[2.5rem] bg-[#1e3a5f] p-10 md:p-16 shadow-2xl">
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
                        <div class="relative z-10">
                            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight">
                                Hello, <span class="text-indigo-300"><?= htmlspecialchars($u_data['username']) ?></span>.
                            </h1>
                            <p class="mt-4 text-indigo-100/70 text-xl font-medium max-w-lg">
                                Access your communication reports and messaging history using the sidebar.
                            </p>
                        </div>
                    </div>
                    <?php
                } else {
                    $target = $page . '.php';
                    if(file_exists($target)) {
                        include $target;
                    } else {
                        echo "<div class='glass-panel p-20 text-center text-slate-300 font-bold'>Section Not Found</div>";
                    }
                }
                ?>
            </div>
        </main>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>