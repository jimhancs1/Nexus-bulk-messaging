<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'config.php';
require_once 'vendor/autoload.php';

use AfricasTalking\SDK\AfricasTalking;
use PHPMailer\PHPMailer\PHPMailer;
use Twilio\Rest\Client;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $channel = $_POST['channel'];
    $message = $_POST['message'];
    $scheduled_at = $_POST['scheduled_at'] ?: null;
    $email_subject = $_POST['email_subject'] ?? 'New Notification from Nexus';
    
    // Resolve Recipients
    $targets = [];
    $type = $_POST['recipient_type'];

    if ($type === 'manual') $targets[] = $_POST['manual_phone'];
    elseif ($type === 'single') $targets[] = $_POST['contact_phone'];
    elseif ($type === 'multiple') $targets = $_POST['selected_contacts'];
    elseif ($type === 'group') {
        $gid = intval($_POST['group_id']);
        $res = $conn->query("SELECT phone FROM group_members gm JOIN contacts c ON gm.contact_id = c.id WHERE gm.group_id = $gid");
        while($r = $res->fetch_assoc()) $targets[] = $r['phone'];
    }

    $all_targets = implode(',', $targets);

    if ($scheduled_at) {
        // QUEUE FOR LATER
        $stmt = $conn->prepare("INSERT INTO sent_messages (recipients, message_content, status, channel, email_subject, scheduled_at) VALUES (?, ?, 'pending', ?, ?, ?)");
        $stmt->bind_param("sssss", $all_targets, $message, $channel, $email_subject, $scheduled_at);
        $stmt->execute();
        header("Location: messages.php?status=scheduled");
    } else {
        // SEND IMMEDIATELY
        try {
            foreach ($targets as $recipient) {
                if ($channel === 'sms') {
                    $AT = new AfricasTalking("sandbox", "YOUR_AT_API_KEY");
                    $AT->sms()->send(['to' => $recipient, 'message' => $message]);
                } 
                elseif ($channel === 'whatsapp') {
                    $twilio = new Client("TWILIO_SID", "TWILIO_TOKEN");
                    $twilio->messages->create("whatsapp:".$recipient, ["from" => "whatsapp:+14155238886", "body" => $message]);
                }
                elseif ($channel === 'email') {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your_email@gmail.com';
                    $mail->Password = 'app_password';
                    $mail->setFrom('your_email@gmail.com', 'Nexus Broadcast');
                    $mail->addAddress($recipient); // Assumes $recipient is an email in this case
                    $mail->Subject = $email_subject;
                    $mail->Body = $message;
                    $mail->send();
                }
            }

            // Log Success
            $stmt = $conn->prepare("INSERT INTO sent_messages (recipients, message_content, status, channel) VALUES (?, ?, 'sent', ?)");
            $stmt->bind_param("sss", $all_targets, $message, $channel);
            $stmt->execute();

            header("Location: messages.php?status=success");
        } catch (Exception $e) {
            header("Location: messages.php?status=error&msg=" . urlencode($e->getMessage()));
        }
    }
}