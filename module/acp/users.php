<?php
$Auth = array(1,2,3,4);
	if(in_array($userid, $Auth)){
		$title = "Users";	
		if($userid == 1){
			$delete = "<th>Delete</th>";
		} else $delete = "";
		$content = "<table id='table'><tr id='tablehead'><th>#</th><th>Username</th><th>Email</th><th>Birthday</th><th>Location</th><th>Website</th><th>Joined</th>".$delete."</tr>";
		@$query = mysql_query("SELECT * FROM user_accounts ORDER BY userid ASC") or die(mysql_error());
		while($row=mysql_fetch_array($query)) {
		//Adds off color to rows
			$classNone = "";
			$classOdd = "class='odd'";
			$counter++;
			$class = ($counter % 2) ? $classOdd : $classNone;
			$content = $content . "<tr " . $class . ">";
			$content = $content . "<td class='id'>" . $row['userid'] . "</td>";
			$content = $content . "<td class='username'><a href='ucp.php?mode=user&id=" . $row['userid'] . "'>" . $row['username'] . "</a></td>";
			$content = $content . "<td class='email'>" . $row['email'] . "</td>";
			$content = $content . "<td class='birthday'>" . $row['birthday'] . "</td>";
			$content = $content . "<td class='location'>" . $row['location'] . "</td>";
			$content = $content . "<td class='website'><a href='" . $row['website'] . "'>" . $row['website'] . "</a></td>";
			$content = $content . "<td class='joined'>" . $row['joined'] . "</td>";
			if($userid == 1){
				$content = $content . "<td><form action='acp.php' method='POST'><input 
				type=\"hidden\" name=\"delete\" value=\"" . $row['userid'] . "\"><input 
				type=\"submit\" value=\"Delete\"></form></td>";
				$content = $content . "</tr>";
			}
		}
		$content = $content . "</table>";
		$content = $acpMenu . $content;
	} else {
		header("location:ucp.php?mode=login");
	}
?>