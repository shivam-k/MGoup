<?php
session_start();
if($_SESSION['username']) {
  session_destroy();
  header("Location: login.php");
}
else {
	header ("Location: index.php");
}


?>