<?php
include('authentication.php');
$page_title = "Questionnaire";
include('question-header.php'); 

?>



<h4> Username: <?= $_SESSION['auth_user']['name']; ?></h4>

<p><a href="logout.php">Log out</a></p>
