<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sysincludes.php';
include('database.php');
include('process-signup.php'); // Ensure this path is correct

if (isset($_SESSION['auth_user']['email'])) {
    $email = $_SESSION['auth_user']['email'];

    // Fetch user details from the database
    $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $query_run = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $user = mysqli_fetch_array($query_run);
        $name = $user['name'];
        $verify_token = $user['verify_token'];

        // Resend the verification email
        if (sendemail_verify($name, $email, $verify_token)) {
            $_SESSION['success'] = "Vahvistussähköposti lähetettiin uudelleen onnistuneesti.";
        } else {
            $_SESSION['error'] = "Vahvistussähköpostin uudelleenlähetys epäonnistui.";
        }
    } else {
        $_SESSION['error'] = "Käyttäjää ei löytynyt.";
    }
} else {
    $_SESSION['error'] = "Istunnosta ei löytynyt sähköpostia.";
}

header("Location: index.php?page=login");
exit();
?>