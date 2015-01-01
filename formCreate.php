<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="../scripts/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>

<body>
<!-- In this file we will create a form using which user can enter data and create his customised form -->
<a href = 'logout.php'><img src="images/logout.png" style="width:5rem;float:right;margin:1rem;box-shadow: 0rem 0rem 0.5rem #9C3F3F;
margin-top: 1.2rem;"></a>
<div class = 'smallheader'>
Response Management System
</div> <!-- closed -->


<div class = 'bodysec'> <!-- complete body without header -->
<div class = 'menu'>    <!-- left menu section -->
<div class = 'bluemenuelem'>
Form Options
</div class = 'bluemenuelem margtop'> <!-- closed bluemenuelem margtop-->
<div class = 'orangemenuelem bg2'>
<a href = "formCreate.php?form=new" class = 'link'>New Form</a>
</div class ='orangemenuelem orgdiffshadebg' > <!-- closed orangemenuelem orgdiffshadebg-->

<div class = 'orangemenuelem bg2'>
<a href = "formCreate.php?credentials" class = 'link' onClick="getcredentials()"> Global Credentials </a>
</div class = 'orangemenuelem orgdiffshadebg'> <!-- closed orangemenuelem orgdiffshadebg-->

<div class = 'bluemenuelem margtop'>
All Forms
</div class = 'bluemenuelem margtop'> <!-- closed bluemenuelem margtop-->

<!-- *****  bodysec and menu unclosed -->

<?php
session_start();

// session new will always hold a value of formname if the new form is created and a name is given to it. It releases its value only on delete form and finalise form. 

include_once('includeFunctions.php');

if(!(isset($_SESSION['user'])))
{
	header('Location:login.php');
	//page to go on after login is successfull. 
	$_SESSION['succlogin'] = 'formCreate.php';
}

// load all the form names from the xml file. 
$xml =new SimpleXMLElement("formelems.xml", null, true);
$username = $_SESSION['user'];

if($xml->xpath("/elems/users/user[username='$username']/form"))
{
	$elems = $xml->xpath("/elems/users/user[username='$username']");
  	$forms = $elems[0]->form;
	
	for($i=0;$i<sizeof($forms);$i++)
	{
	  $formname = $forms[$i]->formname;	
	  echo "<div class = 'menuelem'><a href = 'formCreate.php?form=$formname' class = 'link'>".$formname."</a></div>";  // div closed
	}
	
}
else
{
  echo "<div class = 'menuelem'>No forms added</div>";	// ### styling to be done
}

?>

<div> <!-- menu class closed -->
</div class = 'bluemenuelem margtop 2'> <!-- bluemenuelem margtop 2 closed -->
</div class = 'bluemenuelem margtop 1'> <!-- bluemenuelem margtop 1 closed -->


<!-- *** bodysec unclosed -->
<div class = 'content'>   <!-- right section of the page -->

<?php
if(isset($_GET['credentials']))
{
// html for show credentials content
$xml =new SimpleXMLElement("formelems.xml", null, true);
$compname = "";
$tagline = "";
$blogaddress = "";
$logopath = "";
$email = "";

if($xml->xpath(	"/elems/users/user[username='$username']"))
{
	if($xml->xpath("/elems/users/user[username='$username']/compname"))
	{
	$user = $xml->xpath("/elems/users/user[username='$username']");
	$compname = $user[0]->compname;
	$tagline = $user[0]->tagline;
	$blogaddress = $user[0]->blogaddress;
	$logopath = $user[0]->logopath;
	$email = $user[0]->email;
	}
}
?>





<form action='filehandle.php' method="post" enctype="multipart/form-data">
<div class = 'feedback wid100'> Global Credentials </div>
<div class = 'wid100 margtop bg1 pad'>
<div class = 'head3 wid30 floatl'> Company Name <span class = 'highlightred exsmfont'>*</span></div>
<div class = 'wid50 floatl'> 
<?php
if($compname != "")
{
	$previd = "prevcompname";
	$nextid = "nextcompname";
	$closeidval = "closecompname";
	echo "<div class = 'head3 wid70 floatl' id = '$previd'> $compname </div>
	<input type = 'hidden' id = 'compname' name = 'compname' value = '$compname'> 
	<span style='display:none;' onclick = \"restorecrededit('compname')\" id = '$closeidval'><img src='images/closeicon.jpg' class='icon'></span>
	<div class = 'wid10 floatl' onClick=\"editcred('compname')\" id = '$nextid'><img src ='images/edit.png' class = 'icon'></div>
  <div class = 'clear'> </div>	
  </div>";
}
else
{
	echo "<input type = 'text' id = 'compname' name = 'compname'> </div>";
}
?>
<div class = 'clear'> </div>
</div> <!-- closed wid100 margtop bg1 pad -->


<div class = 'wid100 smmarg bg1 pad'>
<div class = 'head3 wid30 floatl'> E Mail Address : <span class = 'highlightred exsmfont'>*</span></div>
<div class = 'wid50 floatl'> 

<?php
if($email != "")
{
	$previd = "prevemail";
	$nextid = "nextemail";
	$closeidval = "closeemail";
	echo "<div class = 'head3 wid70 floatl' id = '$previd'> $email </div>
	<input type = 'hidden' id = 'email' name = 'email' value = '$email'> 
	<span style='display:none;' onclick = \"restorecrededit('email')\" id = '$closeidval'><img src='images/closeicon.jpg' class='icon'></span>
	<div class = 'wid10 floatl' onClick=\"editcred('email')\"><img src ='images/edit.png' class = 'icon' id = '$nextid'></div>
  <div class = 'clear'> </div>	
  </div>";
  
}
else
{
	echo "<input type = 'text' id = 'email' name = 'email'> </div>";
}
?>
<div class = 'clear'> </div>
</div> <!-- closed wid100 smmarg bg1 pad -->


<div class = 'wid100 smmarg bg1 pad'>
<div class = 'head3 wid30 floatl'> Tagline </div>
<div class = 'wid50 floatl'> 

<?php
if($tagline != "")
{
	$previd = "prevtagline";
	$nextid = "nexttagline";
	$closeidval = "closetagline";
	echo "<div class = 'head3 wid70 floatl' id = '$previd'> $tagline </div>
	<input type = 'hidden' id = 'tagline' name = 'tagline' value = '$tagline'> 
	<span style='display:none;' onclick = \"restorecrededit('tagline')\" id = '$closeidval'><img src='images/closeicon.jpg' class='icon'></span>
	<div class = 'wid10 floatl' onClick=\"editcred('tagline')\"><img src ='images/edit.png' class = 'icon' id = '$nextid'></div>
  <div class = 'clear'> </div>	
  </div>";
  
}
else
{
	echo "<input type = 'text' id = 'tagline' name = 'tagline'> </div>";
}
?>

<div class = 'clear'> </div>
</div> <!-- closed wid100 smmarg bg1 pad -->


<div class = 'wid100 smmarg bg1 pad'>
<div class = 'head3 wid30 floatl'> Blog Address </div>
<div class = 'wid50 floatl'> 

<?php
if($blogaddress != "")
{
	$previd = "prevblogaddress";
	$nextid = "nextblogaddress";
	$closeidval = "closeblogaddress";
	echo "<div class = 'head3 wid70 floatl' id = '$previd'> $blogaddress </div>
	<input type = 'hidden' id = 'blogaddress' name = 'blogaddress' value = '$blogaddress'> 
	<span style='display:none;' onclick = \"restorecrededit('blogaddress')\" id = '$closeidval'><img src='images/closeicon.jpg' class='icon'></span>
	<div class = 'wid10 floatl' onClick=\"editcred('blogaddress')\"><img src ='images/edit.png' class = 'icon' id = '$nextid'></div>
  <div class = 'clear'> </div>	
  </div>";
  
}
else
{
	echo "<input type = 'text' id = 'blogaddress' name = 'blogaddress'> </div>";
}
?>
<div class = 'clear'> </div>
</div> <!-- closed wid100 smmarg bg1 pad -->


<div class = 'wid100 smmarg bg1 pad'>
<div class = 'head3 wid30 floatl'> Logo </div>
<div class = 'wid50 floatl'> 
<?php

if($logopath != "")
{
	$previd = "prevlogoimg";
	$nextid = "nextlogoimg";
	$closeidval = "closelogoimg";
	
	$size = getimagesize($logopath);
	$width = $size[0];
	$height = $size[1];
	
	if($width > $height)
	{
	   $ratio = $width/$height;	
	   $width = $ratio * 50;
	   $height = 50;
	}
	else if($height > $width)
	{
	   $ratio = $height/$width;	
	   $height = $ratio * 50;
	   $width = 50;
	}
	else
	{
	   $height = 50;
	   $width = 50;
	}
	
	$width = $width ."px";
	$height = $height."px";
	echo "<div class = 'head3 wid70 floatl' id = '$previd'> <img src = '$logopath' style='width:$width; height:$height;'> </div>
	<input type = 'file' id = 'logoimg' name = 'logo' style='display:none;'> 
	<span style='display:none;' onclick = \"restorecrededit('logoimg')\" id = '$closeidval'><img src='images/closeicon.jpg' class='icon'></span>
	<div class = 'wid10 floatl' onClick=\"editcred('logoimg')\"><img src ='images/edit.png' class = 'icon' id = '$nextid'></div>
  <div class = 'clear'> </div>	
  </div>";
}
else
{
	echo "<input type = 'file' id = 'logo' name = 'logo'> </div>";
}
?>

<div class = 'clear'> </div>
</div> <!-- closed wid100 smmarg bg1 pad -->

<div class = 'wid100 smmarg bg1 pad'>
<div class = 'head3 wid30 floatl'> Theme Color </div>
<div class = 'wid50 floatl'> 

</div>

<div class = 'clear'> </div>
</div> <!-- closed wid100 smmarg bg1 pad -->

<input type = 'submit' name = 'savecred' class = 'yellowbutton textcenter wid30 smmarg'value = 'Save'>
<input type = 'hidden' name = 'location' value = 'formCreate.php?credentials'>
</form>
<!-- content class unclosed -->
<?php	
}
else
{










	
/* start of content other than credentials */
?>

<div class = 'menuelem wid100 '>
<div class = 'menuelem floatl wid70'>Give me a Form name and start adding fields to it : </div> <!-- closed -->
<div class = 'helpicon floatl wid10 margleftmid orgdiffshadebg' onclick = help()>?</div> <!-- closed -->
<div class = 'clear'></div> <!-- closed -->
</div> <!-- parent outer menuelem wid100 -->


<div class = 'inputcont bg1'>
<div class = 'wid100 bg1'>

<div class = 'feedback wid100 '>
<div class = 'floatl wid70'>Form Information : </div> <!-- closed -->
<div class = 'helpicon floatl wid10 margleftmid orgdiffshadebg' onclick = help()>?</div> <!-- closed -->
<div class = 'clear'></div> <!-- closed -->
</div> <!-- parent outer menuelem wid100 -->
 
<div class = 'wid100 bg1 pad'>
<div class = 'head3 wid30 floatl'>
Form Name <span class = 'highlightred exsmfont'> * </span> : 
</div>  <!-- close of head3 wid30 floatl last up-->
<?php
if(!(isset($_SESSION['formname'])))
{
	$_SESSION['formname'] = "new";
}

if(isset($_GET['form']))
{
	if($_GET['form'] == "new")
	{
		$_SESSION['formname'] = "new";
	}
	else
	{
		$_SESSION['formname'] = $_GET['form'];
	}
}

if($_SESSION['formname'] == "new")
{

?>

<div class = 'wid50 floatl' id = 'formnamecont'>
 <input type = 'text' name = 'formname' size="40" id = 'formname' 
  class = 'textfld'> </div>

<?php
}
else
{
	echo "<div class = 'smheader wid50 floatl pad'>".$_SESSION['formname']."</div>";
}
?>
<div class = 'clear'> </div> <!-- div clear for form name -->

<?php
if($_SESSION['formname'] == "new") {
echo "<input type = 'submit' name = 'subformname' name = 'subformname' value = 'Save Form' onClick='subformname()' class = 'bluebutton simpleshadow'>"; }
?>
</div> <!-- close of form name wid100 bg1 pad -->
</div><!-- wid100 margtop bg1 up section closed -->
</div> <!-- close of inputcont -->


<div class = 'feedback wid100 margtop'>
<div class = 'floatl wid70'>Add Fields To Your Form : </div> <!-- closed -->
<div class = 'helpicon floatl wid10 margleftmid orgdiffshadebg' onclick = help()>?</div> <!-- closed -->
<div class = 'clear'></div> <!-- closed -->
</div> <!-- parent outer menuelem wid100 -->

<div class = 'section bg1 pad' id = 'fldcontent'>
<form method="post" action="formCreate.php">

<div class = 'wid100 smmargtop'>
<div class = 'head3 floatl wid50'> Field Name ?: </div> 
<div class = 'input floatl wid50'>
<input type = 'text' name = 'fname'  size="40" class = 'textfld' onFocus="focusme()" onBlur="blurme()" id = 'fldname'>
</div>
<div id= 'fldnameerr' class = 'error'></div>
<div class = 'clear'></div>
</div>


<!-- For text type  -->
<div class = 'wid100 smmargtop'>
<div class = 'head3 floatl wid50'> Field Type ? :  </div> 
<div class = 'input floatl wid50'>
<ul class = 'optmenu' name = "ftype">
<li class = 'mainmenu'> <span  id = "fldtyperep" name = "hello"> Text Box </span> <img src="images/downarrow.jpg" class = 'righticon'>
<input type="hidden" name = 'ftype' id = 'ftypeval' value = "text">
<ul class = 'submenu'>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('textbox')"> Text Box </li>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('selbox')"> Select Box </li>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('radio')"> Radio Buttons </li>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('check')"> Check Boxes </li>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('datep')"> Date Picker </li>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('image')"> Image </li>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('tdesc')"> Text Description </li>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('doc')"> Document </li>
</ul>
</li>
</ul>

</div>
<div class = 'clear'></div>
</div>



<div id = 'textwrap' class = "hide">
<!-- For text field selected -->
<div class = 'wid100 smmargtop' id = "textkind">
<div class = 'head3 floatl wid50'> Text Kind ?: </div> 
<div class = 'input floatl wid50'>
<ul class = 'optmenu'>
<li class = 'mainmenu'> <span id = "textwraprep"> Characters  </span> <img src="images/downarrow.jpg" class = 'righticon'>
<ul class = 'submenu'>
<input type = "hidden" name = "texttype" id = "texttype" value ="chars" >
<li class = 'submenui' onclick = "shownewfields('chars')"> Characters </li>
<li class = 'submenui' onclick = "shownewfields('nums')"> Numbers </li>
</ul>
</li>
</ul>

</div>
<div class = 'clear'></div>
</div>

<div id = 'textops'>
<!-- For characters input selected -->
<div class = 'wid100 smmargtop hide' id = "texttemp">
<div class = 'head3 floatl wid50'> Text Template : </div> 
<div class = 'input floatl wid50'>

<ul class = 'optmenu'>
<li class = 'mainmenu'> <span id = "texttemprep"> Other </span> <img src="images/downarrow.jpg" class = 'righticon'>
<ul class = 'submenu'>
<input type="hidden" name = 'chartype' id = 'chartype' value = "textother">
<li class = 'submenui' onclick = "shownewfields('email')"> E - Mail Address </li>
<li class = 'submenui' onclick = "shownewfields('address')"> Address </li>
<li class = 'submenui' onclick = "shownewfields('textother')"> Other </li>
</ul>
</li>
</ul>

</div>
<div class = 'clear'></div>
</div>


<!-- For numbers input selected -->
<div class = 'wid100 smmargtop hide' id = "numtemp">
<div class = 'head3 floatl wid50'> Numbers Template : </div> 
<div class = 'input floatl wid50'>

<ul class = 'optmenu'>
<li class = 'mainmenu'> <span id = "numtemprep"> Select </span> <img src="images/downarrow.jpg" class = 'righticon'>
<ul class = 'submenu'>
<input type="hidden" name = 'numtype' id = 'numtype'>
<li class = 'submenui' onclick = "shownewfields('phoneno')"> Phone Number </li>
<li class = 'submenui' onclick = "shownewfields('zip')"> Zip Code </li>
<li class = 'submenui' onclick = "shownewfields('numother')"> Other </li>
</ul>
</li>
</ul>

</div>
<div class = 'clear'></div>
</div>

</div> <!-- end of text ops -->
</div> <!-- end of textwrap -->


<div id = 'radiowrap'  class = "hide">
<!-- For radio buttun template -->
<div class = 'wid100 smmargtop' id = "radiotemp">
<div class = 'head3 floatl wid50'> Radio Button Template : </div> 
<div class = 'input floatl wid50'>

<ul class = 'optmenu'>
<li class = 'mainmenu'> <span id = "radiotemprep"> Select </span> <img src="images/downarrow.jpg" class = 'righticon'>
<ul class = 'submenu'>
<input type="hidden" name = 'radiotype' id = 'radiotype'>
<li class = 'submenui' onclick = "shownewfields('rwother')"> Other </li>
<li class = 'submenui' onclick = "shownewfields('morf')"> Male / Female </li>
<li class = 'submenui' onclick = "shownewfields('yorno')">Yes / No  </li>
</ul>
</li>
</ul>

</div>
<div class = 'clear'></div>
</div>
</div> <!-- For radiowrap field -->

<div id = 'radiootherwrap'  class = "hide">
<!-- For radio box template -->
<div class = 'wid100 smmargtop' id = "selecttemp">
<div class = 'head3 floatl wid50'>  Add radio options : </div> 
<div class = 'input floatl wid50'>
<input type = "text" class = "textfld" id = "addtoradio" size = "31">
<span class = 'yellowbutton' onclick = addoption('radio')> Add </span>
</div>

<div class = 'head3 floatl wid50 smmargtop'>  <pre>           </pre></div> 
<div class = 'input floatl wid50 smmargtop'>

<div>
<div class = 'head4'>
Values Added :
</div>
<div id = "radiovals">

</div>
<div class = 'head5'>
Expand
</div> 
</div>


</div>

<div class = 'clear'></div>
</div>
</div> <!-- For radiootherwrap field -->



<!-- --------------------------------------
   Start working from here again 
-->

<div id = 'selectwrap'  class = "hide">
<!-- For select box template -->
<div class = 'wid100 smmargtop' id = "selecttemp">
<div class = 'head3 floatl wid50'> Add to select box : </div> 
<div class = 'input floatl wid50'>
<input type = "text" class = "textfld" id = "addtoselbox" size = "31">
<span class = 'yellowbutton' onclick = addoption('select')> Add </span>
</div>

<div class = 'head3 floatl wid50 smmargtop'>  <pre>           </pre></div> 
<div class = 'input floatl wid50 smmargtop'>
<select name = '' class = "textfld">
<option> Values added to select box </option>
</select>

</div>

<div class = 'clear'></div>
</div>
</div> <!-- For selectwrap field -->




<div id = 'checkwrap'  class = "hide">
<!-- For check wrap template -->

<!-- For check box template -->
<div class = 'wid100 smmargtop' id = "checktemp">
<div class = 'head3 floatl wid50'>  Add check box options : </div> 
<div class = 'input floatl wid50'>
<input type = "text" class = "textfld" id = "addtocheck" size = "31">
<span class = 'yellowbutton' onclick = addoption('check')> Add </span>
</div>

<div class = 'head3 floatl wid50 smmargtop'>  <pre>           </pre></div> 
<div class = 'input floatl wid50 smmargtop'>

<div>
<div class = 'head4'>
Values Added :
</div>
<div id = "radiovals">

</div>
<div class = 'head5'>
Expand
</div> 
</div>
</div>
<div class = 'clear'></div>
</div>
</div> <!-- For checkwrap field -->



<div id = 'datep'  class = "hide">
<!-- For date p template -->

<!-- For date p template -->
<div class = 'wid100 smmargtop' id = "datetemp">
<div class = 'head3 floatl wid50'>  Add check box options : </div> 
<div class = 'input floatl wid50'>
<input type = "text" class = "textfld" id = "addtocheck" size = "31">
<span class = 'yellowbutton'> Add </span>
</div>

<div class = 'head3 floatl wid50 smmargtop'>  <pre>           </pre></div> 
<div class = 'input floatl wid50 smmargtop'>

<div>
<div class = 'head4'>
Values Added :
</div>
<div id = "radiovals">

</div>
<div class = 'head5'>
Expand
</div> 
</div>
</div>
<div class = 'clear'></div>
</div>
</div> <!-- For checkwrap field -->



<!-- For essential field -->
<div class = 'wid100 smmargtop'>
<div class = 'head3 floatl wid50'> Essentianl Field ? : </div> 
<div class = 'input floatl wid50'>

<ul class = 'optmenu' name = 'essential'>
<input type = "hidden" name = "essential" id = "essential" value = "no">
<li class = 'mainmenu'><span id = 'essval'> No </span> <img src="images/downarrow.jpg" class = 'righticon'>
<ul class = 'submenu'>
<li class = 'submenui' onClick=shownewfields('essyes')> Yes </li>
<li class = 'submenui' onClick=shownewfields('essno')> No </li>
</ul>
</li>
</ul>
</div>
<div class = 'clear'></div>
</div>

<!-- For unique field -->
<div class = 'wid100 smmargtop'>
<div class = 'head3 floatl wid50'> Unique Field ? : </div> 
<div class = 'input floatl wid50'>

<ul class = 'optmenu' name = 'uniquw'>
<input type = "hidden" name = "unique" id = "unique" value = "no">
<li class = 'mainmenu'><span id = 'unival'> No </span> <img src="images/downarrow.jpg" class = 'righticon'>
<ul class = 'submenu'>
<li class = 'submenui' onClick=shownewfields('uniyes')> Yes </li>
<li class = 'submenui' onClick=shownewfields('unino')> No </li>
</ul>
</li>
</ul>
</div>
<div class = 'clear'></div>
</div>

<input type = 'submit' class = 'bluebutton wid30 margtop ' value = 'Add Field' name = 'subfld' onClick="storescroll()"></input>

</div>
</form>



<div class = 'fldsadded'>
<?php
if(isset($_POST['subfld']))
{
  // echo "hello";
   $username = $_SESSION['user'];
   $formname = $_SESSION['formname'];
   $fldname = $_POST['fname'];
   $fldtype = $_POST['ftype'];
   $essential = $_POST['essential'];
   $unique = $_POST['unique'];
   
   if($formname == "new")
   {
	   echo "<div class = 'menuelem' style='margin: 2rem;
border: 1px dashed #f00;'> Formname needs to be saved before adding new field.</div>";
   }
   else
   {
   $xml =new SimpleXMLElement("formelems.xml", null, true);
     
   if($xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields"))
   {
	    $fields = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields");
		$field = $fields[0]->addChild('field'); 
   }
   else 
   {
	   $form = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']");
	   $fields = $form[0]->addChild('fields');
	   $field = $fields->addChild('field');
   }
   
    $field->addChild('fldname', $fldname);
	$field->addChild('fldtype', $fldtype);
	$field->addChild('essential', $essential);
	$field->addChild('unique', $unique);
	   
  /* echo "username ".$username." formname ".$formname."fld name is ".$fldname." fieldtype ".$fldtype;*/
  
   // check which field type it is and generate data for the relevant type
   switch ($fldtype) {
    case "text":
	    // check for texttype
		$texttype = $_POST['texttype'];
		
		if($texttype == "chars")
		{
			$chartype = $_POST['chartype'];
			$field->addChild('textboxtype', "chars");
			$field->addChild('subtype', $chartype);
		}
		else if($texttype == "nums")
		{
			$numtype = $_POST['numtype'];
			$field->addChild('textboxtype', "nums");
			$field->addChild('subtype', $numtype);
		}
        break;
    case "select":
	    addoptions("select", $field);
        break;
    case "check":
	    addoptions("check", $field);
        break;
	case "radio":
	    addoptions("radio", $field);
		break;
	case "tdesc":
	   break;
	case "image":
	   $regex = $field->addChild('regex');
	   $elems = $regex[0]->addChild('elems');
	   $imagetypes=array("jpeg", "gif", "bmp", "png", "tiff", "psd", "svg", "raw", "jpg");
	   foreach($imagetypes as $image)
	   { $elems[0]->addChild('elem',$image);}
	   break;
	case "doc":
	   $regex = $field->addChild('regex');
	   $elems = $regex[0]->addChild('elems');
	   $doctypes=array("txt", "docx", "xls", "ppt", "pdf", "rtf", "odt", "xml");
	   foreach($doctypes as $doc)
	   { $elems[0]->addChild('elem',$doc);}
	break;
	default:
	    break;
    }
	
   $xml->asXML("formelems.xml");
   $username = $_SESSION['user'];
   //echo "user is ".$username;
	}
}// end of form == new check
dispformfields($_SESSION['formname'], $_SESSION['user'], 'fc');
?>

</div>

<div class = 'link'>
<?php
$username = $_SESSION['user'];
$formname = $_SESSION['formname'];

echo "<div class = 'wid100 margtop'><div class = 'wid50 floatl'>
<a onClick=\"deleteform('$username', '$formname')\" class='orangebutton simpleshadow textshadow'> Delete Form </a></div>
";
echo "</div>";  // closing upper container div
?>
</div>

<div class = 'link formlinkon' id = 'formlink'>
<?php
if($_SESSION['formname'] != "new")
{
   echo "<div class = 'wid50 floatl'>";
   echo "<a href = 'formDisplay.php?user=".$username."&form=".$_SESSION['formname']."' class = 'bluebutton'> Visit Link </a>";
   
    echo "<a href = 'responses.php?user=".$username."&form=".$_SESSION['formname']."'  class = 'bluebutton'> View Responses </a>";
	echo "</div>";
	echo "<div class = 'clear'></div></div>"; //close upper wid100 margtop
    
   echo "<div class = 'feedback wid100 margtop'>
		<div class = 'floatl wid70'>Your URL is : </div> <!-- closed -->
		<div class = 'helpicon floatl wid10 margleftmid orgdiffshadebg' onclick = help()>?</div> <!-- closed -->
		<div class = 'clear'></div> <!-- closed -->
		</div> <!-- parent outer menuelem wid100 -->
		
		<div class = 'bg1 pad'> http://localhost/Assignment/Portfolio/responseMgmt/research/formDisplay.php?user=".$username."&form=".$_SESSION['formname']."</div>";
   
}
?>

<div class = 'clear'> </div>
</div>


<div class = 'wid100 margtop pad'>
<div class = 'feedback'> Reciepients <span class = 'yellowbutton wid10 textcenter margleftbig' onClick="recephtml(<?php echo "'$username'"; echo","; echo "'$formname'" ;?>)"> Add </span></div>

<div id = 'receplist' class = 'bg2'>
<?php
showreceps($username, $formname);
?>

<div class = 'clear'></div>
</div>
</div> <!-- end of last wid100 margtop pad class -->
<?php
}// end of else for checking credentials.
?>
</div> <!-- end of content class -->

<div class ='clear'></div>
</div> <!-- end of bodysec class -->


<script>
function focusme()
{
  var fldname = document.getElementById("fldname");
}
function blurme()
{
    var fldname = document.getElementById("fldname");
	if(fldname.value == "")
	{
		document.getElementById("fldnameerr").innerHTML = "Fieldname cannot be blank please";
	}
	else
	{
		document.getElementById("fldnameerr").innerHTML = "";
	}
}
</script>
</body>
</html>