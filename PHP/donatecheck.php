<?php 
session_start();
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);
$donationAmount = $_POST['donationAmount'];
$creditcard = $_POST['creditcard'];
$pid = $_POST['pid'];
$username = $_SESSION['username'];

echo 
	"<!DOCTYPE html>  
		 <html lang='en'>
			<style>
			input:hover{
				color: #000; 
			}
			td{
				min-width:100px;
			}
			.postion{
				color:#fff;
				font-family: 'Comic Sans MS', cursive, sans-serif; 
				position: absolute;   
				top: 50%;   
				left:50%;
				margin: -100px 0 0 -200px;
			}
			</style>
			<head>  
				<meta charset='UTF-8'>  
				<title>Donate</title>  
				<link rel='stylesheet' type='text/css' href='style2.css'/>  
			</head>  
			<body> 
				<div class='bg'></div>
				<div class='postion'>  					
					<form method='post' action='project.php'>
						<input type='hidden' name='pid' value='$pid'>
						<table>					
							<tr>
								<h1>";
if($creditcard == null) echo"please select your creditcard!!!";
else if(!is_numeric($donationAmount)) echo"please input correct money!!!";
else {
	$query1 = $conn->query("insert into fund values('$creditcard', '$pid', null, '$donationAmount', 'pending', null)")
	or die("SQL1 Failed");
	echo"Thanks your donation! $username~";	
}
echo"							</h1>								
							</tr>
							<tr>
								<td></td><td><input type = 'submit' class='but-left' name = '#' value = 'back to project' style='cursor:pointer;background-color: transparent; color:#fff;'></td>
							</tr>
						</table>
					</form>
				</div>  
			</body>  
		</html>";	
?>