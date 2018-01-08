<?php 
function checkstr($str) {
	if (inject_check ($str)) {
		die ( 'illegal argument' );
	}
	$str = htmlspecialchars ( $str );
	//转换html
	return $str;
}
function inject_check($sql_str) {
	return eregi ( 'select|inert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile', $sql_str );
	// 进行过滤，防注入
}

session_start();
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);

$pid = $_POST['pid'];
$comment = $_POST['comment'];
$iflike = $_POST['iflike'];
$username = $_SESSION['username'];
$comment = checkstr($comment);

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

$query1 = $conn->query("insert into comments values('$username', null,'$pid', '$comment', '$iflike');")
or die("SQL1 Failed");
echo"Thanks your comment! $username~";	

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