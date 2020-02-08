<?php

	include_once '../dbconnect.php';
	
	$id = $_GET['id'];
	
	$result = mysqli_query($con,"SELECT * FROM ems WHERE ticket_id='".$id."' ");
	
	if($result->num_rows > 0)
	{
		$res = $result->fetch_assoc();
		$myJson = json_encode($res);
		echo $myJson;
	}
	else 
		echo "NO DATA FOUND";

?>

<?php
		///////////////////////////////////////////////////////////////
		//TAKE TICKET ID, GENERATE QR CODE
		//SAVE QR CODE TO FOLDER AS <TICKETID>.JPG
		//INSERT INTO DATABASE (QR_CODE) the <TICKETID>
		 
		//QR CODE LINK = "admin.mindwebs.org/sccripts/qrGetData.php?id=<TicketID>
		
		//SCRIPT FOR qrGetData.php
		
		/*
		Take Ticket ID from $_GET[];
		GET ROW FROM THE DATABASE WHERE ticket_id =<TicketID>
		then encode row into JSON Object
		
		Echo <JSON OBJECT>
		*/
?>