<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sysincludes.php';
include('database.php');

function sendemail_verify($name, $email, $verify_token){
    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@gmail.com", "No Reply");
    $mail->addAddress($email);
    $mail->Subject = "Email Verification";
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    
    $server = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . $server;
    $email_template = "
    <h2>You have signed up to our website</h2>
    <h5>Click the link below to verify your email</h5>
    <br/><br/>
    <a href='$base_url/verify-email.php?token=$verify_token'>Click Me</a>";

    $mail->Body = $email_template;

    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    $verify_token = md5(rand());

    $_SESSION['input_values'] = $_POST;
    $_SESSION['errors'] = [];
    $_SESSION['success'] = [];

    $check_email_query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $check_email_query_run = mysqli_query($mysqli, $check_email_query);

    if(mysqli_num_rows($check_email_query_run)>0){
        $_SESSION['errors'][] = "Sähköposti on jo olemassa";
        header("Location: index.php?page=signup");
        exit();
    }
    if (empty($name)) {
        $_SESSION['errors'][] = "Nimi on pakollinen";
    }else{
        $_SESSION['success'][] = "Nimi on pakollinen";
    }
    
    if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'][] = "Kelvollinen sähköpostiosoite on pakollinen";
    }else{
        $_SESSION['success'][] = "Kelvollinen sähköpostiosoite on pakollinen";
    }
    
    if (strlen($password) < 8) {
        $_SESSION['errors'][] = "Salasanan on oltava vähintään 8 merkkiä pitkä";
    }else{
        $_SESSION['success'][] = "Salasanan on oltava vähintään 8 merkkiä pitkä";
    }
    
    if ( ! preg_match("/[a-z]/i", $password)) {
        $_SESSION['errors'][] = "Salasanan on sisällettävä vähintään yksi kirjain";
    }else{
        $_SESSION['success'][] = "Salasanan on sisällettävä vähintään yksi kirjain";
    }
    
    if ( ! preg_match("/[0-9]/", $password)) {
        $_SESSION['errors'][] = "Salasanan on sisällettävä vähintään yksi numero.";
    }else{
        $_SESSION['success'][] = "Salasanan on sisällettävä vähintään yksi numero.";
    }
    
    if ($password !== $password_confirmation) {
        $_SESSION['errors'][] = "Salasanojen on täsmättävä.";
    }

    if (!empty($_SESSION['errors'])) {
        header("Location: index.php?page=signup");
        exit();
    }
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (name, email, password_hash, verify_token)
            VALUES ('$name', '$email', '$password_hash', '$verify_token')";
    $query_run = mysqli_query($mysqli, $sql);

    if($query_run){
        if (sendemail_verify($name, $email, $verify_token)) {
            unset($_SESSION['success']);
            $_SESSION['great'] = "Rekisteröityminen onnistui. Vahvista sähköpostisi.";
            $_SESSION['email_not_verified'] = true;
            $_SESSION['auth_user']['email'] = $email;
            unset($_SESSION['input_values']);
            header("Location: index.php?page=login");
            exit();
        } else {
            $_SESSION['errors'][] = "Vahvistussähköpostin lähettäminen epäonnistui.";
            // Optionally, you can delete the user from the database if email verification fails
            $delete_query = "DELETE FROM user WHERE email = ?";
            $stmt = $mysqli->prepare($delete_query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            header("Location: index.php?page=signup");
            exit();
        }
    } else {
        $_SESSION['errors'][] = "Rekisteröityminen epäonnistui.";
        header("Location: index.php?page=signup");
        exit();
    }
}
?>