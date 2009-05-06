<?php
	session_start();
	if(!isset($_SESSION['sendMe']['id'])) {
		header("Location: index.php");
	}
	require('config.php');
	require('functions.php');

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
				
				// Lagra filen i filsystemet
				if(move_uploaded_file($_FILES['uploadFile']['tmp_name'], "uploads/".$name_store)) {
				  
				  // Lagra filen i databasen
				  
					$sql = sprintf("INSERT INTO uppgifter(user_id,name_orig,name_store,file_type,file_size,inlamnad,kurs_id,ip_addr) VALUES('%s','%s','%s','%s','%s','%s','%s','%s')", $user, $name_orig, $name_store, $file_type, $file_size, time(), $kurs_id, $_SERVER['REMOTE_ADDR']);
					mysql_query($sql);
					//$message = $sql;  
			    $message = "Filen ".$name_orig." laddades upp.";
			    unset($_POST);
			    
				} else {
					$message = "Det gick inte att lagra filen, försök igen.";
				}
			} else {
				$message = "Ett fel uppstod när du laddade upp filen, försök igen.";
			}		
		}		
	}
	
	$selectedCourse = $_REQUEST['course'];
	require('top.php');
?>
<h1>SendMe :: Ladda upp</h1>
<p>Här laddar du upp dina uppgifter till SendMe.</p>
<form method='post' action='upload.php' enctype='multipart/form-data'>
<table>
	<tr><td>Kurs:</td><td><select name='course'>
		<option value='0'>Välj kurs..</option>

		<?php
			$kurser = db_get_user_courses($_SESSION['sendMe']['id']);
			for($i = 0; $i < sizeof($kurser); $i++) {
				($kurser[$i]['id'] == $selectedCourse) ? $selected = " selected='selected'" : $selected = '';
				printf("<option value='%s'%s>%s</option>", $kurser[$i]['id'], $selected, $kurser[$i]['namn']);
			}
		?>
</select></td></tr>
	<tr><td>Fil att ladda upp:</td><td><input type='file' name='uploadFile' /></td></tr>
	<tr><td>Kommentar:</td><td><textarea cols='40' rows='10' name='fileComment'><?php if(isset($_POST['fileComment'])) echo $_POST['fileComment']; ?></textarea></td></tr>
	<tr><td>&nbsp;</td><td align='right'><input type='submit' name='submitFile' value='Ladda upp' /></td></tr>
</table>
</form>
