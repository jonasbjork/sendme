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
		$sql = "SELECT kurs.id AS id, kurs.namn AS namn FROM kurs_user INNER JOIN kurs ON kurs.id=kurs_user.kurs_id WHERE user_id='$id' AND kurs.active='1' ORDER BY namn";
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
		$v = ((!$v) && ($s >= strtotime(date($d,mktime(0,0,0,date("m"),date("d")-1,date("Y")))))) ? "Igår".$k.$v : $v;
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
		} else if($file == "text/x-java") {
			$icon = "java";
		} else {
			$icon = "unknown";
		}
		return $icon;
	}

	function create_menu($id) {
		$r = "<div id='siteMenu'>\n";
		$r .= "<ul>\n";
		$r .= "<li><a href='index.php'>Start</a></li>\n";
		$r .= "<li><a href='courses_student.php'>Mina kurser</a></li>\n";
		$r .= "<li><a href='results_student.php'>Mina resultat</a></li>\n";
		$r .= "<li><a href='upload.php'>Ladda upp</a></li>\n";
		$r .= "<li><a href='settings.php'>Mina inställningar</a></li>\n";
		if(db_check_larare($id)) {
			$r .= "<li><a href='courses_teacher.php'>Hantera kurser</a></li>\n";
		}
		$r .= "<li><a href='logout.php'>Logga ut</a></li>\n";
		$r .= "</ul>\n";
		$r .= "</div>\n";
		return $r;
	}


	function create_h2($text) {
		return "<h2>$text</h2>\n";
	}

	function table_att_ratta($id) {
		$ret = "";
		$id = db_clean($id);
		$sql = "SELECT id, namn FROM kurs WHERE skapad_av='".$id."' AND active='1' ORDER BY namn";
		$q = mysql_query($sql);
		if(mysql_num_rows($q) > 0) {
			$ret .= "<table border=0 style='width: 100%'>\n";
			while($r = mysql_fetch_array($q)) {
				$s = "SELECT * FROM uppgifter WHERE kurs_id='".$r['id']."' AND rattad='0' ORDER BY inlamnad DESC";
				$qu = mysql_query($s);
				if(mysql_num_rows($qu) > 0) {
					$ret .= "<tr><th colspan='6' style='width: 100%; background-color: #ccc; text-align: left'><strong>".$r['namn']."</strong></th></tr>";
	
					while($row = mysql_fetch_array($qu)) {
						$file_url = $row['inlamnad']."-".$row['name_orig'];
						$ret .= sprintf("<tr><td><img src='icons/%s.gif' style='width: 20px'/></td><td><a href='showfile.php?file=%s'>%s</a></td><td>%s</td><td class='right'>%s</td><td class='right'>%s</td><td class='right'><a href='getfile.php?file=%s'><img src='icons/download.gif' title='Hämta' alt='Hämta' style='border: 0; width: 20px' /></a></td></tr>", file_to_icon($row['file_type']), $file_url, $row['name_orig'], db_get_user_name($row['user_id']), show_filesize($row['file_size']), show_date($row['inlamnad']), $file_url);
					}
				}
			}
			$ret .= "</table>\n";
		} else {
			$ret .= "<p>Du har inga kurser upplagda än.</p>";
		}
		return $ret;
	}
	
	function table_elev_orattade($id) {
		$ret = "";
		$id = db_clean($id);
		$sql = "SELECT name_orig,inlamnad,namn FROM uppgifter INNER JOIN kurs ON uppgifter.kurs_id=kurs.id WHERE user_id='$id' AND rattad='0' ORDER BY inlamnad DESC LIMIT 10";
		$q = mysql_query($sql);
		if(mysql_num_rows($q) > 0) {
			$col = 0;
			$ret .= "<table id='tblOrattade'>\n";
			while($r = mysql_fetch_array($q)) {
				($col%2) ? $backcol = "#eee" : $backcol = "#ccc";
				$col++;
				$ret .= sprintf("<tr style='background-color: %s'><td>%s</td><td>%s</td><td>%s</td></tr>\n", $backcol, $r['namn'], $r['name_orig'], show_date($r['inlamnad']));
			}
			$ret .= "</table>\n";
			$ret .= "<p>Tabellen ovanför visar dina senaste 10 inskickade uppgifter som ännu inte rättats. När din lärare har rättat uppgiften kommer den att hamna i tabellen ovanför <em>Dina rättade uppgifter</em> där du också kommer se vilket omdöme uppgiften fick.</p>";
		} else {
			$ret .= "<p>Du har inga orättade uppgifter.</p>";
		}
		return $ret;
	}

	function table_elev_rattade($id) {
		$ret = "";
		$id = db_clean($id);
		$sql = "SELECT name_orig,inlamnad,namn,betyg FROM uppgifter INNER JOIN kurs ON uppgifter.kurs_id=kurs.id WHERE user_id='$id' AND rattad='1' ORDER BY inlamnad DESC LIMIT 5";
		$q = mysql_query($sql);
		if(mysql_num_rows($q) > 0) {
			$ret .= "<table id='tblRattade'>\n";
			$col = 0;
			while($r = mysql_fetch_array($q)) {
				($col%2) ? $backcol = "#eee" : $backcol = "#ccc";
				$col++;
				$ret .= sprintf("<tr style='background-color: %s'><td>%s</td><td>%s</td><td>%s</td><td align='right'>%s</td></tr>\n", $backcol, $r['namn'], $r['name_orig'], show_date($r['inlamnad']), show_betyg($r['betyg']));
			}
			$ret .= "</table>\n";
			$ret .= "<p>Det är bara dina senaste fem rättade uppgifter som visas i tabellen ovanför. För att se alla uppgifter går du till <a href='results_student.php'>Mina resultat</a>.</p>";
		} else {
			$ret .= "<p>Du har inga rättade uppgifter.</p>";
		}
		return $ret;
	}
	
	function show_betyg($b) {
		switch($b) {
			case 1:
				return "<div class='ig'>IG</div>";
				break;
			case 2:
				return "<div class='g'>G</div>";
				break;
			case 3:
				return "<div class='g'>VG</div>";
				break;
			case 4:
				return "<div class='g'>MVG</div>";
				break;
			default:
				return "<div class='ig'>--</div>";
			}
		}
		
	
?>
