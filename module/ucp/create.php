<?php
if($isLogged){
	header("location:ucp.php");
}
$username ="";
	echo checkUser($_POST['username']);
	if($_POST['username']){
		if(preg_match('/^[a-zA-Z0-9_]{3,64}$/', $_POST['username'])) {
			if(checkUser($_POST['username'])==0){
			$username = $_POST['username'];
			$uservalidate = true;
			$userreason = "";
			} else {
				$userreason = "taken";
				$uservalidate = false;
				$username = $_POST['username'];
			}
		} else {
			$userreason = "regmis";
			$uservalidate = false;
			$username = $_POST['username'];
		}
	}  else {
		$userreason = "blank";
		$uservalidate = false;
	}
	/*
	 *Validate email
	 */
	$email ="";
	if($_POST['email']){
		if(preg_match("/^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$/", $_POST['email'])){
			if(checkEmail($_POST['email'])==0){
				$email = $_POST['email'];
				$emailvalidate = true;
				$emailreason = "";
			} else {
				$emailreason = "taken";
				$emailvalidate = false;
				$email = $_POST['email'];
			}
		} else {
			$emailreason = "regmis";
			$emailvalidate = false;
			$email = $_POST['email'];
		}
	} else {
		$emailreason = "blank";
		$emailvalidate = false;
	}

	/*
	 *Validate website
	 */
	$website ="";
	if($_POST['website']){
		if(al($_POST['website'])) {
				$website = $_POST['website'];
				$websitevalidate = true;
				$websitereason = "";
		} else {
			$websitereason = "regmis";
			$websitevalidate = false;
			$website = $_POST['website'];
		}
	} else {
		$website = $_POST['website'];
		$websitevalidate = true;
		$websitereason = "";

	}
	
	/*
	 *Validate location
	 */
	$location ="";
	if($_POST['location']){
		if(al($_POST['location'],"1234567890,.")){
				$location = $_POST['location'];
				$locationvalidate = true;
				$locationreason = "";
		} else {
			$locationreason = "regmis";
			$locationvalidate = false;
			$location = $_POST['location'];
		}
	} else {
		$location = $_POST['location'];
		$locationvalidate = true;
		$locationreason = "";
	}


	/*
	 *Validate password
	 */
 
	$password ="";
	$repassword ="";
	if($_POST['password']&&$_POST['repassword']){
		if(preg_match('/^[a-zA-Z0-9_!]{6,32}$/', $_POST['password'])) {
				$password = $_POST['password'];
				$passwordvalidate = true;
				$passwordreason = "";
		} else {
			$passwordreason = "regmis";
			$passwordvalidate = false;
		}
	}  else {
		$passwordreason = "blank";
		$passwordvalidate = false;
	}
	
	/*
	 *Validate birthday
	 */
	 if($_POST['month']!="Month"&&$_POST['day']!="DD"&&$_POST['year']!="YYYY"){
		$birthday = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
	 } else {
		$birthday = "0000-00-00";
	 }
	
	if($_POST['password']&&$_POST['repassword']&&$_POST['email']&&$_POST['username']){
		if($uservalidate==true && $emailvalidate==true && $passwordvalidate==true && $websitevalidate==true && $locationvalidate==true){
			$create_status = createAccount($username, $password, $email, $website, $location, $birthday);
			if($create_status == 0){
				$error = "<h3 style='color:red;'>Could not create account, please contact the website admin!</h3>";
			} else {
				header("location:index.php");
			}
		} else {
			$error="";
			if($userreason=="blank") $error = $error."<h3 style='color:red;'>Username cannot be left blank<br /></h3>";
			else if($userreason=="regmis") $error = $error. "<h3 style='color:red;'>Username must be longer than 3 characters long, and may only be letters, numbers and _<br /></h3>";
			else if($userreason=="taken") $error = $error. "<h3 style='color:red;'>".$_POST['username']." is already taken<br /></h3>";
	
			if($emailreason=="blank") $error = $error. "<h3 style='color:red;'>Email cannot be left blank<br /></h3>";
			else if($emailreason=="regmis") $error = $error. "<h3 style='color:red;'>Email must be a valid email<br /></h3>";
			else if($emailreason=="taken") $error = $error. "<h3 style='color:red;'>".$_POST['email']." is already used<br /></h3>";
	
			if($passwordreason=="blank") $error = $error. "<h3 style='color:red;'>Password cannot be left blank<br /></h3>";
			else if($passwordreason=="mismatch") $error = $error. "<h3 style='color:red;'>Passwords do not match<br /></h3>";
			else if($passwordreason=="regmis") $error = $error. "<h3 style='color:red;'>Password must be longer than 5 characters, and may only be letters, numbers, !, and _<br /></h3>";
			
			if($websitereason=="regmis") $error = $error. "<h3 style='color:red;'>Website must be a valid website<br /></h3>";
			
			if($locationreason=="regmis") $error = $error. "<h3 style='color:red;'>Location must be a valid website<br /></h3>";
		}
	}
	
		$year="<option value=''>YYYY</option>";
		$day="<option value=''>DD</option>";
		for($i=1;$i<=31;$i++)
		{
			$day = $day . '<option value='.$i.'>'.$i.'</option>';
		}
		for($i=1900;$i<=2015;$i++)
		{
			$year = $year . '<option value='.$i.'>'.$i.'</option>';
		}

		$loginForm =  '<form action="ucp.php?mode=create" method="POST">
		Username:<input type="text" name="username" value="'.$username.'" id="username"/><br />
		Email:<input type="text" name="email" value="'.$email.'" id="email"/><br />
		Password:<input type="password" name="password" id="password"/><br />
		Re-Type Password:<input type="password" name="repassword" id="repassword" /><br />
		<br />
		Website:<input type="text" name="website"  value="'.$website.'" /><br />
		Location:<input type="text" name="location"  value="'.$location.'" /><br />
		Birthday:<select name="day">'.$day.'</select>
		<select name="month">
			<option value="">Month</option>
			<option value="01">January</option>
			<option value="02">February</option>
			<option value="03">March</option>
			<option value="04">April</option>
			<option value="05">May</option>
			<option value="06">June</option>
			<option value="07">July</option>
			<option value="08">August</option>
			<option value="09">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
		</select>
		<select name="year">'.$year.'</select>
		<input type="submit" value="Create Account" />
		</form>';
		
		$content = $loginForm.$error;
		$title = "Create Account";
?>