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
$projects = "<form action='listEdit.php' method='post'><input type='hidden' name='submitted' value='true' />";
	@$resProjects = mysql_query("SELECT * FROM lists WHERE `name`='found' AND `page`='home'");
	$i = 0;
	while($row=mysql_fetch_array($resProjects)) {
		$projects = $projects."<input type='text' size='". strlen($row['text'])."' name='found-".$i++."' value='".$row['text']."'/><br />";
	}
	for($i = $i; $i != 25; $i++){
		$projects = $projects."<input type='text' size='25' name='found-".$i."' value='' id='more' /><br id='more' />";
	}
	echo $projects."<a href='#' id='more-click'/>More</a><br /><input type='submit' value='go' /></form>";
	if($_POST['submitted']){
		mysql_query("DELETE FROM `lists` WHERE `name`='found' AND `page`='home'");
		foreach ($_POST as $key => $value){
			if(substr($key,0,6)=='found-'){
				if($value){
					mysql_query("INSERT INTO `lists` (`name`,`page`,`text`) ('found', 'home', '".$value."')");
				}
			}
		}
	}
?>
