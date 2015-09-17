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


$sql = "SELECT * FROM town WHERE `name`='". $_GET['admin'] . "'";
//res for auth
@$res = mysql_query($sql) or die(mysql_error());
//Auth check
if(mysql_num_rows($res)==1){
	$info = mysql_fetch_array($res);
	$AuthId = explode('-', $info['allowed']);
	foreach ($AuthId as $key => $value){
		array_push($Auth, $value);
	}
}

if(in_array($userid, $Auth)){
			
//Updates page for main

$GET['admin']=al($_GET['admin'],"0123456789_-&");

	$description =  addslashes($_POST['description']);
	$banner =  addslashes($_POST['banner']);
	$map =  addslashes($_POST['map']);
	$photo =  addslashes($_POST['photo']);
	$forum_url =  addslashes($_POST['forum_url']);
	$coords =  addslashes($_POST['coord_x']."-".$_POST['coord_z']);	
	$sqlUpdate = "UPDATE `town` SET `description`='". $description."', `picture`='". $photo."', `map`='". $map."', `banner`='". $banner."', `coord`='". $coords."', `forum_link`='". $forum_url."' WHERE `name`='".$GET['admin']."'";
	@$resUpdate = mysql_query($sqlUpdate);
	echo $sqlUpdate;
	header('Location: ../district/page/?p='.$GET['admin']);
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