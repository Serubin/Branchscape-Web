<?php
$Auth = array(1,2,3,4);
	if(in_array($userid, $Auth)){
		$title = "Users";	
		$content = "<table id='table'><tr id='tablehead'><th>Name</th><th>Description</th><th>Banner</th><th>Coords</th><th>Forum</th><th>Picture</th><th>Allowed</th><th>Edit</th></tr>";
		@$query = mysql_query("SELECT * FROM town") or die(mysql_error());
		while($row=mysql_fetch_array($query)) {
		//Adds off color to rows
			$classNone = "";
			$classOdd = "class='odd'";
			$counter++;
			$class = ($counter % 2) ? $classOdd : $classNone;
			$content = $content . "<tr " . $class . ">";
			$content = $content . "<td class='name'><a href='district/page/?p=" . $row['name'] . "'>" . $row['name'] . "</a></td>";
			$content = $content . "<td class='desc'>" . substr($row['description'],0,25)."...</td>";
			$content = $content . "<td class='banner'><a href='" . $row['banner'] . "'>" . $row['banner'] . "</a></td>";
			$content = $content . "<td class='coords'>" . $row['coord'] . "</td>";
			$content = $content . "<td class='forum'><a href='" . $row['forum_link'] . "'>http://www.escapecr...</a></td>";
			$content = $content . "<td class='picture'><a href='" . $row['picture'] . "'>" . $row['picture'] . "</a></td>";
			$content = $content . "<td class='allowed'>" . $row['allowed'] . "</td>";
			$content = $content . "<td class='edit'><a href='acp.php?mode=towns&p=".$row['name']."'>Edit</a></td></tr>";
		}
		$content = $content . "</table>";
		$content = $acpMenu . $content;
	} else if(!$_GET['p']){
		header("location:ucp.php?mode=login");
	}
	if($_GET['p']){
		$sqlGetPage = "SELECT `name` FROM town";
		@$resGetPage = mysql_query($sqlGetPage) or die(mysql_error());
		//validate p
		if($resGetPage!=false){
			while($row=mysql_fetch_array($resGetPage)) {
				array_push($pages, strtolower($row['name']));
			}
		}
		print_r($pages);
		if(in_array(strtolower($_GET['p']), $pages))$GET['p']= strtolower($_GET['p']);

		if(in_array($GET['p'], $pages))$name = $GET['p'];
		
		if(!$name) header("location:acp.php?mode=towns");
		$sql = "SELECT * FROM town WHERE `name`='". $name . "'";
		//res for auth
		@$res = mysql_query($sql) or die(mysql_error());
		//resGET for edit items
		@$resGET = mysql_query($sql) or die(mysql_error());
		//Auth check
		if(mysql_num_rows($res)==1){
			$info = mysql_fetch_array($res);
			echo $info['allowed'];
			$AuthId = explode('-', $info['allowed']);
			foreach ($AuthId as $key => $value){
			array_push($Auth, $value);
			}
		}
		//edit area
		if(in_array($userid, $Auth)){
			$content = $content . '<h2>Edit Town Page:'. $name.'</h2>';
			$content = $content . '<a href="acp.php?mode=towns">Close Edit Area</a>';
			$content = $content . '<h4><a href="#edit:help" id="newhelplink" >Help With Titles, Images and Links! [Click Here]<a></h4>
			<div id="newhelp" style="display:none;"> 
			<ul><li>Text: <xmp><p>Your Text</p></xmp></li>
			<li>Images: <xmp><img src="U
			RLTOIMG" /></xmp> Please use imgur to store pictures!</li>
			<li>Links: <xmp><a href="http://YOURLINK.COM">TEXT FOR LINK</a></xmp></li>
			<li>Titles: For large title: <xmp><h1>YOUR TITLE</h1></xmp>For smaller title: <xmp><h2>YOUR TITLE</h2></xmp>title sizes go from 1 - 6, with 1 being the bigest.<xmp><h1> <h2> <h3></xmp> and so on.</p></li>
			<li>HTML WILL WORK IN THESE TEXTS BOXES!</li>
			</ul>
			</div>';
	
			if($resGET!=false){
				while($row=mysql_fetch_array($resGET)) {
					$content = $content . '<form action="funcs/update.php?admin='. $name .'" method="post">';
					$content = $content . '<h3>Edit Description:</h3>';
					$content = $content . '<textarea name="description" cols="100" rows="20">'.stripslashes($row['description']).'</textarea>';
					$content = $content . '<h3>Edit Banner Image:</h3>';
					$content = $content . '<p>Banner must be to BranchScape standards! (ask m477)</p>';
					$content = $content . '<textarea name="banner" cols="50" rows="1">'.stripslashes($row['banner']).'</textarea>';
					$content = $content . '<br />';
					$content = $content . '<h3>Edit Map:</h3>';
					$content = $content . '<p>Map should be taken from <a href="http://www.escapecraft.net/maps/survival/">here</a> Please make sure the map is focused on your townm. For help with this ask Serubin323</p>';
					$content = $content . '<textarea name="map" cols="50" rows="1">'.stripslashes($row['map']).'</textarea>';
					$content = $content . '<br />';
					$content = $content . '<h3>Edit Photo Image:</h3>';
					$content = $content . '<p>Photo should be 400x225px</p>';
					$content = $content . '<textarea name="photo" cols="50" rows="1">'.stripslashes($row['picture']).'</textarea>';
					$content = $content . '<br />';
					$content = $content . '<h3>Edit Forum URL:</h3>';
					$content = $content . '<textarea name="forum_url" cols="50" rows="1">'.stripslashes($row['forum_link']).'</textarea>';
					$content = $content . '<br />';
					$content = $content . '<h3>Edit Coords:</h3>';
					$coords = explode('-', stripslashes($row['coord']));
					$content = $content . '<h3><span>X:</span></h3><textarea name="coord_x" cols="8" rows="1">'.$coords[0].'</textarea>	<h3><span>Z:</span></h3><textarea name="coord_z" cols="8" rows="1">'.$coords[1].'</textarea>';
					$content = $content . '<br />';
					$content = $content . '<input type="submit" name="main_default" value="Change">';
					$content = $content . '</form>';
				}
			}
		} else {
			header("location: acp.php?mode=towns");
		}
	} else {
	}
?>