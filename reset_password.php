<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Set New Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white p-10 rounded-3xl shadow-2xl border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Set new password</h2>
            <p class="text-slate-500 mt-2">Please enter your new credentials below.</p>
        </div>

        <?php
        $token = $_GET['token'] ?? '';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($token)) {
            $new_pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            
            // In a real app, verify the $token against a password_resets table first
            // For this example, we assume the token is valid for 1 hour
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE reset_token = ?");
            $stmt->bind_param("ss", $new_pass, $token);
            
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                // Clear the token after use
                $conn->query("UPDATE users SET reset_token = NULL WHERE reset_token = '$token'");
                echo "<div class='mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 text-sm flex items-center gap-2'>
                        <i data-lucide='check-circle' class='w-4 h-4'></i> Password updated! <a href='login.php' class='font-bold underline'>Login</a>
                    </div>";
            } else {
                echo "<div class='mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 text-sm'>Invalid or expired link.</div>";
            }
        }
        ?>

        <form method="POST" class="space-y-6">
            <div class="space-y-1">
                <label class="text-sm font-semibold text-slate-700">New Password</label>
                <input type="password" name="password" required minlength="8" placeholder="••••••••" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
                <p class="text-[10px] text-slate-400">Must be at least 8 characters long.</p>
            </div>
            <div class="space-y-1">
                <label class="text-sm font-semibold text-slate-700">Confirm New Password</label>
                <input type="password" name="confirm_password" required placeholder="••••••••" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>
            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-slate-800 transition">
                Reset Password
            </button>
        </form>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>