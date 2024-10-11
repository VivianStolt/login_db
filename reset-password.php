<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sysincludes.php';


$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT email, reset_token_expires_at FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    $_SESSION['error'] ="Tunnusta ei löytynyt.";
    header("Location: index.php?page=login");
    exit(0);
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    $_SESSION['error'] ="Tunnus on vanhentunut.";
    header("Location: index.php?page=login");
    exit(0);
}

$email = $user["email"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">

</head>
<body>
    <div class="pop">
        <h1>Salasanan nollaus</h1>
        <?php

            if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $error) {
                    echo "<p class='error'><svg class='icon'><use xlink:href='icons.svg#warning'></use></svg> $error</p>";
                }
                unset($_SESSION['errors']);
            }

            if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
                foreach ($_SESSION['success'] as $success) {
                    echo "<p class='success'><svg class='icon'><use xlink:href='icons.svg#valid'></use></svg> $success</p>";
                }
                unset($_SESSION['success']);
            }
        ?>
        
                
        
        <form method="post" action="process-reset-password.php">
            
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <input type="password" id="password" name="password" placeholder="Salasana">
            
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Toista Salasana">
            
            <button>Salasanan nollaus</button>
            
        </form>
    </div>
</body>
</html>

