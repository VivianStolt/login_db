<?php
$host_local = "localhost";
$host_remote = "datasql7.westeurope.cloudapp.azure.com";
$dbname = "login_db";
$username_local = "root";
$password_local = "";
$username_remote = "stoltvi";
$password_remote = "73743";
$port_remote = 6020;

if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
    $host = $host_local;
    $username = $username_local;
    $password = $password_local;
    $port = ini_get("mysqli.default_port");
}else{
    $host = $host_remote;
    $username = $username_remote;
    $password = $password_remote;
    $port = $port_remote;
}

$mysqli = new mysqli($host, $username, $password, $dbname, $port);

if ($mysqli->connect_errno) {
    error_log('Connection error: ' . $mysqli->connect_error);
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;