<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white p-10 rounded-3xl shadow-2xl border border-slate-100">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i data-lucide="key-round" class="w-8 h-8"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Forgot password?</h2>
            <p class="text-slate-500 mt-2">No worries, we'll send you reset instructions.</p>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            // Logic: Here you would normally generate a token, save to DB, and send email.
            // For now, we simulate a success message.
            echo "<div class='mb-6 p-4 bg-indigo-50 text-indigo-700 rounded-xl border border-indigo-100 text-sm flex flex-col gap-2'>
                    <span class='font-bold'>Check your email</span>
                    <span>We've sent a recovery link to $email</span>
                </div>";
        }
        ?>

        <form method="POST" class="space-y-6">
            <div class="space-y-1">
                <label class="text-sm font-semibold text-slate-700">Email Address</label>
                <input type="email" name="email" required placeholder="Enter your email" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                Send Reset Link
            </button>
            <a href="login.php" class="flex items-center justify-center gap-2 text-sm text-slate-500 font-medium hover:text-indigo-600 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to login
            </a>
        </form>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>