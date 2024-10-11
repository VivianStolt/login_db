<?php
session_start(); // Add this line at the beginning
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="pop">
    <h1>Unohtuiko salasana?</h1>
    <?php

    if(isset($_SESSION['error'])){
        echo "<p class='error'><svg class='icon'><use xlink:href='icons.svg#warning'></use></svg> {$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
    
    <form method="post" action="send-password-reset.php">
        <input type="email" id="email" name="email" placeholder="Sähköposti">
        <button>Lähetä nollauslinkki</button>
    </form>
</div>

</body>
</html>