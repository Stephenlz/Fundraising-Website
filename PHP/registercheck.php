<?php 
function checkstr($str) {
	if (inject_check ($str)) {
		die ( 'illegal argument' );
	}
	$str = str_replace ( "_", "\_", $str );
	//��"_"���˵�
	$str = str_replace ( "%", "\%", $str );
	//��"%"���˵�
	$str = htmlspecialchars ( $str );
	//ת��html
	return $str;
}
function inject_check($sql_str) {
	return eregi ( 'select|insert|update|delete|\_|\%|\'|\/\*|\*|\.\.\/|\.\/|UNION|into|load_file|outfile', $sql_str );
	// ���й��ˣ���ע��
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

// ��Ҫ���ע����û��Ƿ�Ϸ�
// 1. �û��� ���� �ʼ���ʽ�Ƿ�Ϸ�
$username = checkstr($username);
$password = md5($password);
if(!checkemail($email)) die("illegal email!");
// 2. �Ƿ������ͬ�û���
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