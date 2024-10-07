<?php

$host_local = "127.0.0.1";
$host_remote = "datasql7.westeurope.cloudapp.azure.com";
$dbname = "login_db";
$username_local = "stoltvi";
$password_local = "73743";
$username_remote = "stoltvi";
$password_remote = "73743";
$port_remote = 6020;

if (strpos($_SERVER['HTTP_HOST'], "azurewebsites") !== false) {
    $host = $host_remote;
    $username = $username_remote;
    $password = $password_remote;
    $port = $port_remote;
} else {
    $host = $host_local;
    $username = $username_local;
    $password = $password_local;
    $port = ini_get("mysqli.default_port");
}

$mysqli = new mysqli($host, $username, $password, $dbname, $port);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;