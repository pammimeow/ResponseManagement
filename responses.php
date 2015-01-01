<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="script.js" type="text/javascript"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript" src="../scripts/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.10.4.custom.min.js"></script>
</head>
<body>

<?php
session_start();
if(!(isset($_SESSION['user'])))
{
	header('Location:login.php');
	//page to go on after login is successfull. 
	$_SESSION['succlogin'] = 'formCreate.php';
}

if(isset($_GET['form']))
{
	$formname = $_GET['form'];
	$mailboxlink = "mailbox.php?formname=".$formname;
}
?>
<a href = 'logout.php'><img src="images/logout.png" style="float:right;margin:1rem;width:3rem;"></a>
<div class = 'exsmsmallheader'>
Response Management System
</div>

<div class = 'wid70 margtop margauto smpad bg1' style="background-color: #117799;
box-shadow: 0.2rem 0.2rem 0rem #F7ED7B;">
<?php 
echo "<div class = 'orangebutton floatl wid25 textcenter'  style='min-height:90px;' onClick=\"showsearchfolders('$formname')\" id = 'savedsearchbox'><img src='images/folder.png' class = 'menuicon'> <div class = 'spreadfont smfont'>Saved Searches</div></div><div id = 'allfolders' class = ''></div>  ";
//<!-- includes the search saved and will retrieve the value based on search, should combine with the current ajax search -->
//username, formname, respid, email, hasreceps, content, startloc
$username = $_SESSION['user'];$respid = "";$email = "";$hasreceps = "true"; $content = ""; $startloc = "";
echo "<div class = 'orangebutton floatl wid25 textcenter' style='min-height:90px;' onClick=\"emailall('$username','$formname')\"> <img src='images/mail.png' class = 'menuicon'> <div class = 'spreadfont smfont'>E - Mail All </div></div>"; 
?>
<div class = 'bg1 floatl wid25 textcenter smpad' style='min-height:90px;' id = 'deletebutt' <?php echo "onClick=\"deleterecordshtml('$formname')\""; ?>><img src='images/deleteicon.png' class = 'menuicon'> <div class = 'spreadfont smfont'> Delete </div></div> 
<?php echo "<div class = 'bg1 floatl wid25 textcenter smpad'  id = 'savesearchbutt' style='min-height:90px;' onClick=\"savefolderhtml('$formname')\"><img src='images/createfoldericon.png' class = 'menuicon'> <div class = 'spreadfont smfont'>Save Search </div></div>";
// <!-- saves a new search and shows its results -->
echo "<div class ='clear'> </div>";
?>
</div>
<div id = 'stopsearch'>
</div>
<div id = 'searchbar'>
</div>
<div id = 'responses'>
</div>
<div class = ''>
&nbsp;
</div>
<script>
var param = "";
var paramorig = "";
var paramnew = "";
function prepsearch(fldname, index)
{
	if(fldname == "useremail")
	{
	document.getElementById("uelem"+index).style.display = "none";
	document.getElementById("useremail"+index).type = "text";
	document.getElementById("usearch"+index).style.display = "inline";
	document.getElementById("uclose"+index).style.display = "inline";
	}
	else {
	document.getElementById(fldname+"elem").style.display = "none";
	document.getElementById(fldname+"input").type = "text";
	document.getElementById(fldname+"search").style.display = "inline";
	document.getElementById(fldname+"close").style.display = "inline"; }
}
function closesearch(fldname, index)
{
	if(fldname == "useremail")
	{
	document.getElementById("uelem"+index).style.display = "inline";
	document.getElementById("useremail"+index).type = "hidden";
	document.getElementById("usearch"+index).style.display = "none";
	document.getElementById("uclose"+index).style.display = "none";
	}
	else {
	document.getElementById(fldname+"elem").style.display = "inline";
	document.getElementById(fldname+"input").type = "hidden";
	document.getElementById(fldname+"search").style.display = "none";
	document.getElementById(fldname+"close").style.display = "none"; }
}
function savesearch(username, formname, fldname, index)
{
	document.getElementById("savesearchbutt").className = "orangebutton floatl wid25 textcenter";
	uncheckall(username, formname);
	console.log("username is "+username+" formname "+formname);
	showstopsearchbutt(username, formname);
	if(fldname == "useremail")
	{ var searchval = document.getElementById("useremail"+index).value;
	  param = param + "&useremail"+index+"="+searchval;
	  paramnew= paramnew + "&useremail"+index+"="+searchval;}
	else {
	var searchval = document.getElementById(fldname+"input").value;
	param = param + "&"+fldname+"="+searchval;
	paramnew= paramnew + "&"+fldname+"="+searchval;  }
	console.log("param is "+param);
	alivebutts();
}
function alivebutts()
{   
	//document.getElementById("savesearchbutt").className = "orangebutton floatl wid25 textcenter";
	document.getElementById("deletebutt").className = "orangebutton floatl wid25 textcenter";     
}
function deactivebutts()
{
	console.log("deactive");
	//document.getElementById("savesearchbutt").className = "bg1 floatl wid25 textcenter smpad";
	document.getElementById("deletebutt").className = "bg1 floatl wid25 textcenter smpad";
}
function showstopsearchbutt(username, formname)
{
  if(document.getElementById("stopsearchbutt") == null)
  {
	  username = username.replace(new RegExp(" ","g"), "_");
	  formname = formname.replace(new RegExp(" ","g"), "_");

	  document.getElementById("stopsearch").innerHTML = "<div class = 'yellowbutton wid20 textcenter margleft' style = 'margin: 0 auto;\
margin-top: 2rem;' onclick = exitsearch('"+username+"','"+formname+"'"+")>Exit search mode </div> <span class = 'clear'></span>";
  }	
}

function exitsearch(username, formname)
{	//console.log("username is "+username+" formname "+formname);
    document.getElementById("savesearchbutt").className = "bg1 smpad floatl wid25 textcenter";
	param = paramorig;
	paramnew = "";
	document.getElementById("stopsearch").innerHTML = "";
    uncheckall(username, formname);
	deactivebutts();
}

function uncheckall(username, formname)
{
   	var paramexit = "op=uncheckall&username="+username+"&formname="+formname;
	console.log("param is "+paramexit);
	ajaxcall("functions.php", paramexit, "", "", "allfolders", false, "");	
}
function savefolderhtml(formname)
{
	var sendparam = paramnew.replace(/&/g, "#");
	var param = "op=getfoldernamedb&sendparam="+sendparam+"&formname="+formname;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Save Search");
	console.log("saving param "+paramnew);
}
function savefolder(formname,param)
{
	//var param = param.replace(/#/g, "&");
    var foldername = document.getElementById("foldername").value;
	param = "op=savefolder&foldername="+foldername+"&sendparam="+param+"&formname="+formname;
	ajaxcall("functions.php", param, "Folder Was Created and Saved.", "", "searchbar", false, "");
	console.log("saving param "+param);
}
window.onload = function()
{
	var filename = "functions.php";
	var winlocation = window.location.href;
	
	var loc = winlocation.split("?");
	console.log("win loc "+loc[1]);
	param = "op=getsearches&"+loc[1];
	ajaxcall(filename, param, "", "", "searchbar", false, "");
	
	var message = "";
	var msglocation = "";
	var contlocation = "responses";
	param = "op=viewresp&"+loc[1];
	paramorig = param;
	//setInterval(function() { 
	ajaxcall(filename, param, message, msglocation, contlocation, false, ""); //}, 1000);
	// setting datepickers. 
	$(".datepicker").datepicker();
	var comps = loc[1].split("&");
	// unchecking all checked checkboxes on page load. 
	var user = comps[0].split("="); user = user[1];
	var form = comps[1].split("="); form = form[1]; 
	uncheckall(user, form);
	document.body.style.height = "4000px";
	}
function showsearch(sendparam)
{
  sendparam = sendparam.replace(/#/g,"&");
  param=paramorig+sendparam;
  paramnew =sendparam;
  console.log("new param is"+param);
}
</script>


<?php

?>


</body>
</html>
