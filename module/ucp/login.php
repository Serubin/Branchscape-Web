<?php
$title = "Login";
	
	if($_POST['username'] !="" || $_POST['password'] != "") {
		$login_status = login($_POST['username'], $_POST['password'], "ucp.php?mode=login&url=".$GET['url']);
	}
	if($login_status == "0"){
		$content =  "<h2 style='color:red;'>Login Failed!</h2>";
	}
	else if($login_status&&$login_status !="0"){
		$content = "You are logged in as<br />";
		$content = $content . $login_status;
		header("location:".$GET['url']);
	}

	if(!$_COOKIE['LOGGED']){
		if(status($_COOKIE['LOGGED'])==0){
			$content = $content . '<form action="ucp.php?mode=login&url='.$GET['url'].'" method="POST">
			Username:<input type=text name=username>
			Password:<input type=password name=password>
			<input type=submit value="Log In">
			</form><br />';
		} 
	} else {
		header("location:".$GET['url']);
	}
?>