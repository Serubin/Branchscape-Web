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
$mysqlUser = "root2";
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

include('./funcs/login.php');
 
@mysql_connect($mysqlHost,$mysqlUser,$mysqlPassword);
@mysql_select_db($mysqlDatabase);

//$test = mysql_query("SELECT * FROM `main` LIMIT 1") or die(mysql_error());

//Checks for user logon
$userid = status($_COOKIE['LOGGED']);
//Gets username confirms login
if($userid != 0){
	$isLogged = true;
	$username = getUsername($userid);
}

$Auth = array(1,2,3,4);

$GET="";
$pages[]="";
$name="";
$projects="";
$found="";

require_once "./funcs/template.php";
$pg = new pageTemplate("master.htm");

$sqlGetPage = "SELECT `name` FROM main";
@$resGetPage = mysql_query($sqlGetPage);

if($resGetPage!=false){
	while($row=mysql_fetch_array($resGetPage)) {
		array_push($pages, strtolower($row['name']));
	}
}

if(in_array(strtolower($_GET['p']), $pages))$GET['p']= strtolower($_GET['p']);

if(in_array($GET['p'], $pages))$name = $GET['p'];

if(!$_GET['p'])$name="home";

if(!$name) $name = "home";

/*
 *Creates menus
 */
 
$menu = '<li><a href="?p=home">Home</a></li>
<li><a href="?p=rules">Rules</a></li>
<li><a href="?p=map">Map</a></li>
<li><a href="?p=history">History</a></li>
<li><a href="?p=residents">Residents</a></li>
<li><a href="district/">Towns</a></li>';

/*
 *Lists for home page and residents
 */
 if($name=="home"){
	@$resProjects = mysql_query("SELECT * FROM lists WHERE `name`='projects' AND `page`='home'");
	if(mysql_num_rows($resProjects)==1) {
		$row = mysql_fetch_array($resProjects);
		$projects = $row['text'];
	}
	@$resFound = mysql_query("SELECT * FROM lists WHERE `name`='found' AND `page`='home'");
	if(mysql_num_rows($resFound)==1) {
		$row = mysql_fetch_array($resFound);
		$found = $row['text'];
	}
 }
 if($name=="residents"){
	@$resIntree = mysql_query("SELECT * FROM lists WHERE `name`='intree' AND `page`='residents'");
	if(mysql_num_rows($resIntree)==1) {
		$row = mysql_fetch_array($resIntree);
		$intree = $row['text'];
	}
	@$resPrivate = mysql_query("SELECT * FROM lists WHERE `name`='private' AND `page`='residents'");
	if(mysql_num_rows($resPrivate)==1) {
		$row = mysql_fetch_array($resPrivate);
		$private = $row['text'];
	}
	@$resGround= mysql_query("SELECT * FROM lists WHERE `name`='ground' AND `page`='residents'");
	if(mysql_num_rows($resGround)==1) {
		$row = mysql_fetch_array($resGround);
		$ground = $row['text'];
	}
 } 

if($isLogged){
	$login = '<small>Welcome, <a href="ucp.php?mode=user&id='.$userid.'">'.$username.'</a></small><br /><a href="acp.php?mode=edit&name='.$name.'">Edit</a> <a href="ucp.php?mode=logout&url=index.php?p='.$name.'">Logout</a>';
}
else{
	$login = '<a href="ucp.php?mode=login&url=index.php">Login</a>';
}

$sql = "SELECT * FROM main WHERE `name`='". $name . "'";
@$res = mysql_query($sql);
if($res!=false){
	while($row=mysql_fetch_array($res)) {
		$content = stripslashes($row['content']);
			$content = str_replace("%FOUND%", $found, $content);
			$content = str_replace("%PROJECTS%", $projects, $content);
		
		if($name=="residents"){
			$content = str_replace("%INTREE%", $intree, $content);
			$content = str_replace("%PRIVATE%",$private, $content);
			$content = str_replace("%GROUND%", $ground, $content);
		}

		$pg->setContent("OWNER","Tanisjihanis, Serubin323, M477");
		$pg->setContent("HEAD",stripslashes($row['head']));
		$pg->setContent("TITLE",stripslashes($row['title']));
		$pg->setContent("LOGIN",$login);
		$pg->setContent("MENU",$menu);
		$pg->setContent("CONTENT",$content);
		if($isLogged&&in_array($userid, $Auth))$acp = " | <a href='acp.php'>Admin Control Panel</a>";
		else $acp = "";
		$pg->setContent("ACP",$acp);

	}
}
$pg->sendContent();
?>
