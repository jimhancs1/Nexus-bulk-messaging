<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Create Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(90deg, #4F46E5, #06B6D4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col md:flex-row-reverse">

    <!-- Right Side: The Form -->
    <div class="flex-1 flex items-center justify-center p-6 md:p-12 bg-white">
        <div class="w-full max-w-md">
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-bold text-slate-900">Create account</h2>
                <p class="text-slate-500 mt-2">Start building with Nexus today.</p>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $user = mysqli_real_escape_string($conn, $_POST['username']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
                
                $check = $conn->query("SELECT id FROM users WHERE email='$email' OR username='$user'");
                if ($check->num_rows > 0) {
                    echo "<div class='mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 flex items-center gap-3'><i data-lucide='alert-circle' class='w-5 h-5'></i> User already exists.</div>";
                } else {
                    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $user, $email, $pass);
                    if ($stmt->execute()) {
                        echo "<div class='mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 flex items-center gap-3'><i data-lucide='check-circle' class='w-5 h-5'></i> Success! <a href='login.php' class='font-bold underline ml-1'>Login</a></div>";
                    }
                }
            }
            ?>

            <!-- Social Logins -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <a href="google_auth.php" class="flex items-center justify-center gap-2 py-3 border border-slate-200 rounded-xl hover:bg-slate-50 transition font-semibold text-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12.48 10.92v3.28h7.84c-.24 1.84-.9 3.22-1.9 4.28-1.2 1.2-3.06 2.48-6.14 2.48-4.94 0-8.84-4-8.84-8.94s3.9-8.94 8.84-8.94c2.68 0 4.6 1.06 6.06 2.44l2.3-2.3C18.66 1.04 15.9 0 12.48 0 5.86 0 .3 5.38.3 12s5.56 12 12.18 12c3.58 0 6.28-1.18 8.4-3.4 2.16-2.16 2.84-5.22 2.84-7.66 0-.72-.06-1.42-.18-2.02H12.48z"/></svg>
                    Google
                </a>
                <a href="github_auth.php" class="flex items-center justify-center gap-2 py-3 border border-slate-200 rounded-xl hover:bg-slate-50 transition font-semibold text-sm">
                    <i data-lucide="github" class="w-5 h-5"></i>
                    GitHub
                </a>
            </div>

            <div class="relative mb-8 text-center">
                <hr class="border-slate-100">
                <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-white px-4 text-xs text-slate-400 uppercase tracking-widest">or use email</span>
            </div>

            <form method="POST" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-slate-700">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                        <input type="text" name="username" placeholder="Pick a username" required class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-slate-700">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                        <input type="email" name="email" placeholder="name@company.com" required class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-slate-700">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400"></i>
                        <input type="password" name="password" placeholder="Min. 8 characters" required class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 mt-2 flex items-center justify-center gap-2">
                    Create Account <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                Already have an account? <a href="login.php" class="text-indigo-600 font-bold hover:underline">Sign In</a>
            </p>
        </div>
    </div>

    <!-- Left Side: Brand Panel -->
    <div class="hidden md:flex md:w-5/12 bg-slate-900 text-white p-12 flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="z-10">
            <div class="flex items-center gap-2 mb-16">
                <div class="bg-indigo-600 p-2 rounded-lg shadow-lg shadow-indigo-500/20"><i data-lucide="layers" class="w-6 h-6"></i></div>
                <span class="text-xl font-bold tracking-tight">NEXUS</span>
            </div>
            <h1 class="text-5xl font-bold leading-tight mb-6 tracking-tight">Design your <br> <span class="gradient-text">Conversations.</span></h1>
            <p class="text-slate-400 text-lg mb-12 max-w-sm">Join the platform powering the next generation of communication apps.</p>
            
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center"><i data-lucide="shield-check" class="text-emerald-500 w-5 h-5"></i></div>
                    <p class="text-slate-300 font-medium">Enterprise Grade Security</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-cyan-500/10 flex items-center justify-center"><i data-lucide="zap" class="text-cyan-500 w-5 h-5"></i></div>
                    <p class="text-slate-300 font-medium">Ultra Low Latency API</p>
                </div>
            </div>
        </div>
        <div class="z-10 text-slate-500 text-xs flex justify-between">
            <span>© 2025 Nexus Corp</span>
            <div class="flex gap-4">
                <a href="#" class="hover:text-white transition">Privacy</a>
                <a href="#" class="hover:text-white transition">Terms</a>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>