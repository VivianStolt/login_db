<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/svg+xml" href="icons.svg">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class='pop'>
        <h1>Rekisteröidy</h1>

            <?php
            if(isset($_SESSION['status'])){
                echo "<p>" .$_SESSION['status']."</p>";
                unset($_SESSION['status']);
            }

            if(isset($_SESSION['errors'])){
                foreach($_SESSION['errors'] as $error){
                    echo "<p class='error'><svg class='icon'><use xlink:href='icons.svg#warning'></use></svg> $error</p>";
                }
                unset($_SESSION['errors']);
            }

            if(isset($_SESSION['success'])){
                foreach($_SESSION['success'] as $success){
                    echo "<p class='success'><svg class='icon'><use xlink:href='icons.svg#valid'></use></svg>$success</p>";
                }
                unset($_SESSION['success']);
            }
            ?>

        <form action="process-signup.php" method="POST" id="signup" novalidate>
            <input type="text" id="name" name="name" placeholder="Nimi" value="<?php echo isset($_SESSION['input_values']['name']) ? $_SESSION['input_values']['name'] : ''; ?>">
            <input type="email" id="email" name="email" placeholder="Sähköposti" value="<?php echo isset($_SESSION['input_values']['email']) ? $_SESSION['input_values']['email'] : ''; ?>">
            <input type="password" id="password" name="password" placeholder="Salasana">
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Toista Salasana">
            <button type="submit" name="submit" class='sign'>Rekisteröidy</button>
        </form>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="valid" viewBox="0 0 18 18">
            <path d="M9.44305 16.9176C9.15791 17.0275 8.84204 17.0275 8.5569 16.9176C6.33201 16.0638 4.41857 14.5557 3.06935 12.5921C1.7201 10.6287 0.998559 8.30235 1 5.92041V2.2301C1 1.90386 1.12967 1.59097 1.36048 1.36029C1.5913 1.1296 1.90435 1 2.23077 1H15.7692C16.0956 1 16.4087 1.1296 16.6395 1.36029C16.8703 1.59097 17 1.90386 17 2.2301V5.92041C17.0014 8.30235 16.2799 10.6287 14.9307 12.5921C13.5814 14.5557 11.6679 16.0638 9.44305 16.9176Z" stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12.7271 5.27881L7.76321 10.8602L5.28125 8.99974" stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </symbol>
    </svg>


</body>
</html>