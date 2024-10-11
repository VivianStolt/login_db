<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sysincludes.php';
include('database.php');



if(isset($_POST['login_btn'])){
    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])))
    {
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $password = mysqli_real_escape_string($mysqli, $_POST['password']);

        $login_query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
        $login_query_run = mysqli_query($mysqli, $login_query);

        if(mysqli_num_rows($login_query_run) > 0){
            $row = mysqli_fetch_array($login_query_run);
            if(password_verify($password, $row['password_hash'])){
                if($row['verify_status'] == "1"){

                    $_SESSION['authenticated'] = true;
                    $_SESSION['auth_user'] = [
                        'name' => $row['name'],
                        'email' => $row['email']
                    ];
                    if(isset($_POST['remember_me'])){
                        setcookie('email', $email, time() + (86400 * 30), "/");
                        setcookie('password', $password, time() + (86400 * 30), "/");
                    }else{
                        setcookie('email', '', time() - (86400 * 30), "/");
                        setcookie('password', '', time() - (86400 * 30), "/");
                    }
                    $_SESSION['success'] = "Kirjautuminen onnistui";
                    unset($_SESSION['email_not_verified']);
                    header("Location: questionnaire.php");
                    exit(0);
                }else{
                    $_SESSION['error'] = "Sähköpostia ei ole vahvistettu. Ole hyvä ja vahvista sähköpostisi.";
                    $_SESSION['email_not_verified'] = true;
                    $_SESSION['auth_user']['email'] = $email;
                    header("Location: index.php?page=login");
                    exit(0);
                }
            } else {
                $_SESSION['error'] = "Virheellinen sähköposti tai salasana";
                header("Location: index.php?page=login");
                exit(0);
            }
        }else{
            $_SESSION['error'] = "Virheellinen sähköposti tai salasana";
            header("Location: index.php?page=login");
            exit(0);
        }
    }
    else{
        $_SESSION['error'] = "Kaikki kentät ovat pakollisia";
        header("Location: index.php?page=login");
        exit(0);
    }
}
?>