<?php
$Auth = array(1,2,3,4);
	if(in_array($userid, $Auth)){
		$title = 'Edit';
		$sqlGetPage = "SELECT `name` FROM lists";
		@$resGetPage = mysql_query($sqlGetPage);

		//Select page
		$content = $content . '<h1>Select Page</h1>';
		$content = $content . "<form method='get' action='acp.php'>";
		$content = $content . "<input type='hidden' name='mode' value='" . $GET['mode'] . "'>";
		$content = $content . "<select name='name'>";
		if($resGetPage!=false){
			while($row=mysql_fetch_array($resGetPage)) {
				$content = $content . "<option value='".$row['name']."'>". $row['name'] ."</option>";
			}
		}
		$content = $content . "</select>";
		$content = $content . "<input type='submit' value='Select Page'>";
		$content = $content . "</form>";
		$content = $content . '<h4><a href="#edit:help" id="newhelplink" >Help With Titles, Images and Links! [Click Here]<a></h4>
		<div id="newhelp" style="display:none;"> 
		<ul><li>Images: <xmp><img src="U
		RLTOIMG" /></xmp> Please use imgur to store pictures!</li>
		<li>Links: <xmp><a href="http://YOURLINK.COM">TEXT FOR LINK</a></xmp></li>
		<li>Titles: For large title: <xmp><h1>YOUR TITLE</h1></xmp>For smaller title: <xmp><h2>YOUR TITLE</h2></xmp>title sizes go from 1 - 6, with 1 being the bigest.<xmp><h1> <h2> <h3></xmp> and so on.</p></li>
		<li>HTML WILL WORK IN THESE TEXTS BOXES!</li>
		</ul>
		</div>';
		$page = al($_GET['name']);
		//form for page update
		$sql = "SELECT * FROM lists WHERE name='".$page."'";
		@$res = mysql_query($sql);
		if($res!=false){
			while($row=mysql_fetch_array($res)) {
				$title = 'Edit '.$page;
				$content = $content . '<form action="funcs/update_lists.php?admin='. $page .'" method="post">';
				$content = $content . '<textarea name="content" cols="110" rows="40">'.stripslashes($row['text']).'</textarea>';
				$content = $content . '<br />';
				$content = $content . '<input type="submit" name="main_default" value="Change">';
				$content = $content . '</form>';
			}
		}
		$content = $acpMenu . $content;
	} else {
		header("location:ucp.php?mode=login");
	}
?>