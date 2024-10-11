<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/sysincludes.php';

if(!isset($_SESSION['authenticated'])){
    $_SESSION['status'] = "Please log in to access the webpage's content.";
    header("Location: index.php?page=login");
    exit(0);
}


?>