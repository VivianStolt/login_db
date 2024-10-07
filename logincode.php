<?php
session_start();
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
                    $_SESSION['status'] = "Login Successfull";
                    header("Location: index.php");
                    exit(0);
                }else{
                    $_SESSION['status'] = "Email Not Verified. Please Verify Your Email";
                    header("Location: login.php");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Invalid Email or Password";
                header("Location: login.php");
                exit(0);
            }
        }else{
            $_SESSION['status'] = "Invalid Email or Password";
            header("Location: login.php");
            exit(0);
        }
    }
    else{
        $_SESSION['status'] = "All fields are Mandetory";
        header("Location: login.php");
        exit(0);
    }
}

?>