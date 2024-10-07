<?php
$admin_mail = "Vivian.Stolt@edu.omnia.fi";
$smtpUsername = "Vivian Stolt";
$smtpPassword = "Akuankka10";

/* SendGrid */
$password_sendgrid = "idfryulsjhlrvxul";    
$username_sendgrid = "vivin.automaattinen@gmail.com";

/* Mailtrap */
$username_mailtrap = 'vivin.automaattinen@gmail.com';
$password_mailtrap = 'idfryulsjhlrvxul';

$db_username_local = 'stoltvi';
$db_password_local = '73743';
$db_server_local = "127.0.0.1";
$site_local = "http://localhost";

if (strpos($_SERVER['HTTP_HOST'], "azurewebsites") !== false) {
  $db_username_remote = 'stoltvi';
  $db_password_remote = '73743';
  $db_server_remote = "datasql7.westeurope.cloudapp.azure.com:6020";
  $site_remote = 'https://stoltvi.azurewebsites.net';
}
?>