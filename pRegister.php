<?php
session_start();
include_once '../dbconnect.php';

require "vendor/autoload.php";
	
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

$event_id = mysqli_real_escape_string($con, $_POST['event_id']);

$event_name = "Facebook Dev Build Day";

$myemail = "notification@mindwebs.org";
$AdminMail = "dipan.roy@kgec.edu.in";

function randomNo6() {
    $alphabet = '1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$no = randomNo6();

$ticket_id = $event_id.$no;

if(isset($_POST['register'])) {
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$phone = mysqli_real_escape_string($con, $_POST['phone']);	
	
	//Create QR Code against name TICKETID.JPG and save that to mindwebs.org/qrCodes/ (../qrCodes/)
	$ticket_qr = $ticket_id.".png";	
	$qrText = "https://admin.mindwebs.org/ems/qrGetData.php?id=".$ticket_id;
	
	$qrCode = new QrCode($qrText);
	$qrCode->setLabel($event_name, 14, __DIR__.'/assets/fonts/Quicksand-Regular.otf', LabelAlignment::CENTER);
	$qrCode->writeFile(__DIR__.'/../../qrCodes/'.$ticket_qr);
	
	//END OF QR CODE GENERATION
		
	$result = mysqli_query($con, "INSERT INTO ems(event_id,ticket_id,name,email,phone,registered,qrCode) VALUES('".$event_id."','".$ticket_id."','".$name."','".$email."','".$phone."','".$timeNow."','".$ticket_qr."')");
	
	if($result){
		
		//USER MAIL

		$email_subject = $event_name." Registration";
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Create email headers
		$headers .= 'From: K G E C <'.$myemail. '>'."\r\n".
			'Reply-To: '.$myemail."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			
		$email_body = '<html>';
		$email_body .= '<head>
						<style>
						.myButton {
							background-color:#e02919;
							-moz-border-radius:28px;
							-webkit-border-radius:28px;
							border-radius:28px;
							border:1px solid #d02718;
							display:inline-block;
							cursor:pointer;
							color:#ffffff;
							font-family:Arial;
							font-size:17px;
							padding:16px 31px;
							text-decoration:none;
							text-shadow:0px 1px 0px #810e05;
						}
						.myButton:hover {
							background-color:#f24437;
						}
						.myButton:active {
							position:relative;
							top:1px;
						}
						.myButton2 {
							background-color:#007dc1;
							-moz-border-radius:28px;
							-webkit-border-radius:28px;
							border-radius:28px;
							border:1px solid #124d77;
							display:inline-block;
							cursor:pointer;
							color:#ffffff;
							font-family:Arial;
							font-size:17px;
							padding:16px 31px;
							text-decoration:none;
							text-shadow:0px 1px 0px #154682;
						}
						.myButton2:hover {
							background-color:#0061a7;
						}
						.myButton2:active {
							position:relative;
							top:1px;
						}
						
						</style>
						</head>';
		$email_body .= '<body>';
		$email_body .= '<img src="https://mindwebs.org/img/fbdevkgecemail.png" width="100%" alt="Facebook Dev Build KGEC 2019">';
		//$email_body .= '<center><h1 style="color:blue !important" >MinD Webs</h1></center>' . "<br><br>";
		$email_body .= "<h4><strong>Hello ".$name.",</strong></h4>";
		$email_body .= "<p>We are glad to let you know that, you have successfully passed the evaluation for Facebook Build Day Participation. Here are the necessary details. See you on Aug 16!</p>";
		$email_body .= "Your Ticket ID / QR Code is as follows, please show this at the time of entry<br><br>";
		$email_body .= '<center><div style="margin:2px; padding:3px; max-width:300px"><img src="http://mindwebs.org/qrCodes/'.$ticket_qr.'" height="100%" width="100%" alt="Your QR Code"></div></center>';
		$email_body .= "<center><h2>".$ticket_id."</h2></center><hr>";
		//////////////////////////////////////////////////////////////
		$email_body .= '<p><strong>Event Details : </strong> 16-17 Aug | 11 AM - 4 PM'. "</p>"; 
		$email_body .= '<p><strong>Location : </strong> KGEC Seminar Hall' . "</p>"; 
		
		$email_body .= '<p>You should also register in Facebook\'s Platform. Go to the following site, hit on RSVP and Fill up the necessary details. Enter Role - "Member" and Organization - "Developers Club KGEC"</p>';
		$email_body .= '<center><a class="myButton2" style="color:white !important" href="https://facebookbuilddayinkalyani.splashthat.com">Confirm Ticket Here</a></center>';
		
		//$email_body .= '<br/><center>All Rights Reserved. (C) KGEC 2019</center>';
		
		$email_body .= '<br><hr><p>This mail was sent to you by &copy; <a href="https://mindwebs.org">MinD Webs Systems</a></p><p style="font-size:10px;">All Rights Reserved. (C) KGEC 2019</p>';
		$email_body .= '<p style="font-size: 10px;">For any queries or request, please mail to contact@mindwebs.org</p>';
		$email_body .= '</body></html>';

		mail($email,$email_subject,$email_body,$headers);
		
		//ADMIN MAIL
		/*
		$email_subject2 = "MinD Webs : ".$event_name." Registration";
		
		// To send HTML mail, the Content-type header must be set
		$headers2  = 'MIME-Version: 1.0' . "\r\n";
		$headers2 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Create email headers
		$headers2 .= 'From: M W <'.$myemail. '>'."\r\n".
			'Reply-To: '.$email."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			
		$email_body2 = '<html><body>';
		$email_body2 .= '<center><h1 style="color:blue !important" >MinD Webs</h1></center>' . "<br><br>";
		$email_body2 .= "Techtronista 2K19 Registration<br><br>";
		$email_body2 .= "Ticket ID";
		$email_body2 .= "<h3>".$ticket_id."</h3><br>";
		$email_body2 .= '<p>Registration Details : </p>';
		$email_body2 .= '<p><strong>Name : </strong>'.$name. "</p>"; 
		$email_body2 .= '<p><strong>Email : </strong>'.$email. "</p>"; 
		$email_body2 .= '<p><strong>Phone : </strong>'.$phone. "</p>"; 
		$email_body2 .= '<p><strong>Ticket Price : </strong> '.$finalPrice. "</p><br>"; 		
		$email_body2 .= '<p><strong>Address : </strong>'.$address. "</p>";
		$email_body2 .= '<p><strong>Current Status : </strong>'.$work." at " .$work_at . "</p>";
		$email_body2 .= '<p><strong>Any Previous Experience : </strong>'.$previous. "</p>";  
		$email_body2 .= '<p style="color:red"><strong>Referral Code : </strong>'.$referred. "</p>";
		$email_body2 .= 'Time : '. $timeNow  . "<br><br>";
		
		$email_body2 .= '<br><hr><p>&copy;<a href="$siteLink">MinD Webs</a></p><p style="font-size:10px;">All Rights Reserved.</p>';
		$email_body2 .= '<p style="font-size: 10px;">For any queries or request, please mail to administrator@mindwebs.org</p>';
		$email_body2 .= '</body></html>';

		mail($AdminMail,$email_subject2,$email_body2,$headers2);
		*/
		//SUCCESS MSG COOKIE
		$url = "home.php?status=RS";
		
	} else{
		//ERROR COOKIE
		$error = "Could Not Complete the Same, Please Re-Try!";
		setcookie("msg_errror", $error, time()+45, '/');
		$url = $_SERVER['HTTP_REFERER'];
	}
	header('Location: ' . $url);
	//GO BACK GET METHOD TICKET ID
}



?>