<?php
	// functions.php
	
	
	function db_clean($str) {
		$str = trim($str);
		$str = mysql_real_escape_string($str);
		return $str;
	}
	
	function db_check_mailaddr($addr) {
		$sql = "SELECT id FROM users WHERE epost='".db_clean($addr)."' LIMIT 1";
		if(mysql_num_rows(mysql_query($sql)) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Hämta e-postadressen för en användare
	function db_get_mailaddr($user_id) {
		$user_id = db_clean($user_id);
		$sql = "SELECT epost FROM users WHERE id='$user_id' LIMIT 1";
		$r = mysql_fetch_array(mysql_query($sql));
		return $r['epost'];
	}
	
	// Kontrollera om användaren är lärare
	function db_check_larare($user_id) {
		$user_id = db_clean($user_id);
		$sql = "SELECT larare FROM users WHERE id='$user_id' LIMIT 1";
		$r = mysql_fetch_array(mysql_query($sql));
		return $r['larare'];
	}

	// Kontrollera om ett kursnamn redan finns
	function db_check_course_name($str) {
		$str = db_clean($str);
		$sql = "SELECT id FROM kurs WHERE namn='$str' LIMIT 1";
		if(mysql_num_rows(mysql_query($sql)) == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	//Hämta användarnamnet
	function db_get_user_name($id) {
		$sql = "SELECT fNamn, eNamn FROM users WHERE id='$id' LIMIT 1";
		$q = mysql_query($sql);
		if(mysql_num_rows($q) == 1) {
			$r = mysql_fetch_array($q);
			
			$namn = stripslashes($r['fNamn'])." ".stripslashes($r['eNamn']);
			return $namn;
		} else {
			return "Okänd användare";
		}
		
	}
	
	function db_get_course_name($id) {
		$id = db_clean($id);
		$sql = "SELECT namn FROM kurs WHERE id='$id' LIMIT 1";
		$r = mysql_fetch_array(mysql_query($sql));
		return $r['namn'];
	}
	
	function db_get_user_courses($id) {
		$id = mysql_real_escape_string($id);
		$arr = array();
		$i = 0;
		$sql = "SELECT kurs.id AS id, kurs.namn AS namn FROM kurs_user INNER JOIN kurs ON kurs.id=kurs_user.kurs_id WHERE user_id='$id' AND active='1' ORDER BY namn";
		$q = mysql_query($sql);

		if(mysql_num_rows($q) > 0) {
			while($r = mysql_fetch_array($q)) {
				$id = stripslashes($r['id']);
				$namn = stripslashes($r['namn']);
				$arr[$i]['id'] = $id;
				$arr[$i]['namn'] = $namn;
				$i++;
			}
		} else {
			$arr[0]['id'] = 0;
			$arr[0]['namn'] = "Ingen kurs";
		}
		
		return $arr;
	}
	
	function a_show_date($date) {
		//TODO : Ändra så det står idag, igår, ...
		$now = time();
		
		return date("Y-m-d H:i", $date);			
		
	}
	
	function show_date($date)
	{
		$date = date("Y-m-d H:i:s", $date);
		$w = array("sön","mån","tis","ons","tor","fre","lör");
		$m = array("jan","feb","mars","apr","maj","juni","juli","aug","sept","okt","nov","dec");
		$d = "Y-m-d 00:00:00";
		$s = strtotime($date);
		$v = FALSE;
		$k = " kl. ".date("H:i", $s);
		$v = ((!$v) && ($s >= strtotime(date($d)))) ? "Idag".$k.$v : $v;
		$v = ((!$v) && ($s >= strtotime($date($d,mktime(0,0,0,date("m"),date("d")-1,date("Y")))))) ? "Igår".$k.$v : $v;
		$v = (!$v) ? $w[date("w",$s)].chr(32).date("d",$s).chr(32).$m[(date("m", $s)-1)].chr(44).chr(32).date("H:i",$s) : $v;
		
		return $v;
		
	}
	
	function show_filesize($size) {
		
		$s = $size/1024; //KiB
		if($s > 1) {
			$s = $s/1024; //MiB
			if($s > 1) {
				return round((($size/1024)/1024),2)." MiB";
			} else {
				return round(($size/1024),2)." KiB";
			}
		} else {
			return $size." B";
		}		
		
	}
	
	function file_to_icon($file) {
		if($file == "text/html"){
			$icon = "html";
		} else {
			$icon = "unknown";
		}
		return $icon;
	}
	
?>