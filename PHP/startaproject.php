<?php
session_start(); 
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);

$username = $_SESSION['username'];
$query=$conn->query("select accountid,creditcard from accountinfo where uname='$username'") 
or die("SQL Failed"); 
?>

<!DOCTYPE html>  
<html lang="en">  
<style>
.postion1{
	position: absolute;   
    top: 50%;   
    left:50%;
	margin: -150px 0 0 -150px;
}

.postion2{
	position: absolute;   
    top: 50%;   
    left:50%;
	margin: -70px 0 0 -255px;
}
</style>
<head>  
    <meta charset="UTF-8">  
    <title>Login</title>  
    <link rel="stylesheet" type="text/css" href="style.css"/>  
</head>  
<body>
	<div class="bg"></div>
    <div id="startaproject">
		<h1 class = "postion1">start a project</h1>  	
		<form class = "postion2" method="post" action="createaproject.php"> 
				<table> 
					<tr> 
						<td ><div align="right">pname:</div></td> 
						<td><input type="text" required="required" name="pname"></td> 
					</tr> 
				<tr> 
					<td><div align="right">minfund:</div></td> 
					<td><input type="text" required="required" name="minfund"></td> 
				</tr> 
				<tr> 
					<td><div align="right">maxfund:</div></td> 
					<td><input type="text" required="required" name="maxfund"></td> 
				</tr> 
				<tr> 
					<td><div align="right">stoptime:</div></td> 
					<td><input type="text" required="required" name="stoptime"></td> 
				</tr> 
				<tr> 
					<td><div align="right">tag1:</div></td> 
					<td><input type="text" required="required" name="tag1"></td> 
				</tr> 
				<tr> 
					<td><div align="right">tag2:</div></td> 
					<td><input type="text" required="required" name="tag2"></td> 
				</tr> 
				<tr> 
					<td><div align="right">discription:</div></td> 
					<td><textarea name="discription" rows = '8' cols = '35'></textarea></td> 
				</tr> 
				<tr> 
					<td><div align="right">creditcard:</div></td> 
					<td>
						<select  name="accountid">  
							<?php
								while($row = $query->fetch_row())
									if ($row[1]!=null)
										echo "<option value='$row[0]'>".$row[1]." </option>";
							?>
						</select>
					</td> 
				</tr> 
				<tr>
					<td></td>
					<td>
					<table align="left" style="margin: 8px"> 
						<tr>
							<td><button class="but" type="submit">Submit</button></td> 
							<td><button class="but" type="reset">Reset</button> </td>	
						</tr> 				
					</table> 
					</td>
				</tr> 
			</table> 

		</form> 
    </div>  
</body>  
</html>  