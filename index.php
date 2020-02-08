<?php
session_start();
include_once '../dbconnect.php'; 
 
if(isset($_SESSION['usr_id'])!="") {
	header("Location: home");
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 32; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
$time = date("Y-m-d H:i:s");
$t=time();
$hash = randomPassword();
$key = $hash;
$key.=$t;

//check if form is submitted
if (isset($_POST['login'])) {

	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	
	$result = mysqli_query($con, "SELECT * FROM ems_users WHERE email = '" . $email. "' and password = '" . hash('sha512',$password) . "'");

	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['usr_id'] = $row['id'];
		$_SESSION['usr_name'] = $row['name'];
		$_SESSION['usr_email'] = $row['email'];
		$_SESSION['usr_time'] = $row['last_login'];
		$_SESSION['usr_phone'] = $row['phone'];
		$_SESSION['usr_gender'] = $row['gender'];
		$_SESSION['usr_dob'] = $row['dob'];
		$_SESSION['usr_type'] = $row['type'];
		
		
		
		if(!empty($_POST["remember"])) {
			if($temp_key == NULL){
				if(mysqli_query($con, "UPDATE ems_users SET last_login = '" .$timeNow. "' , login_hash = '" .$key."', login_no = 1 WHERE email = '" . $email. "' and password = '" . hash('sha512',$password) . "' ")){
					setcookie ("hash",$key,time()+ 15552000, '/');	
					}
			
			} else {
				if(mysqli_query($con, "UPDATE ems_users SET last_login = '" .$timeNow. "', login_no = login_no + 1 WHERE email = '" . $email. "' and password = '" . hash('sha512',$password) . "' ")){
					setcookie ("hash",$temp_key,time()+ 15552000, '/');	
				}
			} 
		} else {
				if(mysqli_query($con, "UPDATE ems_users SET last_login = '" .$timeNow. "' WHERE email = '" . $email. "' and password = '" . hash('sha512',$password) . "' ")){		
					echo "Login Success!!! Redirecting in A Moment...";			
				}
			}
		
		header("Location: home");
		
		} else {
		$errormsg = "Incorrect Email or Password!!!";
		?>
        <script>
			alert("You Have Entered An Incorrect Password! Please Try Again") ;
			document.getElementById("loginform").reset();
		</script>
        
        <?php
		
		}
}  // END OF if (isset($_POST['login']))

?>

<html>
	
<head>
	
	<meta charset="utf-8">
	<title>Event Management System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/jpg" href="assets/images/logo.jpg"/>
	<meta name="description" content="Kalyani Government Engineering College Event Management System">
	<meta name="keywords" content="KGEC, EMS, Events, Management, MinD, Webs">
	<meta name="author" content="Dipan Roy">
	<meta property="og:title" content="KGEC EMS">
	<meta property="og:description" content="Kalyani Government Engineering College Event Management System">
	<meta property="og:image" content="http://admin.mindwebs.org/ems/assets/images/logo.jpg">
	<meta property="og:url" content="https://admin.mindwebs.org/ems/">
	
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	
<style>
        body{
        padding-top:4.2rem;
		padding-bottom:4.2rem;
		background:url("assets/images/bg1.jpg");
		background-position: center; /* Center the image */
  		background-repeat: no-repeat; /* Do not repeat the image */
  		background-size: cover; /* Resize the background image to cover the entire container */
        }
        a{
         text-decoration:none !important;
         }
         h1,h2,h3{
         font-family: 'Kaushan Script', cursive;
         }
          .myform{
		position: relative;
		display: -ms-flexbox;
		display: flex;
		padding: 1rem;
		-ms-flex-direction: column;
		flex-direction: column;
		width: 100%;
		pointer-events: auto;
		background-color: #fff;
		background-clip: padding-box;
		border: 1px solid rgba(0,0,0,.2);
		border-radius: 1.1rem;
		outline: 0;
		max-width: 500px;
		 }
         .tx-tfm{
         text-transform:uppercase;
         }
         .mybtn{
         border-radius:50px;
         }
        
         .login-or {
         position: relative;
         color: #aaa;
         margin-top: 10px;
         margin-bottom: 10px;
         padding-top: 10px;
         padding-bottom: 10px;
         }
         .span-or {
         display: block;
         position: absolute;
         left: 50%;
         top: -2px;
         margin-left: -25px;
         background-color: #fff;
         width: 50px;
         text-align: center;
         }
         .hr-or {
         height: 1px;
         margin-top: 0px !important;
         margin-bottom: 0px !important;
         }
         .google {
         color:#666;
         width:100%;
         height:40px;
         text-align:center;
         outline:none;
         border: 1px solid lightgrey;
         }
          form .error {
         color: #ff0000;
         }
         #second{display:none;}	
</style>	
	
</head>

<body>
    <div class="container">
        <div class="row">
			<div class="col-md-5 mx-auto">
			<div id="first">
				<div class="myform form ">
					 <div class="logo mb-3">
						 <div class="col-md-12 text-center">
							<h1>EMS Login</h1>
						 </div>
					</div>
                   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform" id="loginform">
                           <div class="form-group">
                              <label for="exampleInputEmail1">Email address</label>
                              <input type="email" name="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Password</label>
                              <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                           </div>
					   	   <div class="form-group">
                              
                              <input type="checkbox" name="remember" id="remember"> Remember Me ?
                           </div>
                           <div class="form-group">
                              <p class="text-center">By signing up you accept our <a href="#">Terms Of Use</a></p>
                           </div>
                           <div class="col-md-12 text-center ">
                              <input type="submit" name="login" value="LOGIN" class=" btn btn-block mybtn btn-primary tx-tfm">
                           </div>
                           <div class="col-md-12 ">
                              <div class="login-or">
                                 <hr class="hr-or">
                                 <span class="span-or">or</span>
                              </div>
                           </div>
                           <div class="col-md-12 mb-3">
                              <p class="text-center">
                                 <a href="javascript:void();" class="google btn mybtn"><i class="fa fa-google-plus">
                                 </i> Signup using Google
                                 </a>
                              </p>
                           </div>
                           <div class="form-group">
                              <p class="text-center">Don't have account? <a href="#" id="signup">Sign up here</a></p>
                           </div>
					   		<div class="form-group">
                              <center><span>&copy; 2019 KGEC | <a href="https://mindwebs.org" id="systems">MinD Webs</a> System</span></center>
                           </div>
                        </form>
                 
				</div>
			</div>
			  <div id="second">
			      <div class="myform form ">
                        <div class="logo mb-3">
                           <div class="col-md-12 text-center">
                              <h1 >Signup</h1>
                           </div>
                        </div>
                        <form action="#" name="registration">
                           <div class="form-group">
                              <label for="exampleInputEmail1">First Name</label>
                              <input type="text"  name="firstname" class="form-control" id="firstname" aria-describedby="emailHelp" placeholder="Enter Firstname">
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Last Name</label>
                              <input type="text"  name="lastname" class="form-control" id="lastname" aria-describedby="emailHelp" placeholder="Enter Lastname">
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Email address</label>
                              <input type="email" name="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Password</label>
                              <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                           </div>
                           <div class="col-md-12 text-center mb-3">
                              <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Get Started For Free</button>
                           </div>
                           <div class="col-md-12 ">
                              <div class="form-group">
                                 <p class="text-center"><a href="#" id="signin">Already have an account?</a></p>
                              </div>
                           </div>
                            </div>
                        </form>
                     </div>
			</div>
		</div>
      </div>   
         
</body>
	
</html>