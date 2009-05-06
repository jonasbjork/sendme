<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');
	$userName = $_SESSION['sendMe']['fullName'];
	$userId = $_SESSION['sendMe']['id'];
	$menu = create_menu($userId);
	$message = "";
	
	$_minaKurserAntal = 0;
	
	if(isset($_POST['submitAddCourse'])) {
		$kurs_id = db_clean($_POST['kurs_id']);
		//$message = $kurs_id;
		$sql = "SELECT id FROM kurs_user WHERE user_id='".$_SESSION['sendMe']['id']."' AND kurs_id='$kurs_id' LIMIT 1";
		if(mysql_num_rows(mysql_query($sql)) == 1) {
			$message = "Du är redan medlem i den kursen.";
		} else {
			$sql = "INSERT INTO kurs_user(user_id, kurs_id) VALUES('".$_SESSION['sendMe']['id']."','".$kurs_id."')";
			mysql_query($sql);
			$message = "Du lades till i kursen ".db_get_course_name($kurs_id)." .";
		}
	}

	// Hämta alla kurser
	$sql = "SELECT id, namn, skapad_av FROM kurs WHERE active='1' ORDER BY namn";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		while($r = mysql_fetch_array($q)) {
			$_kurser[] = $r;
		}
	}
	
	// Hämta vilka kurser jag är med i
	//$sql = "SELECT kurs.id, kurs.namn, CONCAT(users.fnamn, " ", users.enamn) AS larare FROM kurs LEFT JOIN users ON kurs.skapad_av=users.id WHERE kurs.active='1' ORDER BY namn";
	
	$sql = "SELECT kurs.id, kurs.namn, CONCAT(users.fnamn, ' ', users.enamn) AS larare FROM kurs_user LEFT JOIN kurs ON kurs_user.kurs_id=kurs.id LEFT JOIN users ON kurs.skapad_av=users.id WHERE user_id='$userId' AND kurs_user.active='1' AND kurs.active='1'";
	
	//$sql = "SELECT kurs_id FROM kurs_user WHERE user_id='".$_SESSION['sendMe']['id']."' AND active='1'";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		while($r = mysql_fetch_array($q)) {
			$_minaKurser[] = $r;
			$_minaKurserAntal++;
		}
	} else {
		$_minaKurser[] = "";
	}

	$smarty->assign('message', $message);
	$smarty->assign('userName', $userName);	
	$smarty->assign('siteMenu', $menu);
	$smarty->assign('title', "SendMe :: Mina kurser");
	$smarty->assign('kurser', $_kurser);
	$smarty->assign('minaKurser', $_minaKurser);
	$smarty->assign('minaKurserAntal', $_minaKurserAntal);
	$smarty->assign('page', "courses_student");
	$smarty->display('main.tpl');
	
	die();

?>


<?php


?>



