<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class = 'smallheader'>
Response Management System
</div>
<?php
session_start();

if(isset($_POST['login']))
{
	$email = $_POST['email'];
	$pass = $_POST['password'];
		
	$xml =new SimpleXMLElement("users.xml", null, true);
	
	$users = $xml->xpath("/users/user");
	$username = $users[0]->username;
	
	if($xml->xpath("/users/user[username='$email' and password='$pass']"))
	 {
	   $_SESSION['user'] = $email;
	   header('Location:formCreate.php');
	   echo "login found";
	 }
	else
	{
		echo "<div class = 'margtop wid70 margauto error'> Login not found. Try again !!! </div>";
	}
}
?>

<div class = 'graybg wid70 margtop margauto' style='border:1px solid #ddd;'>
<div class = 'bluemenuelem'>Login Below :</div>
<form method="post" action="">
<table border = '0' class = 'margauto' width='60%' style="background-color:#ddd;padding:2rem;">
    <tr> 
      <td width='30%' align="center" style = 'font-weight:bold;color:#117799;'> Email : </td>
      <td width='30%' align="center"> <input type = "text" name = 'email' id = "useremail" size='40' class = 'input'> </td>
    </tr>
    <tr class = 'margtop'>
      <td width='30%' align="center" class = 'smmargtop' style = 'font-weight:bold;color:#117799;'> Password : </td>
      <td width='30%' align="center" class = ''> <input type = "password" name = 'password' id = "userpwd" size='40' class = 'input smmargtop'> </td>
    </tr>
    <tr>
      <td> </td>
      <td> <input type = "submit" name = "login" value = "Login" class = 'orangebutton smmargtop'> </td>
    </tr>
     <tr>
      <td> </td>
      <td> <a class = 'link smmargtop'> Forgot Password </a> </td>
    </tr>
</table>
</form>
</div>

</body>
</html>