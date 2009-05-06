<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');

	require('top.php');
?>
<h1>SendMe :: Mina resultat</h1> 