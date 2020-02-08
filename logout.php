<?php
session_start();

include_once '../dbconnect.php';

if(isset($_COOKIE["hash"])) {

if(mysqli_query($con, "UPDATE ems_users SET login_hash = NULL , login_no = 0 WHERE login_no <= 1 AND email = '" . $_SESSION['usr_email']. "'  ")) {
	echo "DONE";
}
if(mysqli_query($con, "UPDATE ems_users SET login_no = login_no - 1 WHERE login_no > 1 AND email = '" . $_SESSION['usr_email']. "'  ")) {
	echo "\nDONE 2";
}

}

if(isset($_SESSION['usr_id'])) {
	session_destroy();	
	setcookie ("hash", '',time()-3600, '/');
	unset($_SESSION['usr_id']);
	unset($_SESSION['usr_name']);
	//unset($_SESSION['usr_class']);
	unset($_SESSION['usr_time']);
	unset($_SESSION['usr_email']);
	unset($_SESSION['usr_phone']);
	unset($_SESSION['usr_gender']);
	unset($_SESSION['usr_dob']);
	unset($_SESSION['usr_type']);
	unset($_SESSION['usr_year']);
	unset($_SESSION['usr_dept']);
	unset($_SESSION['usr_college']);
	header("Location: index");
} 
?>