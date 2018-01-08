<?php 
function checkstr($str) {
	if (inject_check ($str)) {
		die ( 'illegal argument' );
	}
	$str = str_replace ( "_", "\_", $str );
	//把"_"过滤掉
	$str = str_replace ( "%", "\%", $str );
	//把"%"过滤掉
	$str = htmlspecialchars ( $str );
	//转换html
	return $str;
}
function inject_check($sql_str) {
	return eregi ( 'select|insert|update|delete|\_|\%|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile', $sql_str );
	// 进行过滤，防注入
}

function checkemail($str){
	$pattern='/\w+([?+.]\w+)?@\w+([?.]\w+)?\.\w+([?.]\w+)?/';
	if(preg_match($pattern, $str)){
		return true;
	}
	else return false;
}
$conn = new mysqli("localhost", "root","", "db_pro2")
or die("error" . $conn->connect_error);

$username = $_POST['username']; 
$password = $_POST['password'];
$email = $_POST['email'];

// 需要检测注册的用户是否合法
// 1. 用户名 密码 邮件格式是否合法
$username = checkstr($username);
$password = md5($password);
if(!checkemail($email)) die("illegal email!");
// 2. 是否存在相同用户名
$query1 = $conn->query("select * from users where uname = '$username'") 
or die("SQL Failed"); 

if($row = $query1->fetch_row()){
	echo "Same username has existed!";
}
else{
	$query2 = $conn->query("insert into users values('$username','$password',default,'$email',default,default)") 
	or die("SQL Failed");
	echo 
		"<!DOCTYPE html>  
		 <html lang='en'>  
			<head>  
			<meta charset='UTF-8'>  
			<title>Login</title>  
			<link rel='stylesheet' type='text/css' href='style.css'/>  
			</head>  
			<body> 
				<div class='bg'></div>
				<div id = 'suc_re'>  
					<h1>Thank you for register!</h1>  
					<h3><a href = 'login.html'>press this to Sign up</a><h2>				
				</div>  
			</body>  
		</html>";
}


?>