<?php
session_start();
include('database.php');

function sendemail_verify($name, $email, $verify_token){
    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@gmail.com", "No Reply");
    $mail->addAddress($email);
    $mail->Subject = "Email Verification";
    $server = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . $server;
    $email_template = "
    <h2>You have signed up to our website</h2>
    <h5>Click the link below to verify your email</h5>
    <br/><br/>
    <a href='http://$base_url/verify-email.php?token=$verify_token'>Click Me</a>";

    $mail->Body = $email_template;

    try {
        $mail->send();
        echo "Email sent. Please verify your email";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    $verify_token =md5(rand());


    $check_email_query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $check_email_query_run = mysqli_query($mysqli, $check_email_query);

    if(mysqli_num_rows($check_email_query_run)>0){
        $_SESSION['status'] = "Email Already Exists";
        header("Location: signup.php");
    }
    if (empty($name)) {
        die("Name is required");
    }
    
    if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }
    
    if (strlen($password) < 8) {
        die("Password must be at least 8 characters");
    }
    
    if ( ! preg_match("/[a-z]/i", $password)) {
        die("Password must contain at least one letter");
    }
    
    if ( ! preg_match("/[0-9]/", $password)) {
        die("Password must contain at least one number");
    }
    
    if ($password !== $password_confirmation) {
        die("Passwords must match");
    }
    
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (name, email, password_hash, verify_token)
        VALUES ('$name', '$email', '$password_hash', '$verify_token')";
        $query_run = mysqli_query($mysqli, $sql);

        if($query_run){
            sendemail_verify("$name", "$email", "$verify_token");
            $_SESSION['status'] = "Signup Successfull. Please verify your email";
            header("Location: signup.php");

        }
        else{
            $_SESSION['status'] = "Signup Failed";
            header("Location: signup.php");
        }

    
}
        
// $stmt = $mysqli->stmt_init();

// if ( ! $stmt->prepare($sql)) {
//     die("SQL error: " . $mysqli->error);
// }

// $stmt->bind_param("sss",
//                   $name,
//                   $email,
//                   $password_hash);
                  
// if ($stmt->execute()) {

//     header("Location: signup-success.html");
//     exit;
    
// } else {
    
//     if ($mysqli->errno === 1062) {
//         die("email already taken");
//     } else {
//         die($mysqli->error . " " . $mysqli->errno);
//     }
//  }

?>






