<?php
require_once 'config.php';
$user_id = $_SESSION['user_id'] ?? 1;

// 1. AJAX Image Upload Logic
if (isset($_POST['image_base64'])) {
    $data = $_POST['image_base64'];
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);
    if (!file_exists('uploads')) mkdir('uploads', 0777, true);
    $file_name = 'profile_' . $user_id . '_' . time() . '.png';
    file_put_contents('uploads/' . $file_name, $data);
    $conn->query("UPDATE users SET profile_pic = '$file_name' WHERE id = $user_id");
    echo json_encode(['status' => 'success', 'url' => 'uploads/' . $file_name]);
    exit;
}

// 2. Profile Details Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $role = $conn->real_escape_string($_POST['role']);
    $bio = $conn->real_escape_string($_POST['bio']);
    
    // Update DB
    $conn->query("UPDATE users SET username = '$username', role = '$role', bio = '$bio' WHERE id = $user_id");
    
    // Sync session so Navbar changes immediately
    $_SESSION['username'] = $username;
    header("Location: dashboard.php?page=profile&success=1");
    exit;
}

$u = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<div class="max-w-5xl mx-auto space-y-8 animate-in slide-in-from-bottom-4 duration-700">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="glass-panel p-8 text-center border border-white shadow-sm">
            <div class="relative inline-block group">
                <img id="profile-preview" src="<?= $u['profile_pic'] ? 'uploads/'.$u['profile_pic'] : 'https://api.dicebear.com/7.x/initials/svg?seed='.$u['username'] ?>" 
                     class="w-40 h-40 rounded-[3rem] object-cover border-4 border-white shadow-2xl transition-all group-hover:brightness-90">
                <label class="absolute bottom-2 right-2 bg-indigo-600 text-white p-3 rounded-2xl cursor-pointer shadow-xl hover:scale-110 transition-transform">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                    <input type="file" id="img_input" class="hidden" accept="image/*">
                </label>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mt-6"><?= $u['username'] ?></h2>
            <span class="inline-block px-4 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest mt-2"><?= $u['role'] ?></span>
        </div>

        <div class="lg:col-span-2 glass-panel p-10 border border-white shadow-sm">
            <form method="POST" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Username</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($u['username']) ?>" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Account Role</label>
                        <input type="text" name="role" value="<?= htmlspecialchars($u['role']) ?>" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Profile Bio</label>
                    <textarea name="bio" rows="4" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-medium text-slate-600 focus:ring-2 focus:ring-indigo-500 outline-none resize-none"><?= htmlspecialchars($u['bio']) ?></textarea>
                </div>
                <button type="submit" name="update_profile" class="w-full bg-slate-900 text-white font-bold py-5 rounded-2xl hover:shadow-2xl hover:shadow-indigo-200 transition-all">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<div id="cropModal" class="fixed inset-0 z-[200] bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[3rem] p-8 max-w-sm w-full shadow-2xl">
        <h3 class="text-xl font-bold text-center mb-6">Resize Image</h3>
        <div id="crop-box"></div>
        <div class="flex gap-3 mt-8">
            <button id="save-crop" class="flex-1 bg-indigo-600 text-white font-bold py-4 rounded-2xl">Apply</button>
            <button onclick="$('#cropModal').addClass('hidden')" class="flex-1 bg-slate-100 text-slate-500 font-bold py-4 rounded-2xl">Cancel</button>
        </div>
    </div>
</div>

<script>
    let $croppie = $('#crop-box').croppie({
        viewport: { width: 220, height: 220, type: 'square' },
        boundary: { width: 300, height: 300 }
    });

    $('#img_input').on('change', function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#cropModal').removeClass('hidden');
            $croppie.croppie('bind', { url: e.target.result });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#save-crop').on('click', function() {
        $croppie.croppie('result', { type: 'base64', size: 'viewport' }).then(function(base64) {
            $.post('dashboard.php?page=profile', { image_base64: base64 }, function() { location.reload(); });
        });
    });
</script>