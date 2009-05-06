<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');
	$rattadeAntal = 0;
	$orattadeAntal = 0;

	$sql = "SELECT name_orig,inlamnad,namn FROM uppgifter INNER JOIN kurs ON uppgifter.kurs_id=kurs.id WHERE user_id='$userId' AND rattad='0' ORDER BY inlamnad DESC";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		while($r = mysql_fetch_array($q)) {
			$orattade[] = $r;
			$orattadeAntal++;
		}
	} else {
		$orattade[] = "";
	}
	$sql = "SELECT uppgifter.id AS id, uppgifter.name_orig AS name, uppgifter.inlamnad AS inlamnad, uppgifter.betyg AS betyg, uppgifter.rattad AS rattad, users.fNamn AS fnamn, users.eNamn AS enamn, kurs.namn AS kursnamn  FROM uppgifter RIGHT JOIN kurs ON kurs.id=uppgifter.kurs_id RIGHT JOIN users ON users.id=rattad_av WHERE user_id='$userId' AND rattad='1' AND kurs.active='1' ORDER BY uppgifter.inlamnad DESC";
	$q = mysql_query($sql);
	if(mysql_num_rows($q) > 0) {
		while($r = mysql_fetch_array($q)) {
			$rattade[] = $r;
			$rattadeAntal++;
		}		
	} else {
		$rattade[] = "";
	}

	$smarty->assign('orattade', $orattade);
	$smarty->assign('orattadeAntal', $orattadeAntal);
	$smarty->assign('rattade', $rattade);
	$smarty->assign('rattadeAntal', $rattadeAntal);
	$smarty->assign('message', $message);
	$smarty->assign('userName', $userName);
	$smarty->assign('siteMenu', create_menu($userId));
	$smarty->assign('title', "SendMe :: Mina resultat");
	$smarty->assign('page', "results_student");

	$smarty->display('main.tpl');

?>
