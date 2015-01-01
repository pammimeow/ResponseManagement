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
<!-- In this file we will create a form using which user can enter data and create his customised form -->

<div class = 'smallheader'>
Response Management System
</div> <!-- closed -->


<div class = 'bodysec'> <!-- complete body without header -->
<div class = 'menu'>    <!-- left menu section -->

<div class = 'orangemenuelem orgdiffshadebg'>
<a href = "formCreate.php?form=new" class = 'link'>New Form</a>
</div class ='orangemenuelem orgdiffshadebg' > <!-- closed orangemenuelem orgdiffshadebg-->

<div class = 'orangemenuelem orgdiffshadebg'>
<a href = "formCreate.php?credentials" class = 'link' onClick="getcredentials()"> Your Credentials </a>
</div class = 'orangemenuelem orgdiffshadebg'> <!-- closed orangemenuelem orgdiffshadebg-->

<div class = 'bluemenuelem margtop'>
Your Forms
</div class = 'bluemenuelem margtop'> <!-- closed bluemenuelem margtop-->

<!-- *****  bodysec and menu unclosed -->

<?php
session_start();

include_once('includeFunctions.php');

if(isset($_GET['form']))
{
$currform = $_GET['form'];
}
else
{
$currform = "new";	
}

if(!(isset($_SESSION['user'])))
{
	header('Location:login.php');
	//page to go on after login is successfull. 
	$_SESSION['succlogin'] = 'formCreate.php';
}

if(!(isset($_SESSION['formname'])))
{
   $_SESSION['formname'] = "";
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
  echo "No forms added";	// ### styling to be done
}

?>

<div> <!-- menu class closed -->

</div>
</div>


<div class = 'content'>

<?php
if(isset($_GET['credentials']))
{
// html for show credentials content
?>
<div class = 'feedback wid100'> Your Credentials </div>
<div class = 'wid100 margtop bg1 pad'>
<div class = 'head3 wid30 floatl'> Company Name </div>
<div class = 'wid50 floatl'> <input type = 'text' id = 'compname' name = 'compname'> </div>
<div class = 'clear'> </div>
</div>

<div class = 'wid100 smmarg bg1 pad'>
<div class = 'head3 wid30 floatl'> Tagline </div>
<div class = 'wid50 floatl'> <input type = 'text' id = 'tagline' name = 'tagline'> </div>
<div class = 'clear'> </div>
</div>

<div class = 'wid100 smmarg bg1 pad'>
<div class = 'head3 wid30 floatl'> Logo </div>
<div class = 'wid50 floatl'> <input type = 'file' id = 'logo' name = 'logo'> </div>
<div class = 'clear'> </div>
</div>

<div class = 'yellowbutton textcenter wid30 smmarg'>Save</div>
<?php	
}
else
{
	
/* start of content other than credentials */
?>

<div class = 'menuelem wid100 '>
<div class = 'menuelem floatl wid70'>Give a Form name and start adding fields to it : </div> <!-- closed -->
<div class = 'helpicon floatl wid10 pad margleftmid orgdiffshadebg' onclick = help()>?</div> <!-- closed -->
<div class = 'clear'></div> <!-- closed -->
</div> <!-- parent outer menuelem wid100 -->

<div class = 'inputcont'>
<div class = 'wid100 margtop bg1'>
<div class = 'head3 feedback'>
	          Form Name : 
	          <div>
	          </div> 
	          <div class = 'input' id = 'formnamecont'>
<?php

if($currform == "new" || $_SESSION['formname'] == "######@@&*123")
{
//	echo "form ".$_SESSION['formname'];
if($_SESSION['formname'] == "######@@&*123")
{
	$_SESSION['formname'] = "";
}

if($currform == "new")
{
	$_SESSION['formname'] = "";
}

if(trim($_SESSION['formname']) != "")
{
	echo "";
	echo "currform is ".$currform;

	echo "<div class = 'smheader pad'>".$_SESSION['formname']."</div>";
}
else
{

?>

<div class ='feedback wid100'> Form Information : </div> 
<div class = 'smmarg wid100'>  
<div class = 'wid100 bg1 pad'>
<div class = 'head3 wid30 floatl'> Form Name : <span class = 'highlightred exsmfont'> *</span></div>
<div class = 'wid50 floatl'> <input type = 'text' name = 'formname' size="40" id = 'formname'  class = 'textfld'> </div>
<div class = 'clear'> </div>
</div>
</div>

<div class = 'smmarg wid100'> Company's Information  </div>
<div class = 'wid100 bg1 pad'>
<div class = 'head3 wid30 floatl'> Company's Name :</div>
<div class = 'wid50 floatl'> <input type = 'text' name = 'compname' size="40" id = 'compname'  class = 'textfld'> </div>
<div class = 'clear'> </div>
</div>
<div class = 'wid100 bg1 pad'>
<div class = 'head3 wid30 floatl'> Tagline :</div>
<div class = 'wid50 floatl'> <input type = 'text' name = 'tagline' size="40" id = 'tagline'  class = 'textfld'> </div>
<div class = 'clear'> </div>
</div>
<div class = 'wid100 bg1 pad'>
<div class = 'head3 wid30 floatl'> Logo : </div>
<div class = 'wid50 floatl'> <input type = 'file' name = 'logo' size="40" id = 'logo'  class = 'textfld'> </div>
<div class = 'clear'> </div>
</div>

<input type = 'submit' name = 'subformname' name = 'subformname' value = "Save Form" onClick="subformname()" class = "bluebutton simpleshadow">


<?php
}
}
else
{
	echo "<div class = 'smheader pad'>".$currform."</div>";
}
?>

</div>
</div>
</div>
</div>

<div class = 'feedback  margtop' id = 'message'> Add Fields to your form </div>
<div class = 'section bg1 pad' id = 'fldcontent'>
<form method="post" action="">

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
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('video')"> Video </li>
<li class = 'submenui' name = 'ftype' value = 'text' onclick = "shownewfields('doc')"> Word / Pdf Document </li>
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
<input type = "hidden" name = "essential" id = "essential" value = "yes">
<li class = 'mainmenu'><span id = 'essval'> Yes </span> <img src="images/downarrow.jpg" class = 'righticon'>
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
<input type = "hidden" name = "unique" id = "unique" value = "yes">
<li class = 'mainmenu'><span id = 'unival'> Yes </span> <img src="images/downarrow.jpg" class = 'righticon'>
<ul class = 'submenu'>
<li class = 'submenui' onClick=shownewfields('uniyes')> Yes </li>
<li class = 'submenui' onClick=shownewfields('unino')> No </li>
</ul>
</li>
</ul>
</div>
<div class = 'clear'></div>
</div>

<input type = 'submit' class = 'bluebutton wid30 margtop ' value = 'Add Field' name = 'subfld'></input>

</div>
</form>



<div class = 'fldsadded'>

<div class = 'feedback margtop'>
Mandatory Fields ( Automatically Added )
</div>
<div class = 'bg1 pad'>
<div class = 'wid100 smmarg'>
<div class = 'head3 floatl wid30'> Name </div>
<div class = 'input floatl wid50'> <input type = 'text' name = 'name' disabled> </div>
</div>

<div class = 'clear'></div>

<div class = 'wid100 smmarg'>
<div class = 'head3 floatl wid30'> E-Mail </div>
<div class = 'input floatl wid50'> <input type = 'text' name = 'email' disabled> </div>
</div>

<div class = 'clear'></div>
</div> <!-- end of bg1 pad -->

<?php

if((trim($_SESSION['formname']) != "" && !(isset($_POST['subfld']))) || ($currform != "new" && !(isset($_POST['subfld']))))
{
	dispformfields($currform, $_SESSION['user'], 'fc');
}

if(isset($_POST['subfld']))
{
  // echo "hello";
   $username = $_SESSION['user'];
   
   if($currform == "new")
   {
   $formname = $_SESSION['formname'];
   }
   else
   {
   $formname = $currform;
   }
   
   $fldname = $_POST['fname'];
   $fldtype = $_POST['ftype'];
   $essential = $_POST['essential'];
   
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
	default:
	    break;
    }
	
   $xml->asXML("formelems.xml");
   $username = $_SESSION['user'];
   //echo "user is ".$username;
   dispformfields($currform, $username, 'fc');
}

?>

</div>


<div class = 'link'>
<?php
$username = $_SESSION['user'];

if($currform == "new")
{
$formname = $_SESSION['formname'];
}
else
{
$formname = $currform;	
}

echo "<a onClick=\"createlink('$username', '$formname')\" class='orangebutton simpleshadow textshadow'> createLink </a>

<a onClick=\"deleteform('$username', '$formname')\" class='orangebutton simpleshadow textshadow'> Delete Form </a>

";
echo "</div>";  // closing upper container div
?>
</div>

<div class = 'link formlinkon' id = 'formlink'>
<?php
if($currform != "new")
{
   echo "<a href = 'formDisplay.php?user=".$username."&form=".$currform."' class = 'bluebutton'> Visit Link </a>";
   
      echo "<a href = 'responses.php?user=".$username."&form=".$currform."'  class = 'bluebutton'> View Responses </a>";
    
   echo "<div class = 'margtop'> Your URL is http://localhost/Assignment/Portfolio/responseMgmt/research/formDisplay.php?user=".$username."&form=".$currform."</div>";
   
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