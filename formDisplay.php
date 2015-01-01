<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="script.js" type="text/javascript"></script>
</head>

<body>
<?php
session_start();

include_once('includeFunctions.php');

if(isset($_GET['user']) && isset($_GET['form']))
{ $_SESSION['fduser'] = $username = $_GET['user'];
  $_SESSION['fdform'] = $formname = $_GET['form']; }
else if(isset($_SESSION['fduser']) && isset($_SESSION['fdform']))
{ $username = $_SESSION['fduser'];
  $formname = $_SESSION['fdform']; }
else { echo "<div class = 'feedback'> Insufficient information provided for form. Please try again by copying the complete URL </div>"; }

$xml =new SimpleXMLElement("formelems.xml", null, true);
if($xml->xpath("/elems/users/user[username='$username']/compname") && $xml->xpath("/elems/users/user[username='$username']/logopath"))
{
	$compname = $xml->xpath("/elems/users/user[username='$username']/compname");  
    $compname = (string)$compname[0]; 
	
	$logopath = $xml->xpath("/elems/users/user[username='$username']/logopath");  
    $logopath = (string)$logopath[0]; 	
	
	  
	echo "<div class = 'wid100 smpad'><div class = 'wid10 floatl'><img src = '$logopath' width = '100px' height = '100px'></div>";
	echo "<div class = 'wid80 smpad floatl'>
	      <div class = 'wid100 smmargtop'><h1>$compname</h1></div>";
    if($xml->xpath("/elems/users/user[username='$username']/tagline"))
	{ $tagline = $xml->xpath("/elems/users/user[username='$username']/tagline");  
      $tagline = (string)$tagline[0]; 
	  echo "<div class = 'wid100'>$tagline</div>";
	}
	echo "</div>
		  <div class = 'clear'> </div>
		  </div>";
}
else {
echo "<div class = 'smallheader'>
Response Management System
</div>";
}


if(isset($_GET['error']))
{
	$errorrep = $_SESSION['errorrep'];
	$errorrep = str_replace("'", "#",$errorrep);
	echo "<div class = 'wid100 menuelem' style='margin:2rem;border:1px dashed #f00;'> Response was not submitted. Please check the error report. <span class = 'errorbutton alink' onclick = \"showerror('$errorrep')\">Error Report </span></div>";
	$_SESSION['errorrep'] = "";
}
else if(isset($_GET['success']))
{
	echo "<div class = 'wid100 menuelem' style='margin:2rem;border:1px dashed #0f0;'>Response Submitted <img src='images/selecten.png' class = 'menuicon' style = 'margin-left:2rem;'></div>";
}

dispformfields($formname, $username, 'fd');
//sendemail(username, formname, respid, email, hasreceps, content, startloc)
?>
<?php 
  $xml =new SimpleXMLElement("formelems.xml", null, true);
  if($xml->xpath("/elems/users/user[username='$username']/email"))
  { $email = $xml->xpath("/elems/users/user[username='$username']/email");  
    $email = (string)$email[0];
  }
  else
  { $email = "";}
echo "<div class = 'wid100 bg1 textcenter smpad margtop alink' onclick = \"sendformdispemail('$username','$formname', '','$email','','','')\">"; 
echo "Send a message / disfunctionality report to owner.
</div>";

if($xml->xpath("/elems/users/user[username='$username']/blogaddress"))
{ $blogadd = $xml->xpath("/elems/users/user[username='$username']/blogaddress");  
    $blogadd = "http://".(string)$blogadd[0]; 
echo "<div class = 'wid100 textcenter feedback'><a href = '$blogadd' class = 'alink whitefont'> Visit Blog  </a> </div>";
}
?>
<script type="text/javascript" src="../scripts/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.10.4.custom.min.js"></script>

<script>
window.onload = function()
{
	$( ".datepicker" ).datepicker();
}
</script>
</body>
</html>