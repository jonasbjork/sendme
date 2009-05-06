<?php
// login.php
session_start();
if(isset($_SESSION['sendMe']['id'])) {
    header("Location: index.php");
}
require('config.php');
require('functions.php');
require('smarty/Smarty.class.php');
$smarty = new Smarty;
$smarty->template_dir = '/home/jonas/public_html/sendme/smarty/templates';
$smarty->compile_dir = '/home/jonas/public_html/sendme/smarty/templates_c';
$smarty->cache_dir = '/home/jonas/public_html/sendme/smarty/cache';
$smarty->config_dir = '/home/jonas/public_html/sendme/smarty/configs';


if(isset($_POST['userName'])) {
    $uname = db_clean($_POST['userName']);
    $upass = db_clean($_POST['userPass']);
    $pass = sha1($uname.$upass);
    $sql = "SELECT id, fNamn, eNamn FROM users WHERE epost='$uname' AND password='$pass' AND active='1' LIMIT 1";
    //echo $sql;
    $q = mysql_query($sql);
    if(mysql_num_rows($q) == 1) {
        //echo "Du loggades in.";
        $r = mysql_fetch_array($q);
        $_SESSION['sendMe']['id'] = $r['id'];
        $_SESSION['sendMe']['fullName'] = $r['fNamn']." ".$r['eNamn'];
        header("Location: index.php");
    } else {
        echo "Felaktigt användarnamn eller lösenord, försök igen.";
    }

}
$smarty->display('login.tpl');

?>
