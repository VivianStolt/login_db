<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sysincludes.php';
if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .hidden {
            display: none;
        }
        .visible {
            display: flex;
        }
    </style>
</head>
<body>

<div class="container">    
    <div class="top">
        <img src="photos/main-logo.png" class="Logo1" >
        <img src="photos/secondary-logo.png" alt="Logo2" >
    </div>

    <div class="buttons">
        <h1 class="white">Vahvistamme <br/>toinen <br/>toistamme!</h1>
            <form> 
                <button type="button" id="signup-button">Rekisteröidy</button>
                <button type="button" class='log' id="login-button">Kirjaudu</button>
            </form>

    </div>
</div>
<div id="signup-content" class="hidden"></div>
<div id="login-content" class="hidden"></div>
<div id="forgot-password-content" class="hidden"></div>
<div id="reset-password-content" class="hidden"></div>

<script>
        let isLoadingContent = false;

        function loadContent(url, elementId) {
            isLoadingContent = true;
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('signup-content').classList.add('hidden');
                    document.getElementById('login-content').classList.add('hidden');
                    document.getElementById('forgot-password-content').classList.add('hidden');
                    document.getElementById('reset-password-content').classList.add('hidden');
                    document.getElementById(elementId).innerHTML = data;
                    document.getElementById(elementId).classList.remove('hidden');
                    document.getElementById(elementId).classList.add('visible');
                    isLoadingContent = false;
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const page = params.get('page');
            const token = params.get('token');
            const loginContent = document.getElementById('login-content');
            if (page === 'signup') {
                loadContent('signup.php', 'signup-content');
            } else if (page === 'login') {
                loadContent('login.php', 'login-content');
            } else if (page === 'forgot-password') {
                loadContent('forgot-password.php', 'forgot-password-content');
            } else if (page === 'reset-password' && token) {
                loadContent(`reset-password.php?token=${token}`, 'reset-password-content');
            }

            document.getElementById('signup-button').addEventListener('click', function() {
                loadContent('signup.php', 'signup-content');
            });

            document.getElementById('login-button').addEventListener('click', function() {
                loadContent('login.php', 'login-content');
            });

            document.addEventListener('click', function(event) {
                if (event.target && event.target.id === 'forgot-password-link') {
                    event.preventDefault();
                    loadContent('forgot-password.php', 'forgot-password-content');
                    loginContent.classList.remove('visible');
                }
            });

            document.addEventListener('click', function(event) {
                if (isLoadingContent) return; // Ignore clicks if content is being loaded

                const signupContent = document.getElementById('signup-content');
                const loginContent = document.getElementById('login-content');
                const forgotPasswordContent = document.getElementById('forgot-password-content');
                const resetPasswordContent = document.getElementById('reset-password-content');
                const popups = document.querySelectorAll('.pop');

                let isClickInsidePopup = false;
                popups.forEach(popup => {
                    if (popup.contains(event.target)) {
                        isClickInsidePopup = true;
                    }
                });

                if (!isClickInsidePopup) {
                    if (!signupContent.classList.contains('hidden')) {
                        signupContent.classList.add('hidden');
                        signupContent.classList.remove('visible');
                    }
                    if (!loginContent.classList.contains('hidden')) {
                        loginContent.classList.add('hidden');
                        loginContent.classList.remove('visible');
                    }
                    if (!forgotPasswordContent.classList.contains('hidden')) {
                        forgotPasswordContent.classList.add('hidden');
                        forgotPasswordContent.classList.remove('visible');
                    }
                    if (!resetPasswordContent.classList.contains('hidden')) {
                        resetPasswordContent.classList.add('hidden');
                        resetPasswordContent.classList.remove('visible');
                    }
                }
            });
        });
    </script>

</body>
</html>