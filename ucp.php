<?php
/*
 * Branchscape - Web
 * User Control Panel
 * Version: 2.0
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
 
 //Var
 $login="";
 $head="";
 $title="";
 $menu="";
 $content="";
 $userid="";
 $isLogged="";
 $username="";
 $GET[]="";
 $menu = '<li><a href="index.php">Home</a></li>
<li><a href="index.php?p=rules">Rules</a></li>
<li><a href="index.php?p=map">Map</a></li>
<li><a href="index.php?p=history">History</a></li>
<li><a href="index.php?p=residents">Residents</a></li>
<li><a href="district/">Towns</a></li>';

require_once "./funcs/template.php";
$pg = new pageTemplate("master.htm");

include('./funcs/login.php');

//Checks for user logon
$userid = status($_COOKIE['LOGGED']);
//Gets username confirms login
if($userid != 0){
	$isLogged = true;
	$username = getUsername($userid);
}

//Checks inputs
$GET['mode'] = al($_GET['mode']);
if($_GET['url']){
	$GET['url'] = al($_GET['url'],"./-1234567890_?=&%");
	$GET['url'] = str_replace("34%","&",$GET['url']);
} else {
	$GET['url'] = "index.php";
}
$GET['id'] = floor(abs($_GET['id']));
$GET['page'] = $_GET['page'];

//Creates Login
if($isLogged){
	$login = '<small>Welcome, <a href="ucp.php?mode=user&id='.$userid.'">'.$username.'</a></small><br /><a href="acp.php?mode=edit">Edit</a> <a href="ucp.php?mode=logout">Logout</a>';
}
else{
	$login = '<a href="ucp.php?mode=login&url=ucp.php?'.$currUrl.'">Login</a>';
}
if(!$GET['mode']){
/*
 *Mode: None
 */
	if($isLogged){
		header("location: ucp.php?mode=user&id=".$userid);
	} else {
		header("location: ucp.php?mode=login");
	}
	
} else if($GET['mode']==strtolower("logout")){
/*
 * Mode: logout
 */
	include("module/ucp/logout.php");
} else if($GET['mode']==strtolower("login")){
/*
 * Mode: login
 */
	include("module/ucp/login.php");

} else if($GET['mode']==strtolower("user")){
/*
 * Mode: user
 */
	include("module/ucp/user.php");
	
} else if($GET['mode']==strtolower("create")){
/*
 *Mode: Create
 */
	include("module/ucp/create.php");
	
} else {
/*
 *Mode: Else
 */
	$title = "General Error";
	$content = "<h1 class='error'>General Error, Module not accessible</h1>";
}

$pg->setContent("OWNER","Tanisjihanis, Serubin323, M477");
$pg->setContent("HEAD",$head);
$pg->setContent("TITLE",$title);
$pg->setContent("LOGIN",$login);
$pg->setContent("MENU",$menu);
$pg->setContent("CONTENT",$content);
if($isLogged&&in_array($userid, $Auth))$acp = " | <a href='acp.php'>Admin Control Panel</a>";
else $acp = "";
$pg->setContent("ACP",$acp);
$pg->sendContent();


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
?>