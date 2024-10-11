<?php
session_start();

if (isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You are already Logged In";
    header('Location: questionnaire.php');
    exit(0);
}
if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
    $id = $_COOKIE['email'];
    $pass = $_COOKIE['password'];
}else{
    $id = "";
    $pass = "";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="pop">
        
        <h1>Kirjaudu</h1>
        <?php if(isset($_SESSION['status'])){ ?>
            <div class="alert status">
            <?php echo $_SESSION['status']; ?>
            </div>
           <?php  unset($_SESSION['status']); } ?>

        <?php if(isset($_SESSION['error'])){?>
            <div class="alert error">
                <?php echo "<svg class='icon'><use xlink:href='icons.svg#warning'></use></svg>" . $_SESSION['error']; ?>
            </div>
        <?php unset($_SESSION['error']); }?>

        <?php if(isset($_SESSION['success'])){?>
            <div class="alert success">
                <?php echo "<svg class='icon'><use xlink:href='#valid'></use></svg>" . $_SESSION['success']; ?>
            </div>
        <?php unset($_SESSION['success']); }?>
 
        
        <form action="logincode.php" method="POST">

            <input type="email" name="email" id="email" placeholder="Sähköposti"
                    value="<?php echo htmlspecialchars($id); ?>" >

            <input type="password" name="password" placeholder="Salasana"
                    value="<?php echo htmlspecialchars($pass); ?>">
            <label>
                <input class="checkbox" type="checkbox" name="remember_me">
                Muista minut
            </label>
            
            <button class='sign' name="login_btn">Kirjaudu</button>
        </form>
        <?php if (isset($_SESSION['email_not_verified'])): ?>
            <label>Etkö saanut sähköpostia?
                <form class='fit' action="resend-email-verification.php" method="GET">
                    <button class='text' type="submit">Lähetä Uudelleen</button>
                </form>
            </label>
        <?php endif; ?>
        <a href="#" id="forgot-password-link">Unohtuiko Salasana?</a>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">

        <symbol id="valid" viewBox="0 0 18 18">
        <path d="M9.44305 16.9176C9.15791 17.0275 8.84204 17.0275 8.5569 16.9176C6.33201 16.0638 4.41857 14.5557 3.06935 12.5921C1.7201 10.6287 0.998559 8.30235 1 5.92041V2.2301C1 1.90386 1.12967 1.59097 1.36048 1.36029C1.5913 1.1296 1.90435 1 2.23077 1H15.7692C16.0956 1 16.4087 1.1296 16.6395 1.36029C16.8703 1.59097 17 1.90386 17 2.2301V5.92041C17.0014 8.30235 16.2799 10.6287 14.9307 12.5921C13.5814 14.5557 11.6679 16.0638 9.44305 16.9176Z" stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M12.7271 5.27881L7.76321 10.8602L5.28125 8.99974" stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>

</svg>
</body>
</html>