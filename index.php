<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: login.php");
	}
	require('config.php');
	require('functions.php');

	(isset($_GET['m'])) ? $message = $_GET['m'] : $message = "";
	$smarty->assign('message', $message);
	
	$smarty->assign('userName', $userName);
	$smarty->assign('siteMenu', create_menu($userId));

	$orattadeAntal = 0;
	
	if( db_check_larare($userId) ) {
		$smarty->assign('content', table_att_ratta($userId));
		$smarty->assign('page', "front_teacher");
	} else {
		$smarty->assign('rattade', table_elev_rattade($userId));
		$smarty->assign('orattade', table_elev_orattade($userId));
		$smarty->assign('page', "front_student");
	}
	
	$smarty->display('main.tpl');

?>
