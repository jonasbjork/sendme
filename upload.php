<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');
	
	$menu = create_menu($userId);
	$message = "";

	(isset($_REQUEST['course'])) ? $selectedCourse = $_REQUEST['course'] : $selectedCourse = "" ;

	if(isset($_POST['submitFile'])) {
		if($_POST['course'] == 0) {
			$message = "Du måste välja en kurs.";
		} else {
			if($_FILES['uploadFile']['error'] == 0) {
				//TODO: kolla om vi valt en kurs..
				$user = $_SESSION['sendMe']['id'];
				$name_orig = db_clean($_FILES['uploadFile']['name']);
				$name_store = $user."-".time()."_".$name_orig;
				$file_type = db_clean($_FILES['uploadFile']['type']);
				$file_size = db_clean($_FILES['uploadFile']['size']);
				$kurs_id = db_clean($_POST['course']);
				$file_comment = db_clean($_POST['fileComment']);
				
				$checksum = sha1(file_get_contents($_FILES['uploadFile']['tmp_name']));
				$sql = "SELECT id FROM uppgifter WHERE user_id='$user' AND checksum='$checksum' LIMIT 1";
				if(mysql_num_rows(mysql_query($sql)) == 1) {
					$message = "Du har redan laddat upp den filen.";
				} else { 
				
					// Lagra filen i filsystemet
					if(move_uploaded_file($_FILES['uploadFile']['tmp_name'], "uploads/".$name_store)) {
					  
					  // Lagra filen i databasen
						$sql = sprintf("INSERT INTO uppgifter(user_id,name_orig,name_store,file_type,file_size,inlamnad,kurs_id,ip_addr,checksum) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s')", $user, $name_orig, $name_store, $file_type, $file_size, time(), $kurs_id, $_SERVER['REMOTE_ADDR'], $checksum);
						mysql_query($sql);
						//$message = $sql;
						$fileId = mysql_insert_id();
						$sql = "INSERT INTO kommentar(uppgift_id,kommentar,tid,kommentar_av) VALUES('$fileId','$file_comment','".time()."','$userId')";
						mysql_query($sql);
				    $message = "Filen ".$name_orig." laddades upp.";
				    unset($_POST);
					} else {
						$message = "Det gick inte att lagra filen, försök igen.";
					}
				}
			} else {
				$message = "Ett fel uppstod när du laddade upp filen, försök igen.";
			}		
		}		
	}

	$kurser = db_get_user_courses($_SESSION['sendMe']['id']);
	
	(isset($_POST['fileComment'])) ? $fc = $_POST['fileComment'] : $fc = "";

	$smarty->assign('fc', $fc);
	$smarty->assign('kurser', $kurser);
	$smarty->assign('selected', $selectedCourse);
	$smarty->assign('title', "SendMe :: Ladda upp");
	$smarty->assign('userName', $userName);
	$smarty->assign('siteMenu', $menu);
	$smarty->assign('message', $message);
	$smarty->assign('page', "upload");

	$smarty->display('main.tpl');
?>
