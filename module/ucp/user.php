<?php
	if($GET['id']){
		if(checkId($GET['id'])) $id = $GET['id'];
		$head = '<link rel="stylesheet" type="text/css" href="css/ucp.css" />';
		$query = mysql_query("SELECT * FROM `user_accounts` WHERE userid=".$id) or die(mysql_error());
		if($userid == $id){
			$ucpMenu = "<div class='buttons'><a href='ucp.php?mode=user&id=".$id."' class='button big left $active-overview'>Overview</a><a href='ucp.php?mode=user&id=".$id."&page=edit' class='button big middle $active-edit'>Edit</a><a href='ucp.php?mode=user&id=".$id."&page=pages' class='button big middle $active-pages'>Pages</a><a href='ucp.php?mode=user&id=".$id."&page=more' class='button big right $active-more'>More</a></div><br />";
		} else {
			$ucpMenu = "";
		}
		if(!$GET['page']){
			if(mysql_num_rows($query)==1){
				$info=mysql_fetch_array($query);
				$title = getUsername($id);
				$content = $ucpMenu."<h1>" . getUsername($id) . "</h1>
							<p>Birthday: <span>".$info['birthday']."</span></p>
							<p>Joined: <span>".date("M - d - Y",strtotime($info['joined']))."</span></p>
							<p>Website: <span><a href='".$info['website']."'>".$info['website']."</a></span></p>
							<p>Location: <span>".$info['location']."</span></p>";
			}
		} else if($GET['page']==strtolower("edit")){
			if(mysql_num_rows($query)==1){
				include('editUser.php');
			}
		} else if($GET['page']==strtolower("pages")){
			if(mysql_num_rows($query)==1){
				$content = $ucpMenu . "<h1>Not avalible at this time.</h1>";
			}
		} else if($GET['page']==strtolower("more")){
			if(mysql_num_rows($query)==1){
				$content = $ucpMenu . "<h1>There is not more at this moment.</h1>";
			}
		}
	} else {
		header("location:ucp.php");
	}
?>