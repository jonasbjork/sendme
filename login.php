<?php
// login.php
session_start();
if(isset($_SESSION['sendMe']['id'])) {
    header("Location: index.php");
}
require('config.php');
require('functions.php');

if(isset($_POST['userName'])) {
    $uname = db_clean(strtolower($_POST['userName']));
    $upass = db_clean($_POST['userPass']);
    $pass = sha1($uname.$upass);
    $sql = "SELECT id, fNamn, eNamn FROM users WHERE epost='$uname' AND password='$pass' AND active='1' LIMIT 1";
    
    //echo $sql;
    $q = mysql_query($sql);
    if(mysql_num_rows($q) == 1) {
        $r = mysql_fetch_array($q);
        $_SESSION['sendMe']['id'] = $r['id'];
        $_SESSION['sendMe']['fullName'] = $r['fNamn']." ".$r['eNamn'];
        header("Location: index.php");
    } else {
        $error = "Felaktigt användarnamn eller lösenord, försök igen.<br /><a href='forgotpass.php'>Har du glömt ditt lösenord?</a>";
    }

}
if(isset($error)) {
	$smarty->assign('error', $error);
}
$smarty->display('login.tpl');

?>
