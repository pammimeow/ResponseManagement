<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>


<?php
session_start();

$username = $_SESSION['username'];
$formname = $_SESSION['formnameforresp'];

$xml =new SimpleXMLElement("formelems.xml", null, true);
$elems = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/field");

$rxml =new SimpleXMLElement("responses.xml", null, true);
$responses = $rxml->xpath("/responses");
print_r($responses);
$response = $responses[0]->addChild('response');

for($i=0;$i<sizeof($elems);$i++)
{
	$fldname = $elems[$i]->fldname;
	
	if(isset($_POST["".$fldname.""]))
	{
		$val = $_POST["".$fldname.""];
		echo "found ".$fldname;
		
		$field = $response->addChild('field');
		$field->addChild('fname',$fldname);	
		$field->addChild('value',$val);		
	}
}

$rxml->asXML("responses.xml");
?>

</body>
</html>