<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Welcome Back</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-gradient { background: linear-gradient(135deg, #4F46E5 0%, #06B6D4 100%); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col md:flex-row">

    <!-- Left Side: Branding -->
    <div class="hidden md:flex md:w-5/12 bg-gradient text-white p-12 flex-col justify-between">
        <div>
            <div class="flex items-center gap-2 mb-20">
                <div class="bg-white/20 backdrop-blur-md p-2 rounded-lg border border-white/30"><i data-lucide="layers" class="text-white w-6 h-6"></i></div>
                <span class="text-xl font-bold tracking-tight">NEXUS</span>
            </div>
            <h1 class="text-5xl font-bold mb-8 leading-[1.1]">The complete <br> developer <br> platform.</h1>
            <p class="text-indigo-50 text-xl leading-relaxed max-w-sm opacity-90">Log in to access your dashboard, API keys, and global delivery network.</p>
        </div>
        
        <div class="p-6 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl">
            <p class="text-indigo-100 italic text-sm mb-4">"Nexus has completely transformed how we handle our customer engagement."</p>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-400"></div>
                <span class="text-xs font-bold uppercase tracking-widest">Sarah Jenkins, CEO @ StreamLine</span>
            </div>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="flex-1 flex items-center justify-center p-6 md:p-12 bg-white">
        <div class="w-full max-w-sm">
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Welcome back</h2>
            <p class="text-slate-500 mb-10">Please enter your details to sign in.</p>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $user = mysqli_real_escape_string($conn, $_POST['username']);
                $pass = $_POST['password'];
                $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? OR email = ?");
                $stmt->bind_param("ss", $user, $user);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    if (password_verify($pass, $row['password'])) {
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['username'] = $user;
                        header("Location: dashboard.php");
                        exit;
                    }
                }
                echo "<div class='mb-6 p-4 bg-red-50 text-red-600 rounded-xl border border-red-100 text-sm flex items-center gap-2'><i data-lucide='x-circle' class='w-4 h-4'></i> Invalid credentials.</div>";
            }
            ?>

            <!-- Social Logins -->
            <div class="flex flex-col gap-3 mb-8">
                <button class="flex items-center justify-center gap-3 py-3 border border-slate-200 rounded-xl hover:bg-slate-50 transition font-semibold text-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    Continue with Google
                </button>
                <button class="flex items-center justify-center gap-3 py-3 border border-slate-200 rounded-xl hover:bg-slate-50 transition font-semibold text-sm">
                    <i data-lucide="github" class="w-5 h-5"></i>
                    Continue with GitHub
                </button>
            </div>

            <div class="relative mb-8 text-center">
                <hr class="border-slate-100">
                <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-white px-4 text-xs text-slate-400">OR EMAIL</span>
            </div>

            <form method="POST" class="space-y-5">
                <div class="space-y-1">
                    <label class="text-sm font-semibold text-slate-700">Username or Email</label>
                    <input type="text" name="username" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                </div>
                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-semibold text-slate-700">Password</label>
                        <a href="forgot_password.php" class="text-xs text-indigo-600 font-bold hover:underline">Forgot?</a>
                    </div>
                    <input type="password" name="password" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition">
                </div>
                
                <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-slate-800 transition-all shadow-xl shadow-slate-200">
                    Sign In
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                New to Nexus? <a href="signup.php" class="text-indigo-600 font-bold hover:underline">Create an account</a>
            </p>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>