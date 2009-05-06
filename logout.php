<?php
	// logout.php
	session_start();
	unset($_SESSION['sendMe']);
	session_destroy();
	header("Location: index.php");	
	
?>