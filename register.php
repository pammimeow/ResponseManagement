<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="../../library functions/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>

<body>
<div class = 'smallheader'>
Response Management System
</div> <!-- closed -->

<div class = 'bluemenuelem textcenter'>
<?php
if(isset($_POST['subreg']))
{
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$xml =new SimpleXMLElement("users.xml", null, true);
	
	if($username == "" || $email == "" || $password == "")
	{
		echo "All the fields are essential to be filled in.";
	}
	else if($xml->xpath("/users/user[username='$email']"))
	{
		 echo "User name already exists.";
	}
	else
	{
		echo "Successfully Registered. 
		<a href = 'login.php' class = 'link'><div class = 'margleft yellowbutton'> Login here </div></a>
		";
		
		$users = $xml->xpath("/users");
		$user = $users[0]->addChild('user');
		$user->addChild('userid', uniqid("user"));
		$user->addChild('username', $email);
		$user->addChild('password', $password);
		
		$xml->asXML("users.xml");
		
		$result = mkdir('userdata/'.$email, 0777);
	    $result = mkdir('userdata/'.$email.'/Videos', 0777);
	    $result = mkdir('userdata/'.$email.'/Images', 0777);
	    $result = mkdir('userdata/'.$email.'/docs', 0777);
		$result = mkdir('userdata/'.$email.'/audio', 0777);
		$result = mkdir('userdata/'.$email.'/formlogos', 0777);
	}
}
?>
</div>
<div class = 'graybg wid70 margtop margauto' style='border:1px solid #ddd;'>
<div class = 'bluemenuelem'>Register Below :</div>
<form action = "" method="post">
<div class = 'wid70 margauto margtop'>

<div class = 'wid100 bg1 pad'>
<div class = 'wid50 head3 floatl textcenter'>
 Name <span class = 'highlightred exsmfont'> * </span> :
</div> 
<div class = 'wid50 head3 floatl'>
<input type = 'text' name = 'username' id ='username' size="40">
</div class = 'wid50 head3 floatl'>
<div class = 'clear'> </div>
</div class = 'wid100 margtop bg1'> <!-- section closed -->

<div class = 'wid100 bg1 pad'>
<div class = 'wid50 head3 floatl textcenter'>
 E-Mail Id <span class = 'highlightred exsmfont'> * </span> :
</div> 
<div class = 'wid50 head3 floatl'>
<input type = 'text' name = 'email' id ='email' size="40">
</div class = 'wid50 head3 floatl'>
<div class = 'clear'> </div>
</div class = 'wid100 margtop bg1'> <!-- section closed -->

<div class = 'wid100 bg1 pad'>
<div class = 'wid50 head3 floatl textcenter'>
Password <span class = 'highlightred exsmfont'> * </span> :
</div> 
<div class = 'wid50 head3 floatl'>
<input type = 'password' name = 'password' id ='password' size="40">
</div class = 'wid50 head3 floatl'>
<div class = 'clear'> </div>
</div class = 'wid100 margtop bg1'> <!-- section closed -->

<div class = 'wid100 bg1'>
<div class = 'wid30 head3 floatl textcenter'>
&nbsp;
</div> 
<div class = 'wid50 head3 floatl'>
<input type = 'submit' name = 'subreg' id = 'subreg' class = 'bluebutton' size="40">
</div class = 'wid50 head3 floatl'>
<div class = 'clear'> </div>
</div class = 'wid100 margtop bg1'> <!-- section closed -->


</div class = 'wid 70 margauto'> <!-- container closed -->
</form>
</div>
</body> 
</div>
</body>
</html>