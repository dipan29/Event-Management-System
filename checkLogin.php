<?php
//PLEASE THIS IS A LOGIN CHECK AND COOKIE SCRIPT
//PLEASE DONT MODIFY IT OR REUSE IT
//COPYRIGHTS DIPAN ROY | MIND WEBS TEAM

if(!isset($_SESSION)) {
session_start();
}
include_once '../dbconnect.php'; 

//COOKIE PART

if((isset($_COOKIE["hash"])) && (!isset($_SESSION['usr_id'])) )  { 
	$result = mysqli_query($con, "SELECT * FROM ems_users WHERE login_hash = '" . $_COOKIE["hash"]. "' ");
	if(mysqli_query($con, "UPDATE ems_users SET last_login = now() WHERE login_hash = '" . $_COOKIE["hash"]. "' ")){
		if ($row = mysqli_fetch_array($result)) {
			$_SESSION['usr_id'] = $row['id'];
			$_SESSION['usr_name'] = $row['name'];
			$_SESSION['usr_email'] = $row['email'];
			$_SESSION['usr_time'] = $row['last_login'];
			$_SESSION['usr_phone'] = $row['phone'];
			$_SESSION['usr_gender'] = $row['gender'];
			$_SESSION['usr_dob'] = $row['dob'];
			$_SESSION['usr_type'] = $row['type'];
			
			$_SESSION['usr_type'] = $row['type'];
			
			if(($_SESSION['usr_type'] != 'W')) {
				if(($_SESSION['usr_type'] != 'E')) {
					if(($_SESSION['usr_type'] != 'A')) {
						header("Location: ../accessDenied.php");
					}
				}
			}
		}
		
			
	}

}

//header("Location: index.php");

//REDIRECT PART

if(!isset($_SESSION['usr_id'])!="") {
	header("Location: index");
}


?>