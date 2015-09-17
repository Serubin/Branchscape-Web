<?php
/*
 * Login Script
 * 
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
 
@mysql_connect($mysqlHost,$mysqlUser,$mysqlPassword);
@mysql_select_db($mysqlDatabase);

function login($username, $password, $redirectlink){
	$username = addslashes($username);
	$password = md5($password);
	@$query = mysql_query("SELECT * FROM user_accounts WHERE username='".$username."' AND password='".$password."'") or die(mysql_error());
	if(mysql_num_rows($query)==1){
		$info = mysql_fetch_array($query);
		$userid = $info['userid'];
		$sessionid = md5($userid . time());
		$time = time();
		@setcookie ('LOGGED', $sessionid, $time+3600, '/', '');
		mysql_query("DELETE FROM user_sessions WHERE userid='".$userid."'");
		mysql_query("INSERT INTO user_sessions (sessionid,userid,timestamp) VALUES('".$sessionid."','".$userid."','".$time."')");
		return $userid;
	} else {
		return 0;
	}
	if($rediectlink!=""){
		header("location:".$redirectlink);
	}
}

function logout($redirectlink) {
	$sessionid = $_COOKIE['LOGGED'];
	@setcookie ("LOGGED",'', time()-99999, '/', '');
	header("location:".$redirectlink);
}

function status($sessionidcookie){
	@$query = mysql_query("SELECT * FROM user_sessions WHERE sessionid='".$sessionidcookie."'") or die(mysql_error());
	if(mysql_num_rows($query)==1){
		$info=mysql_fetch_array($query);
		$sessioniddb=$info['sessionid'];
		if($sessioniddb==$sessionidcookie){
			$userid = $info['userid'];
			return $userid;
		}
		else{
			return 0;
		}
	}
	
}

function createAccount($username, $password, $email, $website, $location, $birthday){
	$username = addslashes($username);
	$password = md5($password);
	$return = 1;
	mysql_query("INSERT INTO user_accounts (`username`, `password`, `email`, `birthday`, `website`, `location`) VALUES('".$username."','".$password."','".$email."','".$birthday."','".$website."','".$location."')") or die($return = 0);
	echo "INSERT INTO user_accounts (`username`, `password`, `email`, `birthday`, `website`, `location`) VALUES('".$username."','".$password."','".$email."','".$birthday."','".$website."','".$location."')";
	return $return;
}

function checkUser($username){
	@$query = mysql_query("SELECT * FROM `user_accounts` WHERE `username`='".$username."'") or die(mysql_error());
	if(mysql_num_rows($query)==1){
		$info=mysql_fetch_array($query);
		return $info['userid'];
	}
	return 0;
}

function checkEmail($email){
	@$query = mysql_query("SELECT * FROM user_accounts WHERE email='".$email."'") or die(mysql_error());
	if(mysql_num_rows($query)==1){
		return 1;
	}
	return 0;
}

function getUsername($userid){
	@$query = mysql_query("SELECT * FROM user_accounts WHERE userid='".$userid."'") or die(mysql_error());
	if(mysql_num_rows($query)==1){
		$info=mysql_fetch_array($query);
		return $info['username'];
	}
	return 0;
}

function checkId($userid){
	@$query = mysql_query("SELECT * FROM user_accounts WHERE userid='".$userid."'") or die(mysql_error());
	if(mysql_num_rows($query)==1){
		return 1;
	}
	return 0;
}

function validate($userid, $password){
	$username = addslashes($userid);
	$password = md5($password);
	@$query = mysql_query("SELECT * FROM user_accounts WHERE userid='".$userid."' AND password='".$password."'") or die(mysql_error());
	if(mysql_num_rows($query)==1){
		return 1;
	}
	return 0;
}
function delete($userid){
	mysql_query("DELETE FROM user_accounts WHERE userid='".$userid."'");
	mysql_query("DELETE FROM user_sessions WHERE userid='".$userid."'");
}

?>
