<?php
	session_start();
	require_once('config.php');
	require_once('functions.php');
	
	if(!db_check_larare($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	$message = "";
	
	if(isset($_GET['action'])) {
		$action = $_GET['action'];
		if($action == "delete") {
			$id = db_clean($_GET['id']);
			$sql = "SELECT id FROM kurs WHERE id='$id' AND skapad_av='$userId' LIMIT 1";
			if(mysql_num_rows(mysql_query($sql)) == 1) {
				$sql = "UPDATE kurs SET active='0' WHERE id='$id' AND skapad_av='$userId' LIMIT 1";
				mysql_query($sql);
				$message = "Kursen togs bort.";
			} 
			
		}
		
	}
	
	// Skapa en kurs
	if(isset($_POST['courseName'])) {
		$kursNamn = db_clean($_POST['courseName']);
		if(db_check_course_name($kursNamn)) {
			$message = "Kursnamnet finns redan!";
		} else {
			// Skapa kursen
			$sql = "INSERT INTO kurs(namn, skapad_av, skapad_datum) VALUES('".
				$kursNamn."','".$_SESSION['sendMe']['id']."','".time()."')";
			mysql_query($sql);
			$message = "Kursen skapades";
		}
		
	}
	
	$sql = "SELECT * FROM kurs WHERE skapad_av='".$_SESSION['sendMe']['id']."' AND active='1' ORDER BY namn";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		while($r = mysql_fetch_array($q)) {
			$_kurser[] = $r;
		}
	}

	$smarty->assign('message', $message);
	$smarty->assign('userName', $userName);	
	$smarty->assign('siteMenu', create_menu($userId));
	$smarty->assign('title', "SendMe :: Hantera mina kurser");
	$smarty->assign('kurser', $_kurser);
	$smarty->assign('page', "courses_teacher");
	$smarty->display('main.tpl');

?>