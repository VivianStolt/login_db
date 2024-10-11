<?php
// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '.stoltvi-gad0bgcdhmh8c6hk.westeurope-01.azurewebsites.net',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Start the session
session_start();

// Database connection and other common includes
?>