<?php
session_start(); // Add this line at the beginning

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$_SESSION['errors'] = [];
$_SESSION['success'] = [];

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

if (strlen($_POST["password"]) < 8) {
    $_SESSION['errors'][] = "Salasanan on oltava vähintään 8 merkkiä pitkä";
} else {
    $_SESSION['success'][] = "Salasanan on oltava vähintään 8 merkkiä pitkä";
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    $_SESSION['errors'][] = "Salasanan on sisällettävä vähintään yksi kirjain";
} else {
    $_SESSION['success'][] = "Salasanan on sisällettävä vähintään yksi kirjain";
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    $_SESSION['errors'][] = "Salasanan on sisällettävä vähintään yksi numero.";
} else {
    $_SESSION['success'][] = "Salasanan on sisällettävä vähintään yksi numero.";
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    $_SESSION['errors'][] = "Salasanojen on täsmättävä.";
}
if (!empty($_SESSION['errors'])) {
    header("Location: index.php?page=reset-password&token=$token");
    exit(0);
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $password_hash, $user["id"]);
$stmt->execute();


$_SESSION['success'] = "Salasana päivitetty. Voit nyt kirjautua sisään.";
header("Location: index.php?page=login");
exit(0);