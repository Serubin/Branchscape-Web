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
$mysqlUser = "serubin9_br";
$mysqlPassword = "pass";
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

 include('../funcs/login.php');
 
@mysql_connect($mysqlHost,$mysqlUser,$mysqlPassword);
@mysql_select_db($mysqlDatabase);

//Checks for user logon
$userid = status($_COOKIE['LOGGED']);
//Gets username confirms login
if($userid != 0){
	$isLogged = true;
	$username = getUsername($userid);
}

require_once "../funcs/template.php";
$pg = new pageTemplate("district.htm");


$items[0]="";
$GET="";
$photo="image/default/photo.png";
$banner="";

$GET['search'] = al($_GET['search']);
/*
 *Creates menus
 */
 
$menu = '<li><a href="../">Home</a></li>
<li><a href="../?p=rules">Rules</a></li>
<li><a href="../?p=map">Map</a></li>
<li><a href="../?p=history">History</a></li>
<li><a href="../?p=residents">Residents</a></li>
<li><a href="../district/">Towns</a></li>';
if($isLogged){
	$login = '<small>Welcome, <a href="../ucp.php?mode=user&id='.$userid.'">'.$username.'</a></small><br /><a href="../acp.php?mode=edit">Edit</a> <a href="../ucp.php?mode=logout&url=district/">Logout</a>';
}
else{
	$login = '<a href="../ucp.php?mode=login&url=district/">Login</a>';
}

$search = "";
if($GET['search']){
	$search = "WHERE `name` LIKE '%".$GET['search']."%'";
}

$sql = "SELECT * FROM town " . $search;
@$res = mysql_query($sql);
if($res!=false){
	while($row=mysql_fetch_array($res)) {

		$town_name= str_replace("_"," ",$row['name']);
		if($row['picture']=="")$photo="image/default/photo.png";
		else $photo=$row['picture'];
		$desc = strip_tags($row['description']);
		
		array_push($items,'<td class="item"><a href="page/?p='.$row['name'].'" title="'.$town_name.'"><h2>'.$town_name.'</h2><img src="'.$photo.'" width="200" height="120"/><p>'.substr($desc,0,85).'...</p></a></td>');

	}
}

		$total = count($items);
		for($i = 1; $i != $total; $i++){
			$pg->setContent("ITEM_". $i,$items[$i]);
		}
		//Fills in white space
		for($t = $total; $t != 40; $t++){
			$pg->setContent("ITEM_". $t,'');
		}
$pg->setContent("PICTURE",$photo);
$pg->setContent("OWNERS","Tanisjihanis, Serubin323, M477");
$pg->setContent("MENU",$menu);
$pg->setContent("LOGIN",$login);
$pg->setContent("VIEWED","<p style='border:0px solid #fff;'>Error: 8080</p>");
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
