<?
$db ="sait_consalting";
$user="root";
$pass="";

include 'js/safemysql.class.php';
$db = new SafeMysql(array('user' => $user, 'pass' => $pass,'db' => $db, 'charset' => 'utf8'));


function f_HTML_begin(){
	echo "<META http-equiv='expires' content='0'>
	<META http-equiv='pragma' content='no-cashe'>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
";
}
