<?php
ob_start();
/*
 *
 * Fill the following with mysql info.
 */
$mysqlHost = "localhost";
$mysqlUser = "serubin9_br";
$mysqlPassword = "Password";
$mysqlDatabase = "serubin9_br";

/*
 * The following should not be touched unless you know what your doing
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
 
@mysql_connect($mysqlHost,$mysqlUser,$mysqlPassword);
@mysql_select_db($mysqlDatabase);


include("login.php");

$Auth=array(1,2,3,4);

$userid = status($_COOKIE['LOGGED']);
//Gets username confirms login
if($userid != 0){
	$isLogged = true;
	$username = getUsername($userid);
}

if(in_array($userid, $Auth)){

//Updates page for main

	$content =  addslashes($_POST['content']);
	$GET['admin'] = substr(al($_GET['admin'],"0123456789_"),0,16);
	$sqlUpdate = "UPDATE `lists` SET `text`='". $content."' WHERE `name`='".$_GET['admin']."'";
	@$resUpdate = mysql_query($sqlUpdate) or die(mysql_error());
	echo $sqlUpdate;
	header('Location: ../acp.php?mode=lists&name='.$_GET['admin']);
}

function al($a="") {

  /*****[ © Rich Innovations ]*******************************************************************************

	This strips all non-alphabetic characters from $a. If you want to keep extra characters, then include
	a second parameter with each character you want kept.

	Required Functions: NONE


	- $a		= String to be stripped.

  **********************************************************************************************************/

  $extra = "";
  if (func_num_args() >= 2) $extra = func_get_arg(1);
  $temp = "";
  $aln = "abcdefghijklmnopqrstuvwxyz".$extra;
  for ($b=0;$b<strlen($a);$b++) {
    $temp2 = substr($a,$b,1);
    if (stristr($aln,$temp2)) {
      $temp .= $temp2;
    }
  }
  return $temp;
}
ob_end_flush();
?>