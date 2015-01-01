<?php
session_start();
include_once('includeFunctions.php');

if($_POST['op'] == "emailhtml")
{
$username = $_POST['username'];
$formname = $_POST['formname'];
$respid = $_POST['respid'];
$email = $_POST['email'];
$hasreceps = $_POST['hasreceps'];
if(isset($_POST['content'])) { $content = $_POST['content']; }
else { $content = ""; }

if(isset($_SESSION['receparray']))
{ foreach($_SESSION['receparray'] as $recep) echo $recep; }

if(isset($_SESSION['recepadded']))
{
if($hasreceps == "false")
{ $_SESSION['recepadded'] = "<span class = 'bg1 smpad smmargtop floatl'>$email</span>";  $_SESSION['receparray'] = array();
  $_SESSION['receparray'][0] = $email;
}
}
else
{$_SESSION['recepadded'] = $email; 
 $_SESSION['receparray'] = array();
 $_SESSION['receparray'][0] = $email;
}
?>

<div class = 'feedback' id='responseme'> Fill in the fields below. </div>

<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
To Recipient
</div>
<div class = 'head3 floatl wid50'>
<?php /*if($email != "")*/ { echo $_SESSION['recepadded']; } 
      //else { echo "No Reciepients."; }
	  ?>
</div>
<div class = 'head3 floatl wid10'>
<?php echo "<span class = 'margright floatr' onClick=\"addemailrecep('$username', '$formname', '$respid', '$email')\"> <img src ='images/addicon.png' class='opicon'></span>"; ?>
</div>
<div class = 'clear'></div>
</div>

<div class = 'wid 100 pad smmarg'>
<div class = 'head3 floatl wid30'>
Subject 
</div>

<div class = 'head3 floatl wid30'>
<input type = "text" id = "subject">
</div>
</div>

<div class = 'wid 100 pad smmarg'>
<div class = 'head3 floatl wid30'>
Message
</div>

<div class = 'head3 floatl wid30'>
<textarea rows="10" cols = "40" id = 'emailmsg'>
<?php echo $content; ?>
</textarea>
</div>
</div>

<div class = 'clear'></div>

<?php
echo "<div class = 'bg1' id ='sendemailresp'></div>";
echo "<div class = 'orangebutton wid20 textcenter' onclick = \"processemail('$username', '$formname', '$respid', '$email')\"> Send Message </div>";

?>

<?php
}

if($_POST['op'] == "emailhtmlformdispemail")
{
$username = $_POST['username'];
$formname = $_POST['formname'];
$respid = $_POST['respid'];
$email = $_POST['email'];
$hasreceps = $_POST['hasreceps'];
if(isset($_POST['content'])) { $content = $_POST['content']; }
else { $content = ""; }
?>

<div class = 'feedback' id='responseme'> Fill in the fields below. </div>

<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
To Recipient
</div>
<div class = 'head3 floatl wid50'>
<?php if($email != ""){ echo $email; } 
      else { echo "E - Mail not present."; }
	  ?>
</div>
<div class = 'head3 floatl wid10'>
</div>
<div class = 'clear'></div>
</div>

<div class = 'wid 100 pad smmarg'>
<div class = 'head3 floatl wid30'>
Subject 
</div>

<div class = 'head3 floatl wid30'>
<input type = "text" id = "subject">
</div>
</div>

<div class = 'wid 100 pad smmarg'>
<div class = 'head3 floatl wid30'>
Message
</div>

<div class = 'head3 floatl wid30'>
<textarea rows="10" cols = "40" id = 'emailmsg'>
<?php echo $content; ?>
</textarea>
</div>
</div>

<div class = 'clear'></div>

<?php
echo "<div class = 'bg1' id ='sendemailresp'></div>";
echo "<div class = 'orangebutton wid20 textcenter' onclick = \"processformdispemail('$username', '$formname','$email')\"> Send Message </div>";

?>

<?php
}


if($_POST['op'] == "addrecephtml")
{	
	if($_SESSION['formname'] == "new")
	{
		echo "<div class='bg1 pad margtop'>Cannot Add Reciepients without formname saved.</div>";
	}
	else
	{
		$username = $_POST['username'];
		$formname = $_POST['formname'];
		?>
		<div class = 'wid 100 pad margtop'>
		<div class = 'head3 floatl wid30'>
		Name :
		</div>
		<div class = 'input floatl wid50'>
		<input type = 'text' id = 'recepname'  size="40" class = 'textfld'>
		</div>
		<div class="clear"></div>
		</div>
		<div class = 'wid 100 pad margtop'>
		<div class = 'head3 floatl wid30'>
		E-Mail Address :
		</div>
		<div class = 'input floatl wid50'>
		<input type = 'text' id = 'recepemail'  size="40" class = 'textfld'>
		</div>
		<div class="clear"></div>
		</div>
		
		<div class = 'margtop bluebutton' onClick="addrecep(<?php echo "'$username'"; echo","; echo "'$formname'" ;?>)"> Add Reciepient </div>

<?php
	}
}

if($_POST['op'] == "editrecephtml")
{	
$username = $_POST['username'];
$formname = $_POST['formname'];
$recepemail = $_POST['recepemail'];

$xml =new SimpleXMLElement("reciepients.xml", null, true);

if($xml->xpath("/users/user[username='$username']/form[formname='$formname']/reciepients/reciepient[email='$recepemail']"))
	{
		$reciepient = $xml->xpath("/users/user[username='$username']/form[formname='$formname']/reciepients/reciepient[email='$recepemail']"); 
		$name = (string)$reciepient[0]->name;
	}
?>
<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
Name :
</div>
<div class = 'input floatl wid50'>
<input type = 'text' id = 'recepname'  size="40" class = 'textfld' value="<?php echo $name; ?>">
</div>
<div class="clear"></div>
</div>
<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
E-Mail Address :
</div>
<div class = 'input floatl wid50'>
<input type = 'text' id = 'recepemail'  size="40" class = 'textfld' value = "<?php echo $recepemail; ?>">
</div>
<div class="clear"></div>
</div>

<div class = 'margtop bluebutton' onClick="editrecep(<?php echo "'$username'"; echo","; echo "'$formname'" ; echo","; echo "'$recepemail'"; ?>)"> Save </div>
<?php
}

if($_POST['op'] == "deletehtml")
{
$what = $_POST['what'];
$param = $_POST['param'];
$username = $_SESSION['user'];
$formname = $_POST['formname'];

echo "param is ".$param;
?>

<div class = 'wid 100 pad margtop'>
<div class = 'head3 wid100'>
Are you sure you want to delete the <?php echo $what; ?> ? 
</div>
<?php  echo "<div class = 'orangebutton floatl wid30' onclick =\"deleteitem('$param', '$username', '$formname')\"> Delete </div>"; ?>
<div class = 'bluebutton floatl wid30' onclick = closemodal()> Cancel </div>
<div class = 'clear'>

<?php	
// \"uchat('$name')\"
}

if($_POST['op'] == "editfldhtml")
{
	$username = $_POST['username'];
    $formname = $_POST['formname'];
	$fldname = $_POST['fldname'];
	
	 $xml =new SimpleXMLElement("formelems.xml", null, true);

	 if($xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fldname']"))
	 {
		$field = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fldname']"); 
		
		$fldtype = $field[0]->fldtype;
		$essential = $field[0]->essential;
		$unique = $field[0]->unique;
		
		$optionwrap = "";
		// collecting options if check select or radio field. 
		if($fldtype == "check" || $fldtype == "select" || $fldtype == "radio")
		{
			foreach($field[0]->options->option as $option)
			{
				$optionval = (string)$option;
				$inputidval = "edit".$optionval."idval";
				$closeidval = $inputidval."close";
				$checkidval = $inputidval."check";
				
				$optionwrap .= "<div class = 'wid50 menuelem floatl'><span>".$optionval."</span><input type='hidden' id = '$inputidval' value = '$optionval' data-prevval = '$optionval')>
  <span style='display:none;' onclick = \"saveoptval('$username','$formname','$fldname','$optionval','$inputidval')\" id = '$checkidval'><img src='images/check.jpg' class='icon'></span>
  <span style='display:none;' onclick = \"restoreinputval('$inputidval')\" id = '$closeidval'><img src='images/closeicon.png' class='icon'></span></div>";
				
				$optionwrap .= "<div class = 'wid10 menuelem floatl'><img src ='images/edit.png' class = 'icon' onClick=\"showinput('$inputidval')\"> </div>";
				
				$optionwrap .= "<div class = 'wid10 menuelem floatl'><img src ='images/delete.png' class = 'icon' onclick = \"delopt('$username','$formname','$fldname','$optionval')\"'> </div>";
				
				$optionwrap .= "<div class='clear'></div>";
			}
			$optionwrap .= "";
		}
	 }
?>	

<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
Field Name :
</div>
<div class = 'input floatl wid50'>
<input type = 'text' id = 'editfldname'  size="40" class = 'textfld' value = '<?php echo $fldname;?>'>

</div>
<div class="clear"></div>
</div>

<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
Essential Field :
</div>
<div class = 'input floatl wid50'>
<input type = 'text' id = 'editessentialfld'  size="40" class = 'textfld' value = "<?php echo $essential; ?>" onChange=changeval('editessentialfld')>
</div>
<div class="clear"></div>
</div>

<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
Unique Field :
</div>
<div class = 'input floatl wid50'>
<input type = 'text' id = 'editunifld'  size="40" class = 'textfld' value="<?php echo $unique; ?>" onChange=changeval('editunifld')>
</div>
<div class="clear"></div>
</div>

<?php
if($optionwrap != "")
{
  echo $optionwrap;	
}
?>
<div class = 'margtop bluebutton' onClick="editfld(<?php echo "'$username'"; echo","; echo "'$formname'" ; echo","; echo "'$fldname'"; ?>)"> Save </div>

<?php
}

if($_POST['op'] == "getfoldernamedb")
{
$sendparam = $_POST['sendparam'];
$formname = $_POST['formname'];
?>
<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
Enter Search Name :
</div>
<div class = 'input floatl wid50'>
<input type = 'text' id = 'foldername'  size="40" class = 'textfld' value = ''>

</div>
<div class="clear"></div>
</div>

<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
Enter Search Description :
</div>
<div class = 'input floatl wid50'>
<textarea id = 'searchdesc' rows = '5' cols = '40'></textarea>
</div>
<div class="clear"></div>
</div>
<?php
echo "<div class = 'wid20 yellowbutton' onclick = \"savefolder('$formname','$sendparam')\"> Save this search. </div>";
	
}
//op=showregexhtml&formname="+formname+"&fldname="+fldname
if($_POST['op'] == 'showregexhtml')
{
  $formname = $_POST['formname'];
  $fldname = $_POST['fldname'];
  $username = $_SESSION['user'];
  
  $startswith = "";
  $endswith = "";
  $startrange = "";
  $endrange = "";
  $length = "";
  $custregex = "";
  $maxsize = "";
  $arrayelems = array();
  
  $charsstheader = "<img src='images/selecten.png' id = 'textcharsel' class = 'icon' onclick = \"toggleenable('textcharsel');\" data-en='en'>";
  
  $xml =new SimpleXMLElement("formelems.xml", null, true);
   
  if($xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fldname']"))
	 {
		 $field = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fldname']");	
		 $fldtype = $field[0]->fldtype;
	     
		  echo "<div class = 'wid100 margtop head3'>
		  <div class = 'wid70 floatl'>
		  Set regular expression for field <span class ='highlightred'>$fldname</span>          </div>
		  <div class = 'helpicon floatr wid10 orgdiffshadebg' onclick =   help()>?</div>
		  <div class = 'clear'> </div>
		  </div class ='outerdivcloses'>";
		 
		  // loading the regex values.	
		  if($fldtype == "text" || $fldtype == "tdesc")
		  { if($fldtype == "tdesc")
		    { $textboxtype = "chars"; }
			else
			{  $textboxtype = $field[0]->textboxtype; }
		    if($textboxtype == "chars") { 
			                            if($field[0]->regex) 
										{
									    if($field[0]->regex->type == "standard")
										{ echo "charss";
										$startswith = $field[0]->regex->startswith;
									    $endswith = $field[0]->regex->endswith;
									    $length = $field[0]->regex->length;
										}
											else
										{ $custregex = $field[0]->regex->custregex; }
			                            } 
									} 
            else if($textboxtype == "nums") { 
			                            if($field[0]->regex) 
										{ 
										 if($field[0]->regex->type == "standard")
								        { $startrange = $field[0]->regex->startrange;
										  $endrange = $field[0]->regex->endrange;
										}
										else if($field[0]->regex->type == "length")
										{ $length = $field[0]->regex->length; }
										else
										{ $custregex = $field[0]->regex->custregex; }
			                            } 
									} 
		  }
		  else if($fldtype == "image" || $fldtype == "doc" || $fldtype == "video")
		  {  
			  if($xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fldname']/regex/elems/elem"))
			  {
			  $maxsize = $field[0]->regex->maxsize;
			  echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl enabledtext' id = 'startwithheadid'>
			   Maximum Size (In KB ):
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'maxsize' id = 'maxsize' size = '50' value = '$maxsize'>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   echo "<div class = 'wid100 margtop feedback'>
			   Disable <img src='images/disabledeactive.png' class = 'icon smmargleft smmargright'> File Formats That Cannot be uploaded :
			   </div>";
			  $arrayelems = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fldname']/regex/elems/elem");
			  foreach($arrayelems as $elem)
			    echo $elem;
			  } 
		  }

		  
		 if($fldtype == "text" || $fldtype == "tdesc")
		 {
			 if($fldtype == "text")
			 {  $textboxtype = $field[0]->textboxtype; }
			  else
			 { $textboxtype = "chars"; }
			 
			 if($textboxtype == "chars")
			 {
			 echo "<div class = 'wid100 pad bordersmpad'>
			       <div class = 'wid100 feedback' id = 'stdconstheader'>
				   <span><img src='images/selecten.png' id = 'textcharsel' class = 'icon' onclick = \"toggleenable('textcharsel');\" data-en='en'></span>
				   Standard Constraints :
				   </div>
			       ";
			 echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl enabledtext' id = 'startwithheadid''>
			   Starts With :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'startswith' id = 'startswith' size = '50' value = '$startswith'>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   
			  echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl enabledtext' id = 'endswithheadid'>
			   Ends With :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'endswith' id = 'endswith' size = '50' value = '$endswith'>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   
			   echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl enabledtext' id = 'lengthheadid'>
			   Length :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'length' id = 'length' size = '50' value = '$length'>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   
			   echo "</div>"; // closing wid100 pad bordersmpad 
			   
			 }
			 else
			 {
			   // textboxtype is nums
			   echo "<div class = 'wid100 pad bordersmpad'>
			   <div class = 'wid100 feedback' id = stdconstheader>
			   <span><img src='images/selecten.png' class = 'icon' onclick = \"toggleenable('textnumsel');\" data-en='en' id='textnumsel'></span>Standard Constraints :
			   </div>
			   ";
			   echo "<div class = 'wid100 pad bordersmpad'>"; // range div container
			   echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl enabledtext' id = 'startrangeheadid'>
			   Start Of Range :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'startrange' id = 'startrange' size = '50' value = '$startrange'>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   
			  echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl enabledtext' id = 'endrangeheadid'>
			   End Of Range :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'endrange' id = 'endrange' size = '50' value='$endrange'>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   echo "</div class = 'wid100 pad bordersmpad'>"; // range div cont end
			   
			   echo "<div class = 'head3 wid100 margtop textcenter'> Or </div>";
			    
			   echo "<div class = 'wid100 pad bordersmpad'>";  // length cont start 
			   echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl  disabledtext' id = 'lengthheadid'>
			   <span><img src='images/selectdis.png' class = 'icon' onclick = \"toggleenable('numlensel');\" data-en='dis' id = 'numlensel'></span> Length :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'length' id = 'length' size = '50' value = '$length' disabled>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   
			    echo "</div>"; // closing wid100 pad bordersmpad 
				echo "</div>"; // length div cont end
			 }
		 }
		 else if($fldtype == "datep")
		 {
			  echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl head3'>
			   Starts Date :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'startdate' id = 'startdate' size = '50'>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   
			  echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl head3'>
			   End Date :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'enddate' id = 'enddate' size = '50'>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
			   
		 }
		 else if($fldtype == "image")
		 {
			 $imagetypes=array("jpeg", "gif", "bmp", "png", "tiff", "psd", "svg", "raw", "jpg");
			 createfloattabs($imagetypes, "wid30", $arrayelems);
		 }
		 else if($fldtype == "doc")
		 {
			 $doctypes=array("txt", "docx", "xls", "ppt", "pdf", "rtf", "odt", "xml");
			 createfloattabs($doctypes, "wid30", $arrayelems);

		 }
		 else if($fldtype == "video")
		 {
			 $doctypes=array("mp4", "mpeg", "avi", "mov", "rm", "3gp", "wmv", "ogm");
			 createfloattabs($doctypes, "wid30", $arrayelems);
		 }
		 
		 if(!($fldtype == 'image' || $fldtype == 'doc' || $fldtype == 'video' || $fldtype == 'datep'))
		 {
		 echo "<div class = 'head3 wid100 margtop textcenter'> Or </div>";
		 echo "<div class = 'wid100 margtop'>
		       <div class = 'wid40 floatl disabledtext' id = 'custregexpheader'>
			   <span><img src='images/selectdis.png' class = 'icon' onclick = \"toggleenable('custregexsel');\" data-en='dis' id = 'custregexsel'></span> Custom Regular Expression :
			   </div>
			   <div class = 'wid50 floatl'>
			   <input type = 'text' name = 'custregex' id = 'custregexfld' value = '$custregex' size = '50' disabled>
			   </div>
			   <div class = 'clear'></div>
			   </div>";
		 }
		 
		 if($fldtype == "text")
		 {  if($textboxtype == "chars")
		 { $fldtype = "chars"; }
		 else
		 { $fldtype = "nums";  } }
		 
		 
		 echo "<div class = 'wid50 yellowbutton' onClick=\"saveregex('$username', '$formname', '$fldname', '$fldtype');\"> Save Settings </div>";
	 }
}
//var param = "op=emailrecephtml&username="+username+"&formname="+formname;
if($_POST['op'] == 'emailrecephtml')
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$respid = $_POST['respid'];
	$email = $_POST['email'];
	$allemail = array();
	$xml =new SimpleXMLElement("responses.xml", null, true);
     
	// link for back button
	echo "<div class = 'wid100'>";
	echo "<div class ='wid10 bluebutton floatl' onclick = \"sendemail('$username', '$formname', '$respid', '$email', 'true')\"> Add Selected </div>";
	echo "<div class ='clear' id='responseme'></div>";
	echo "</div>";
	echo "<div class='wid100'>";
  if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response"))
	  {
		   $fields = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response/field[fldname='E - Mail']");
		   
	   foreach($fields as $field)
	   {  $email = (string)$field[0]->value; 
	      $recepname = getrespondersname($email, $formname, $username);
		  
		  echo "<div class = 'wid100 bg1 pad'>";
		  echo "<div class = 'wid10 floatl'><input type = 'checkbox' onclick=\"addresponderemail('$username', '$formname', '$respid','$email')\"></div>"; 
		  echo "<div class = 'wid30 floatl'> $recepname</div>
		        <div class = 'wid30 floatl'> $email </div>";
		  echo "</div>";
	   }
	  }
	  else {  echo "<div class = 'pad bg1'> No Responders Found </div>"; }
	 echo "</div>";
}
if($_POST['op'] == "showmoreemail")
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$respid = $_POST['respid'];
	$emailno = (int)$_POST['emailno'];
	
	$xml =new SimpleXMLElement("responses.xml", null, true);
      if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']"))
	  {
		   $response = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='E - Mail']");
		   $useremails = $response[0]->useremail;
		   $sentsub = $useremails[$emailno]->sent->subject;
		   $sentbody = $useremails[$emailno]->sent->messagebody->value;
		   echo "<div class = 'feedback smmargtop'> Sent Message : </div>";
		   echo "<div class = 'bg1 smpad'> <span class = 'wid30'> Subject : </span><span class = 'wid50'>$sentsub </span></div>";
		   echo "<div class = 'bg2 head3 pad' style = 'min-height:4rem;'> $sentbody </div>";
		      $recds = $useremails[$emailno]->recd;
		      $sizeofrecd = sizeof($recds);
		      if(sizeof($recds) == 1) { if(!($recds[0]->subject)) { $sizeofrecd = 0; } }             
			  if($sizeofrecd > 0)
		      {
			  foreach($recds as $recd) {
		      $recdsub = $recd[0]->subject;
		      $recdbody = $recd[0]->message; 
			  echo "<div class = 'orangebutton smmargtop'> Recieved Message : </div>";
			  echo "<div class = 'bg1 smpad'> <span class = 'wid30'> Subject : </span><span class = 'wid50'>$recdsub </span> </div>";
		      echo "<div class = 'bg2 head3 pad' style = 'min-height:4rem;'> $recdbody  </div>";                               }
			  }
		   else
		   {
			  echo "<div class = 'bg1 smpad'> No Messages Recieved. </div>";
		   }
	  }
}
if($_POST['op'] == "retryemail")
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$respid = $_POST['respid'];
	$emailno = (int)$_POST['emailno'];
	
	echo "<div class = 'feedback pad margtop'> Retry Sending Unsent Email :</div>";
	echo "<div class = 'margauto wid20 orangebutton smmargtop' onclick = \"retryemail('$username', '$formname', '$respid','$emailno')\"> Resend </div>";
}
//var param = "op=deleterechtml"+"&formname="+formname;
if($_POST['op'] == "deleterechtml")
{
$username = $_SESSION['user'];
$formname = $_POST['formname'];
?>

<div class = 'wid 100 pad margtop'>
<div class = 'head3 wid100'>
Are you sure you want to delete the the selected records ? 
</div>
<?php  echo "<div class = 'orangebutton floatl wid30' onclick =\"deleterecord('$formname')\"> Delete </div>"; ?>
<div class = 'bluebutton floatl wid30' onclick = closemodal()> Cancel </div>
<div class = 'clear'>

<?php	
}

//var param = "op=createfolderhtml"+"&formname="+formname;

if($_POST['op'] == "createfolderhtml")
{
$formname = $_POST['formname'];
?>
<div class = 'wid 100 pad margtop'>
<div class = 'head3 floatl wid30'>
Enter Folder Name :
</div>
<div class = 'input floatl wid50'>
<input type = 'text' id = 'foldername'  size="40" class = 'textfld' value = ''>

</div>
<div class="clear"></div>
</div>

<?php
echo "<div class = 'wid20 yellowbutton' onclick = \"createfolder('$formname')\"> Create Folder </div>";
	
}
 //var param = "op=openimage&formname="+formname+"&name="+name+"&email="+email+"&source="+source;
 if($_POST['op']=="openimage")
 {   
    $formname = $_POST['formname'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$source = $_POST['source'];
	
	 list($width, $height, $type, $attr) = getimagesize($source);  
	  if($width == $height)
	  {
		$imgwidth = 500;
		$imgheight = 500;  
	  }
	  else if($width > $height)
	  {
		  //get the ratio of width-height
		  $remaining = ($width-$height)/500;
		  $base =  ($width - ($width-$height))/500;
		  
		  $imgheightratio = 500/$base;
		  $imgheight = $base*$imgheightratio;
		  
		  $imgwidthratio = 500/($remaining+$base);
		  $imgwidth = (int)($remaining*$imgwidthratio + $base*$imgwidthratio);
		  
		  $imgheight = (int)($imgheight - ($imgwidthratio*$remaining));
					  
	  }
		else if($width < $height)
	  {
		  //get the ratio of width-height
		  $remaining = ($height-$width)/500;
		  $base =  ($height - ($height-$width))/500;
		  
		  $imgheightratio = 500/$base;
		  $imgheight = $base*$imgheightratio;
		  
		  $imgwidthratio = 500/($remaining+$base);
		  $imgheight = (int)($remaining*$imgwidthratio + $base*$imgwidthratio);
		  
		  $imgwidth = (int)($imgheight - ($imgwidthratio*$remaining));			  
	  }
	
	echo "<div class = 'feedback'> Form : $formname </div>";
	echo "<div class = 'bg1 smpad'> <div class = 'floatl wid50 '>Name : $name </div> <div class = 'floatr wid50'>E - Mail : $email </div><div class = 'clear'></div></div>";
	echo "<div class = 'smmargtop'>
	      <div class = 'wid50 margauto bg1'>
	      <div style= 'display:table-cell; align:center;' align='center' class = 'wid100'><img src = '$source' width='$imgwidth' height='$imgheight'></td>
		  </div>
		  </div>";
 }
?>