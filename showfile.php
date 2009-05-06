<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: login.php");
	}
	require('config.php');
	require('functions.php');

	$userName = $_SESSION['sendMe']['fullName'];
	$userId = $_SESSION['sendMe']['id'];
	$menu = create_menu($userId);
	$message = "";

	$fid = explode("-", $_GET['file']);
	$time = db_clean($fid[0]);
	$name = db_clean($fid[1]);
	$safe_name = $time."-".$name;	

	// om vi postar en kommentar/betyg
	if(isset($_POST['submitGrade'])) {
		$comments = db_clean($_POST['comments']);
		$grade = db_clean($_POST['grade']);
		if($grade == 0) {
			$message = "Du måste ange ett omdöme/betyg för uppgiften.";
		} else {
			$sql = "SELECT id FROM uppgifter WHERE name_orig='$name' AND inlamnad='$time' LIMIT 1";
			$r = mysql_fetch_array(mysql_query($sql));
			$uid = $r['id'];
			$update_sql = "UPDATE uppgifter SET rattad='1', rattad_av='".$_SESSION['sendMe']['id']."', betyg='".$grade."' WHERE id='$uid'";
			$update_query = mysql_query($update_sql);
			$insert_sql = sprintf("INSERT INTO kommentar(uppgift_id, kommentar, tid, kommentar_av) VALUES('%s','%s','%s','%s')", $uid, $comments, time(), $_SESSION['sendMe']['id']);
			$insert_query = mysql_query($insert_sql);
			$message = "Din kommentar och ditt omdöme registerades.";
			header("Location: index.php?m=$message");
			unset($_POST);
		}		
	}
		
	(isset($_POST['comments'])) ? $comments = $_POST['comments'] : $comments = "";
	
	$sql = "SELECT id, user_id, name_orig, inlamnad, rattad, rattad_av, kurs_id FROM uppgifter WHERE name_orig='$name' AND inlamnad='$time' LIMIT 1";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) == 1) {
		$r = mysql_fetch_array($q);
		$uId = $r['id'];
		$kurs = db_get_course_name(stripslashes($r['kurs_id']));
		$user = db_get_user_name(stripslashes($r['user_id']));
		$filnamn = stripslashes($r['name_orig']);
		$inlamnad = show_date(stripslashes($r['inlamnad']));
		$rattad = stripslashes($r['rattad']);
		$rattad_av = stripslashes($r['rattad_av']);
	}
	
	$kommentarAntal = 0;
	$sql ="SELECT kommentar.id, kommentar.kommentar, FROM_UNIXTIME(kommentar.tid, '%Y-%m-%d %H:%i') AS tid, CONCAT(users.fnamn, ' ', users.enamn) AS namn FROM kommentar RIGHT JOIN users ON users.id=kommentar.kommentar_av WHERE uppgift_id='$uId' ORDER BY kommentar.tid DESC";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		while($r = mysql_fetch_array($q)) {
			$_kommentarer[] = $r;
			$kommentarAntal++;
		}
	} else {
		$_kommentarer[] = "";
	}
	$smarty->assign('kommentarer', $_kommentarer);
	$smarty->assign('kommentarAntal', $kommentarAntal);
	$smarty->assign('userName', $userName);
	$smarty->assign('siteMenu', $menu);
	$smarty->assign('kurs', $kurs);
	$smarty->assign('user', $user);
	$smarty->assign('filnamn', $filnamn);
	$smarty->assign('safe_name', $safe_name);
	$smarty->assign('inlamnad', $inlamnad);
	$smarty->assign('comments', $comments);
	$smarty->assign('page', 'showfile');
	$smarty->assign('message', $message);
	$smarty->assign('title', "SendMe :: Rätta uppgift");
	$smarty->display('main.tpl');

?>
