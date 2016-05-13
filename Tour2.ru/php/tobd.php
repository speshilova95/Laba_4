<?php 
header("Content-Type: text/html; charset=utf-8"); 
session_start();
if ($_SESSION['test'] == md5($_SERVER['REMOTE_ADDR']))  
{
//Объявляем переменные:
$Email = $Pass = $Surname = $Name = $MidName = $City = $Phone = '';
$_SESSION['message'] = ''; 
if(!filter_var($_GET["email"], FILTER_VALIDATE_EMAIL) || check_length($_GET["password"], 4, 18) || check_length($_GET["surname"], 0, 18) || check_length($_GET["name"], 0, 18) || check_length($_GET["middlname"], 0, 18) || check_length($_GET["city"], 0, 18) || check_length($_GET["phone"], 0, 20))	
	{
		$_SESSION['message'] = 'Проверьте правильность введенных данных!';
	}
else
	{
		$Email = clean($_GET["email"]);
		$Pass = clean($_GET["password"]);
		$Surname = clean($_GET["surname"]);
		$Name = clean($_GET["name"]);
		$MidName = clean($_GET["middlname"]);
		$City = clean($_GET["city"]);
		$Phone = clean($_GET["phone"]);		
		mysqli_query(connect(),"INSERT INTO clients (email, password, surname, name, middlename, city, phone)
VALUES ('$Email', '$Pass', '$Surname', '$Name', '$MidName', '$City', '$Phone')");
		$_SESSION['message'] = $Name.' Ваша запись успешно занесена в базу';
	}

}
else {$_SESSION['message'] = 'Доступ закрыт.';}
back();
?>

<?php
function connect() {    
    return mysqli_connect('localhost','root','',"tour");
}
?>

<?php
function back() {
$back = $_SERVER['HTTP_REFERER']; 
echo "
<html>
  <head>
   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
  </head>
</html>";
}
?>

<?php
function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);    
    return $value;
}
?>

<?php
function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return $result;
}
?>