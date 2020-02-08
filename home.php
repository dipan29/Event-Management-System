<?php
session_start();
include_once '../dbconnect.php';

if(isset($_GET['status'])) {
	if($_GET['status']=='RS') {
		?>
		<script>
			alert("Registration Sucessful!");
		</script>	
		<?php
	}
	
}

include 'checkLogin.php';
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Event Management System</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/jpg" href="assets/images/logo.jpg"/>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		
<!--		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css">
		
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
	</head>

	<body>
			
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <img src="assets/images/logo.png" width="30" height="30" alt=""><a class="navbar-brand" href="#">KGEC EMS</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
			  <li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="attend">Attend</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="logout">Logout</a>
			  </li>
			</ul>
		  </div>
		</nav>
		<br /><br />
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<h3>Events Management System</h3>
					<p>Register a New Ticket ID or Check Existing Ticket IDs</p>
				</div>
			</div>
			<br />
			
			<div class="row">
				<div class="col-lg-6 col-sm-12">
					<h5 class="text-center">Register a New Participant</h5><br/>
					
					<form name="register" method="post" action="pRegister">
						<div class="form-group">
							<label>Select Event Name : </label>
							<select name="event_id" class="form-control">
								<option value="KE00">FB Build Day'19</option>
							</select>							
						</div>	
						<div class="form-group">
							<label>Name : </label>
							<input type="text" placeholder="Enter Participant's Name" class="form-control" name="name" id="name" required>
						</div>
						<div class="form-group">
							<label>Email Address : </label>
							<input type="email" placeholder="Enter Participant's Email ID" class="form-control" name="email" id="email" required>
						</div>
						<div class="form-group">
							<label>Phone Number : (without +91)</label>
							<input type="text" placeholder="Enter Participant's Phone Number" class="form-control" name="phone" id="phone" required maxlength="11">
						</div>
						
						<div class="form-group">
							<center>
							<input type="submit" class="btn btn-warning" name="register" value="Register">
								&nbsp;&nbsp;
							<input type="reset" class="btn btn-danger" value="Reset">
							</center>	
						</div>
					</form>
					
					
				</div>
				<div class="col-lg-6 col-sm-12" style="overflow-x: auto">
					<h5 class="text-center">Participants List</h5><br />
					
					<table id="myTable" class="ui celled table" style="width:100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Registered</th>								
							</tr>
						</thead>
						<tbody>
					<?php $query = mysqli_query($con, "SELECT * FROM ems");
						if($query->num_rows > 0){
							while($row = $query->fetch_assoc()){
								?>
								<tr>
									<td><?php echo $row['ticket_id'] ; ?></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['phone']; ?></td>
									<td><?php echo substr($row['registered'],0,10); ?></td>
								</tr>
								<?php
							}	
						}		
					?>	
						</tbody>
						
						<tfoot>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Registered</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		
	<br /><br />
	<!-- Footer -->
	<div class="container">
		
		<footer class="page-footer font-small" style="position: fixed; left: 0; bottom: 0; background-color: azure; width: 100%;text-align: center;">
			
		  <!-- Copyright -->
		  <div class="footer-copyright text-center py-3">© 2019 Confidential Copyrights
			<a href="https://mindwebs.org"> MinD Webs</a> Systems
		  </div>
		  <!-- Copyright -->

		</footer>	
	</div>
		
		<script>
		$(document).ready( function () {
			$('#myTable').DataTable();
		} );
		</script>
	</body>
</html>