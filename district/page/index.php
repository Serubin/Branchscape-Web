<?php
/*
 * BranchScape - Web
 * Main Page
 * Author: Serubin323 (Solomon Rubin)
 * Version: 2.0
 * 
 *
 * Fill the following with mysql info.
 */
$mysqlHost = "localhost";
$mysqlUser = "root";
$mysqlPassword = "pass";
$mysqlDatabase = "br";

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

 include('../../funcs/login.php');
 
@mysql_connect($mysqlHost,$mysqlUser,$mysqlPassword);
@mysql_select_db($mysqlDatabase);

//Checks for user logon
$userid = status($_COOKIE['LOGGED']);
//Gets username confirms login
if($userid != 0){
	$isLogged = true;
	$username = getUsername($userid);
}

$Auth = array(1,2,3,4);

require_once "../../funcs/template.php";
$pg = new pageTemplate("page.htm");


$pages[]="";
$GET="";
$map="";
$photo="image/default/photo.png";
$banner="";

$sqlGetPage = "SELECT `name` FROM town";
@$resGetPage = mysql_query($sqlGetPage);

if($resGetPage!=false){
	while($row=mysql_fetch_array($resGetPage)) {
		array_push($pages, strtolower($row['name']));
	}
}

if(in_array(strtolower($_GET['p']), $pages))$GET['p']= strtolower($_GET['p']);

if(in_array($GET['p'], $pages))$name = $GET['p'];

if(!$name) header("location:../");

$expire=time()+60*60*24*30;
$newName = $_COOKIE['page'];
$newName = substr_replace($name."-", "",$newName);
$newName = $newName.$name."-";
setcookie("page", $newName, $expire);

/*
 *Creates menus
 */

$menu = '<li><a href="../../">Home</a></li>
<li><a href="../../?p=rules">Rules</a></li>
<li><a href="../../?p=map">Map</a></li>
<li><a href="../../?p=history">History</a></li>
<li><a href="../../?p=residents">Residents</a></li>
<li><a href="../../district/">Towns</a></li>';

if($isLogged){
	$login = '<small>Welcome, <a href="ucp.php?mode=user&id='.$userid.'">'.$username.'</a></small><br /><a href="../../acp.php?mode=towns&p='.$name.'">Edit</a> <a href="../../ucp.php?mode=logout&url=district/page/?p='.$name.'"">Logout</a>';
}
else{
	$login = '<a href="../../ucp.php?mode=login&url=district/page/?p='.$name.'">Login</a>';
}

$sql = "SELECT * FROM town WHERE `name`='". $name . "'";
@$res = mysql_query($sql);
if($res!=false){
	while($row=mysql_fetch_array($res)) {

		$town_name= str_replace("_"," ",$row['name']);
		$coords = explode('-', $row['coord']);
		if($row['banner']=="")$banner="../image/default/banner.png";
		else $banner=$row['banner'];
		if($row['map']=="")$map="../image/default/map.png";
		else $map=$row['map'];
		if($row['picture']=="")$photo="../image/default/photo.png";
		else $photo=$row['picture'];
		$pg->setContent("OWNER","Tanisjihanis, Serubin323, M477");
		$pg->setContent("NAME",$town_name);
		$pg->setContent("DESCRIPTION",$row['description']);
		$pg->setContent("BANNER",$banner);
		$pg->setContent("X_COORD",$coords[0]);
		$pg->setContent("Z_COORD",$coords[1]);
		$pg->setContent("MAP",$map);
		$pg->setContent("MENU",$menu);
		$pg->setContent("LOGIN",$login);
		$pg->setContent("PHOTO",$photo);
		$pg->setContent("FORUM_URL",$row['forum_link']);
		if($isLogged&&in_array($userid, $Auth))$acp = " | <a href='../../acp.php'>Admin Control Panel</a>";
		else $acp = "";
		$pg->setContent("ACP",$acp);
		$pg->sendContent();
	}
}
?>
