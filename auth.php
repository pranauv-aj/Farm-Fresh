<?php

function genCookie($username,$remember)
{
	$salt = "SDFLAL65832KGDSDA9QK29FVASDL";
	$token = md5($username.$salt.time());
	$createdon = time();
	$conn = mysqli_connect("localhost","root","");
	$query = "INSERT INTO organicfarming.cookietable VALUES('$username','$token','$createdon','$remember');";
	$result = mysqli_query($conn, $query);
	if($result)
	{
		if($remember == 'true') 
		{
			setcookie('username',$username,time()+(60*60*24*5),'/');
			setcookie('token',$token,time()+(60*60*24*5),'/');
		}
		else if($remember == 'false')
		{
			setcookie('username',$username,time()+(60*60*24),'/');
			setcookie('token',$token,time()+(60*60*24),'/');
		}
	}
}
function generateOtp()
{
	return rand(100000,999999);
}
if(isset($_POST["signup"]) AND $_POST["signup"] =="signup")
{
	$username = $_POST["userName"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$phonenumber = $_POST["phoneNumber"];
	$address = $_POST["address"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$country = $_POST["country"];
	$pincode = $_POST["pincode"];
	$otp = generateOtp();
	$conn = mysqli_connect("localhost", "root", "");
	$query = "INSERT INTO organicfarming.user VALUES('$username','$password','$email','$phonenumber','$otp','0','$address','$city','$state','$country','$pincode');";
	$result = mysqli_query($conn, $query);
	if($result)
	{
		header("Location:index.php");
	}
	else
	{
		echo "Failure";
	}
}
if(isset($_POST['login']) AND $_POST['login'] =="login")
{
	$username = $_POST["userName"];
	$password = $_POST["password"];
	if(!isset($_POST["remember"]))
	{
		$remember = 'false';
	}
	else
	{
		$remember = $_POST["remember"];
	}
	echo $remember;
	$conn = mysqli_connect("localhost", "root", "");
	$query = "SELECT * FROM organicfarming.user WHERE userName = '$username' AND password = '$password';";
	$result = mysqli_query($conn,$query);
	if(mysqli_num_rows($result) == 1)
	{
		genCookie($username,$remember);
		header("Location:index.php");
	}
	else
	{
		echo "Login Failure";
	}
}

?>