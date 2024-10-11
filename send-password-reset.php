<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sysincludes.php';

$email = $_POST["email"];

// Validate email input
if (empty($email)) {
    $_SESSION['error'] = "Sähköpostiosoite on pakollinen.";
    header("Location: index.php?page=forgot-password");
    exit(0);
}

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/database.php";

$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($mysqli->affected_rows) {
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("noreply@gmail.com", "No Reply");
    $mail->addAddress($email);
    $mail->Subject = "Password reset";
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $server = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . $server;
    $mail->Body = <<<END
    Click <a href="$base_url/index.php?page=reset-password&token=$token">here</a> to reset your password.
    END;

    try {
        $mail->send();
    } catch (Exception $e) {
        $_SESSION['error'] = "Viestin lähetys epäonnistui. Sähköpostivirhe: {$mail->ErrorInfo}";
        header("Location: index.php?page=forgot-password");
        exit(0);
    }
} 
$_SESSION['success'] = "Viesti lähetetty, tarkista sähköpostisi.";
header("Location: index.php?page=login");
exit(0);