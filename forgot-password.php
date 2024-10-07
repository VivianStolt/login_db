<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h1>Forgot Password</h1>
    
    <form method="post" action="send-password-reset.php">
        
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email">

            <button>Send reset link</button>
        
    </form>

</body>
</html>