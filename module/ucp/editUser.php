<?php
		if($_POST['newpass']&&$_POST['newpass2']&&$_POST['oldpass']){
			if($_POST['newpass'] == $_POST['newpass2']){
			
				$data = "\"n=".md5($_POST['newpass'])."&o=".md5($_POST['oldpass'])."\"";
			} else {
				$content = $content."<br /> <h2 class='error'>Passwords do not match</h2>";
				$data = "No Data.";
			}
		} else {
			$content = $content."<br /> <h2 class='error'>Please make sure all input fields are filled</h2>";
			$data = "No Data.";
		}
		$title = "Edit Account";
		
		$content = $ucpMenu."<h1> Edit Account </h1>
		<p>To edit info, please pm Serubin323 on the <a href='http://www.escapecraft.com/phpBB3'>Escapecraft Forums</a>.</p>
		<p>To edit your password please run your new and old password through the form belowf and pm Serubin323 the output data. It is an encytped version of your password, and will not be decrypted</p>
		<form action='ucp.php?mode=user&id=".$id."&page=edit' method='post'>
		New Password:<input type='password' name='newpass' />
		Retype New Password:<input type='password' name='newpass2' />
		Old Passoword:<input type='password' name='oldpass' />
		<input type='submit' />
		</form>
		<input onfocus=\"this.select();\" onchange='this.value=\"".$data."\"' style=\"width:500px\" type=\"text\" value='".$data."'>
		";
?>