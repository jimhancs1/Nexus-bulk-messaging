<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php'; 

// Capture parameters from URL
$pre_type = $_GET['type'] ?? 'single';
$pre_group_id = intval($_GET['group_id'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Message Composer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; padding-top: 6rem; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .preview-bubble { position: relative; background: #e0e7ff; border-radius: 1.5rem 1.5rem 1.5rem 0; padding: 1rem; color: #3730a3; max-width: 80%; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-900 min-h-screen">

    <?php include 'navbar.php'; ?>

    <main class="max-w-4xl mx-auto px-6 pb-12">
        <div class="glass rounded-3xl p-8 shadow-xl">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Compose Broadcast</h1>
                    <p class="text-slate-500 text-sm">Send messages to individuals or targeted groups.</p>
                </div>
            </div>

            <form id="messageForm" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Recipient Type</label>
                        <select id="recipientType" name="recipient_type" onchange="toggleRecipientFields(this.value)" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            <option value="single" <?= $pre_type == 'single' ? 'selected' : '' ?>>Single Contact</option>
                            <option value="multiple" <?= $pre_type == 'multiple' ? 'selected' : '' ?>>Multiple Selection</option>
                            <option value="group" <?= $pre_type == 'group' ? 'selected' : '' ?>>Specific Group</option>
                        </select>
                    </div>

                    <div id="singleField" class="recipient-group">
                        <label class="block text-sm font-semibold mb-2">Recipient</label>
                        <select name="contact_id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none">
                            <?php
                            $contacts = $conn->query("SELECT id, name, phone FROM contacts ORDER BY name ASC");
                            while ($c = $contacts->fetch_assoc()):
                            ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?> (<?= $c['phone'] ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div id="groupField" class="recipient-group hidden">
                        <label class="block text-sm font-semibold mb-2">Target Group</label>
                        <select name="group_id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500">
                            <?php
                            $groups = $conn->query("SELECT id, name FROM groups ORDER BY name ASC");
                            while ($g = $groups->fetch_assoc()):
                                $sel = ($g['id'] == $pre_group_id) ? 'selected' : '';
                            ?>
                            <option value="<?= $g['id'] ?>" <?= $sel ?>><?= htmlspecialchars($g['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div id="multipleField" class="recipient-group hidden">
                    <label class="block text-sm font-semibold mb-2">Select Members</label>
                    <div class="max-h-48 overflow-y-auto border border-slate-100 rounded-xl bg-slate-50/50 p-2 space-y-1 custom-scrollbar">
                        <?php
                        $contacts->data_seek(0);
                        while ($c = $contacts->fetch_assoc()):
                        ?>
                        <label class="flex items-center justify-between p-2 hover:bg-white rounded-lg cursor-pointer transition">
                            <span class="text-sm font-medium text-slate-700"><?= htmlspecialchars($c['name']) ?></span>
                            <input type="checkbox" name="selected_contacts[]" value="<?= $c['id'] ?>" class="w-4 h-4 rounded text-indigo-600">
                        </label>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Message</label>
                    <textarea id="messageContent" name="message" rows="5" oninput="updatePreview()" placeholder="Hello {name}, your appointment is scheduled..." 
                        class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none transition resize-none"></textarea>
                    <p class="text-[10px] text-slate-400 mt-2 uppercase font-bold tracking-widest">Live Preview Below</p>
                </div>

                <div class="preview-bubble shadow-sm" id="messagePreview">
                    <span class="opacity-50 italic text-sm">Preview will appear here...</span>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Send Broadcast
                </button>
            </form>
        </div>
    </main>

    <script>
        lucide.createIcons();

        function toggleRecipientFields(type) {
            document.querySelectorAll('.recipient-group').forEach(el => el.classList.add('hidden'));
            if(type === 'single') document.getElementById('singleField').classList.remove('hidden');
            if(type === 'multiple') document.getElementById('multipleField').classList.remove('hidden');
            if(type === 'group') document.getElementById('groupField').classList.remove('hidden');
        }

        function updatePreview() {
            const message = document.getElementById('messageContent').value;
            const preview = document.getElementById('messagePreview');
            preview.innerHTML = message.length === 0 ? '<span class="opacity-50 italic text-sm">...</span>' : message.replace(/{name}/g, '<span class="font-bold text-indigo-800">[Name]</span>');
        }

        // Run on load to set initial visibility based on URL parameters
        window.onload = function() {
            toggleRecipientFields(document.getElementById('recipientType').value);
        };
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
        // BroadCast Logic (Recipients gathered based on type)
        // This is where your SMS/API integration usually goes
        echo "<script>alert('Message broadcast queued successfully!'); window.location.href='messages.php';</script>";
    }
    ?>
</body>
</html>