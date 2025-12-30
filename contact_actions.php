<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// --- IMPORT CSV ---
if (isset($_POST['import_csv'])) {
    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
        fgetcsv($file); // Skip header
        while (($column = fgetcsv($file)) !== FALSE) {
            $name = $conn->real_escape_string($column[1]);
            $phone = $conn->real_escape_string($column[2]);
            $email = $conn->real_escape_string($column[3]);
            $conn->query("INSERT INTO contacts (name, phone, email) VALUES ('$name', '$phone', '$email')");
        }
        header("Location: contacts.php?msg=Imported");
    }
}


// ADD CONTACT
if (isset($_POST['add_contact'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $notes = $conn->real_escape_string($_POST['notes']);

    $conn->query("INSERT INTO contacts (name, phone, email, notes) VALUES ('$name', '$phone', '$email', '$notes')");
    header("Location: contacts.php?msg=added");
    exit;
}

// BULK DELETE
if (isset($_POST['bulk_delete']) && isset($_POST['selected_ids'])) {
    $ids = implode(',', array_map('intval', $_POST['selected_ids']));
    $conn->query("DELETE FROM contacts WHERE id IN ($ids)");
    header("Location: contacts.php?msg=deleted");
    exit;
}

// --- AJAX: GET CONTACT FOR EDIT ---
if (isset($_GET['get_contact'])) {
    $id = (int)$_GET['get_contact'];
    $res = $conn->query("SELECT * FROM contacts WHERE id = $id");
    $contact = $res->fetch_assoc();
    ?>
    <form action="contact_actions.php" method="POST" class="bg-white rounded-3xl overflow-hidden shadow-2xl">
        <input type="hidden" name="id" value="<?= $contact['id'] ?>">
        <div class="p-6 border-b font-bold text-lg">Edit Contact</div>
        <div class="p-6 space-y-4">
            <input type="text" name="name" value="<?= $contact['name'] ?>" class="w-full p-3 bg-slate-50 rounded-xl border">
            <input type="text" name="phone" value="<?= $contact['phone'] ?>" class="w-full p-3 bg-slate-50 rounded-xl border">
            <input type="email" name="email" value="<?= $contact['email'] ?>" class="w-full p-3 bg-slate-50 rounded-xl border">
            <textarea name="notes" class="w-full p-3 bg-slate-50 rounded-xl border"><?= $contact['notes'] ?></textarea>
        </div>
        <div class="p-6 bg-slate-50 flex gap-2">
            <button type="button" onclick="toggleModal('editContactModal')" class="flex-1 py-3">Cancel</button>
            <button type="submit" name="update_contact" class="flex-1 py-3 bg-indigo-600 text-white rounded-xl font-bold">Update</button>
        </div>
    </form>
    <?php
}

// --- UPDATE CONTACT ---
if (isset($_POST['update_contact'])) {
    $id = (int)$_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $conn->query("UPDATE contacts SET name='$name', phone='$phone', email='$email' WHERE id=$id");
    header("Location: contacts.php?msg=Updated");
}
?>