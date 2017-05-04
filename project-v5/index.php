<?php
require_once('db.php');
//checks if you're logged in or not

 if(!isset($_SESSION['user_id']) ){
	header("Location: login.php");
 }

require_once('dashboard.php');

echo $head;
echo $body;
?>

<!-- conetent goes here-->

<?php

echo $end;
?>