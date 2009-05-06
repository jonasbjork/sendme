<?php
	// getfile.php
	// Den här filen används enbart för att skicka en fil som ligger lagrad på servern.
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');

	$fid = explode("-", $_GET['file']);
	$time = db_clean($fid[0]);
	$name = db_clean($fid[1]);
	$sql = "SELECT name_orig, name_store, file_type, file_size FROM uppgifter WHERE inlamnad='$time' AND name_orig='$name' LIMIT 1";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) == 1) {
		$r = mysql_fetch_array($q);
		$fname = stripslashes($r['name_orig']);
		$fstore = stripslashes($r['name_store']);
		$ftype = stripslashes($r['file_type']);
		$fsize = stripslashes($r['file_size']);		
		header('Content-type: '.$ftype);
		header('Content-Disposition: attachment; filename="'.$fname.'"');
		header('Content-Length: '.$fsize);
		readfile('uploads/'.$fstore);
	} else {
		echo "<h1>404 filen finns inte</h1>";
		echo "<a href='index.php'>Startsidan</a>";
	}
?>