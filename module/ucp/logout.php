<?php
$title = "Logout";
	
	if($GET['url']){
		logout($GET['url']);
	} else {
		logout("index.php");
	}
?>