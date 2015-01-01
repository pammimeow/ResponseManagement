<?php
function addoptions($type, $field)
{
	 $xml =new SimpleXMLElement("optionvals.xml", null, true);
		
	 if($xml->xpath("/values/".$type."/option"))
	 {
	   $options = $field->addChild("options");
	   $ops = $xml->xpath("/values/".$type."/option");
	   
	   for($i=0;$i<sizeof($ops);$i++)
	   {
		   $options->addChild('option', $ops[$i]); 
	   }
	 }
	
	$xml = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?>
								<values>
								
								<radio>
								</radio>
								
								<select>
								</select>
								
								<check>
								</check>
								
								</values>
								");
	
	$xml->asXML("optionvals.xml");
	
}


function dispformfields($currform, $username, $from)
{
   
   if($from == "fc")
   {
   ownerHeader();
   }
   else
   {
   userHeader();
   }
   
   echo "<div class = 'section bg2 pad wid100 contentcol'>";
   if($currform == "new")
   {
   $formname = $_SESSION['formname'];
   }
   else
   {
   $formname = $currform;
   }
   
   $xml =new SimpleXMLElement("formelems.xml", null, true);
     
   if($xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field"))
	{   
	   
   $elems = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field");
   
   for($i=0; $i<sizeof($elems);$i++)
   {
	   $dispfldn = $elems[$i]->fldname;
	   $dispfldt = $elems[$i]->fldtype;
	   $essential = $elems[$i]->essential;
	   $regex = "";
	   
	   if($essential == "yes")
	   {
		  $essential = "<span class = 'highlightred margleft exsmfont'>*</span>";
	   }
	   else
	   {
		  $essential = "";   
	   }	
	   if($from == "fd") {
	   if($elems[$i]->regex)
	   { 
	      if(hasregex($username, $formname, $dispfldn))
		  {
	      $regex = "<span class = 'margleft alink' onclick = \"showregexinfo('$username', '$formname', '$dispfldn')\"><img src='images/infoicon.png' class = 'icon'></span>"; } } }
	  
	   echo   "<div class = 'wid100 smpad'>";
	   if($from == "fc")
       {
	   if($dispfldn == "Name" || $dispfldn == "E - Mail")
	   { 
	   echo   "<div class = 'head3 floatl wid5'><input type ='checkbox' disabled></div>";
	   }
	   else
	   {
		echo   "<div class = 'head3 floatl wid5'> <input type ='checkbox'></div>";   
	   }
	   }
	   echo "<div class = 'head3 floatl wid30'> $dispfldn $essential $regex</div> 
			 <div class = 'input floatl wid50'>";
	  
	  $fieldhtml = "";
	  // generating the right kind of field
	  switch($dispfldt)
	  {
		  case "text":
		  $fieldhtml = "<input type = 'text' name = '$dispfldn' size = '35' style = 'margin-left:2rem; padding:0.1rem;'>";
		  break;
		  
		  case "select":  
		  $fieldhtml = "<select name = '$dispfldn' style = 'margin-left:2rem; padding:0.1rem;'>";
		  
		  if($elems[$i]->options->option)
		  {
			     $options = $elems[$i]->options->option;
				  
				  foreach($options as $opt)
				  {
					$fieldhtml .= "<option value = '$opt' >".(string)$opt."</option>";
				  }
		  }
		  $fieldhtml .= "</select>";
		  break;
		  
		  
		  case "radio":
		  if($elems[$i]->options->option)
		  {
			     $options = $elems[$i]->options->option;
				 
				  $index =0;
				  $fieldhtml .= "<div style = 'margin-left:2rem; padding:0.1rem;' class = 'wid70'>";
				  foreach($options as $opt)
				  {
					 if($index == 0)
					 {
				     $fieldhtml .= "<input type = 'radio' name = '$dispfldn' value = '$opt' checked >".$opt."</input>";
					 }
					 else
					 {
					$fieldhtml .= "<input type = 'radio' style = 'margin-left:1rem; padding:0.5rem;' name = '$dispfldn' value = '$opt' >".$opt."</input>";
					 }
					 
					 $index++;
				  }
				  $fieldhtml .= "</div>";
		  }

		  break;
		  

		  
		  case "check":
		   if($elems[$i]->options->option)
		  {
			     $options = $elems[$i]->options->option;
				 
				  $index =0;
				  $fieldhtml .= "<div style = 'margin-left:2rem; padding:0.1rem;' class = 'wid70'>";
				  foreach($options as $opt)
				  {
					if($index == 0)
					 {
				  $fieldhtml .= "<input type = 'checkbox' name = '$dispfldn"."[]"."' value = '$opt' checked >".$opt."</input>";
					 }
					 else
					 {
					$fieldhtml .= "<input type = 'checkbox' style = 'margin-left:1rem; padding:0.1rem;'name = '$dispfldn"."[]"."' value = '$opt' >".$opt."</input>";
					 }
					 $index++;
				  }
				    $fieldhtml .= "</div>";
		  }
		  
		  break;
		  
		  case "datep":
		  $fieldhtml = "<input type='text' id='datepicker' name = '$dispfldn' class = 'datepicker' size = '35' style = 'margin-left:2rem; padding:0.1rem;'>";
		  break;
		  
		  case "image":
		  case "doc":
		  case "video":
		  case "audio":
		  $fieldhtml = "<input type='file' id='imgfile' name = '$dispfldn' style = 'margin-left:2rem; padding:0.1rem;'>";
		  break;
		  
		  case "tdesc":
		  $fieldhtml = "<textarea id='tdescfile' name = '$dispfldn' rows = '10' cols = '30' style = 'margin-left:2rem; padding:0.1rem;'></textarea>";
		  break;
	  }	  
	  
	  echo $fieldhtml;
	  if($currform == "new")
	  {
		$form = $_SESSION['formname'];  
	  }
	  else
	  {
	    $form = $currform;   
	  }
	  echo   "</div>"; // closed div input class 
	  
	  if($from == "fc")
	  {
		  addedit($dispfldn,$_SESSION['user'], $_SESSION['formname']);
		  addRegex($i, $form, $dispfldn, $dispfldt);
		  addDel($i, $form, $dispfldn);
	  }  
	  echo "<div class = 'clear'></div>";
	  echo "</div>";
  
   }// for end

   if($from == "fd")
   {
	   addusersub();  
   }
   
   }
   else
   {
	   if(!(isset($_SESSION['new'])))
	   {
	   // when there are no fields in the form.
	   echo "<div class = 'pad'>
             <div class = 'wid100 smmarg'>
			 <div class = 'head3 floatl wid30'> Name </div>
			<div class = 'input floatl wid50'> <input type = 'text' name = 'name'   disabled> </div>
			</div>
			
			<div class = 'clear'></div>
			
			<div class = 'wid100 smmarg'>
			<div class = 'head3 floatl wid30'> E-Mail </div>
			<div class = 'input floatl wid50'> <input type = 'text' name = 'email' disabled> </div>
			</div>
			
			<div class = 'clear'></div>
			</div> <!-- end of bg1 pad -->
			</div>
			";
	      }// end of session new
   }
   
      echo "<div class = 'clear'></div></div>";
   // container div closed down
}

function ownerHeader()
{
   echo "<div class = 'feedback wid100 smmargtop'>
		<div class = 'floatl wid70'>Your form has these fields : </div> <!-- closed -->
		<div class = 'helpicon floatl wid10 margleftmid orgdiffshadebg' onclick = help()>?</div> <!-- closed -->
		<div class = 'clear'></div> <!-- closed -->
		</div> <!-- parent outer menuelem wid100 -->
       
	   <div class ='wid100 subtitle'>
	   These fields do not depict exact form behaviour. 
	   </div>
	   <div class = '' id = 'fieldmsg'>
		";
}

function userHeader()
{
   echo "<div class = 'feedback wid100'>
		<div class = 'floatl wid70'>Fill in the form below : </div> <!-- closed -->
		<div class = 'helpicon floatl wid10 margleftmid orgdiffshadebg' onclick = help()>?</div> <!-- closed -->
		<div class = 'clear'></div> <!-- closed -->
		</div> <!-- parent outer menuelem wid100 --> 
   
   <div class = '' id = 'fieldmsg'>
   </div>
   <form action = 'filehandle.php' method = 'post' enctype='multipart/form-data'>
   <input type = 'hidden' name = 'location' value = 'formDisplay.php'>
   ";
}
	
function addedit($dispfldn, $username, $formname)
{
   	   if($dispfldn == "Name" || $dispfldn == "E - Mail")
	   { 
	   echo   "<div class = 'head3 floatl wid5'> <img src='images/none.png' class = 'icon'></div>";
	   }
	   else
	   {
		echo   "<div class = 'head3 floatl wid5' onclick = \"editfldhtml('$username','$formname','$dispfldn')\"> <img src='images/edit.png' class = 'icon'></div>";   
	   }	
}

function addDel($i, $form, $dispfldn)
{
	 if($dispfldn == "Name" || $dispfldn == "E - Mail")
	   { 
	   echo   "<div class = 'head3 floatl wid5'> <img src='images/none.png' class = 'icon'></div>";
	   }
	   else
	   {
	   echo  "<div class = 'floatl wid5' onClick=\"delfld('$form',$i)\"><img src='images/delete.png' class = 'icon'>  </div> 
			  ";
	   }
	   
	   //echo "<div class = 'clear'></div>";
}

function addRegex($i, $form, $dispfldn, $dispfldt)
{
		 if($dispfldn == "Name" || $dispfldn == "E - Mail")
	   { 
	   echo   "<div class = 'head3 floatl wid5'> <img src='images/none.png' class = 'icon'></div>";
	   }
	   else
	   {
	   if(!($dispfldt == "check" || $dispfldt == "select" || $dispfldt == "radio"))
	   {
	   echo  "<div class = 'floatl wid5' onClick=\"showregexhtml('$form','$dispfldn', '$dispfldt')\"><img src='images/regex.png' class = 'icon'>  </div> 
			 ";
	   }
	   else
	   {
	  echo   "<div class = 'head3 floatl wid5'> <img src='images/none.png' class = 'icon'></div>";
	   }
	   }
	   
}

function addusersub()
{
  echo   "<input type = 'submit' name = 'subform' class = 'orangebutton wid20 margauto textcenter' value = 'Submit Form' style='margin-top:4rem;'>
  <div class = 'wid100 smmarg smpad'><input type = 'checkbox' name = 'emailme' checked><span class ='head3'> Send me a copy of this response </span> </div>
         </form>
		  ";
}
function showreceps($username, $formname)
{
	$xml =new SimpleXMLElement("reciepients.xml", null, true);
    
	if(hasformreceps($username, $formname) == true)
	{
	   if($xml->xpath("/users/user[username='$username']/form[formname='$formname']/reciepients/reciepient"))
		{ 
		   $reciepients = $xml->xpath("/users/user[username='$username']/form[formname='$formname']/reciepients/reciepient");
		   
		   for($i=0;$i<sizeof($reciepients);$i++)
		   {
			  $name = $reciepients[$i]->name;
			  $email= $reciepients[$i]->email;
			  
			  if($name == "")
			  {
				 $name = "Unspecified";  
			  }
			  
			  echo "<div class = 'wid 100 smmarg pad'>
					<div class = 'head3 floatl wid5'>
					<input type ='checkbox'>
					</div>
					<div class = 'head3 floatl wid5'>
					<img src='images/edit.png' class = 'icon' onclick = \"editrecephtml('$username', '$formname', '$email')\")'> 
					</div>
					<div class = 'head3 floatl wid30'>
					$name
					</div>
					<div class = 'input floatl wid50'>
					$email;
					</div>
					<div class = 'head3 floatl wid10'>
					<img src='images/delete.png' class = 'icon' onclick = \"deleterecephtml('$username', '$formname', '$email')\")'> 
					</div>
					<div class = 'clear'> </div>
					</div>
					";
				 
		   }
			echo "<div class = 'wid30 bluebutton margtop'>Send Request</div>";
		}
	}//if(hasformreceps($username, $formname) == true)
	else
	{
		echo "<div class = 'bg1 pad' style='margin:1rem;'>No Reciepients Added</div>
			  <div class = 'wid30 graybutton margtop'>Send Request</div>";
	}
}
function hasformreceps($username, $formname)
{
	$xml =new SimpleXMLElement("reciepients.xml", null, true);
     
   if($xml->xpath("/users/user[username='$username']/form[formname='$formname']/reciepients/reciepient"))
	{  return true;  }
	else
	{ return false ;}
}
function createfloattabs($arrayelems, $width, $enabledelems)
{
	echo "<div id = 'floatelems'>";
	foreach($arrayelems as $elem)
	{
		if(sizeof($enabledelems) > 0) {
		if(in_array($elem, $enabledelems))
		{ $class = 'enabletab pad wid40 floatl'; $img = "images/disabledeactive.png"; }
		else { $class = 'disabletab pad wid40 floatl'; $img = "images/disable.png"; }
		}
		else
		{ $class = 'enabletab pad wid40 floatl'; $img = "images/disabledeactive.png";  }
		
		$idvalimg = 'elemidimg'.$elem;
		$idval = 'elemid'.$elem;
		echo "<div class = 'floatl bg1 ".$width."'>
		      <div class = 'margauto wid50'>
		      <div class = '$class' id = '$idval'>
		      $elem
			  </div>
			  <div class = 'wid20 margauto floatl smmargtop margleft' onClick=\"toggleactiveopt('$idvalimg', '$idval')\">
		      <img src='$img' class = 'icon' id = '$idvalimg' data-en='en'>
			  </div>
			  <div class = 'clear'></div>
			  </div>
			  </div>";
	}
	echo "<div class = 'clear'></div>
	      </div>";
}

function hasregex($username, $formname, $fieldname)
{
	$hasregex = false;
	$xml =new SimpleXMLElement("formelems.xml", null, true);
	if($xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fieldname']/regex"))
	{
		$field = $xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fieldname']");
		$fldtype = $field[0]->fldtype;
        if($fldtype == "text"  || $fldtype == "tdesc") {
		  $textboxtype = $field[0]->textboxtype;
		  if($textboxtype == "chars") { $fldtype = "chars"; } 
		  if($textboxtype == "nums") { $fldtype = "nums"; } }
		  
		  $regex = $field[0]->regex;
		  $regtype = $regex[0]->type;
		  if($regtype == "standard") {
			if($fldtype == "chars" || $fldtype == "tdesc")
			{ $startswith = $regex[0]->startswith;
			  if($startswith != "") { $hasregex = true; }
			  $endswith = $regex[0]->endswith;
			  if($endswith != "") { $hasregex = true; }
			  $length = $regex[0]->length;
			  if($length != "") { $hasregex = true; }
		                             
		     }// if $fldtype == text	 
		else if($fldtype == "nums") { 
		       $startrange = $regex[0]->startrange;
			  if($startrange != "") { $hasregex = true; }
			  $endrange = $regex[0]->endrange;
			  if($endrange != "") { $hasregex = true; }
			  }// if $fldtype == nums	
			  
		 else if($fldtype == "image" || $fldtype == "video" || $fldtype == "doc")
		      { $elems = $field[0]->regex->elems->elem;
			    if(sizeof($elems) > 0) { $hasregex = true; }
			  }
		 } //if($regtype == "standard") 
		else if($regtype == "length") {
			$length = $regex[0]->length;
			if($length != "") { $hasregex = true; }
		}
		else if($regtype == "custom")
		{ $custregex = $regex[0]->custregex;
		  if($custregex != "") { $hasregex = true; }
		}
	}
	return $hasregex;
}
function getrespondersname($email, $formname, $username)
{
  $xml =new SimpleXMLElement("reciepients.xml", null, true);
  $recepname = "Unspecified";
  if($xml->xpath("/users/user[username = '$username']/form[formname = '$formname']/reciepients/reciepient[email='$email']"))
	  {
		 $reciepient = $xml->xpath("/users/user[username = '$username']/form[formname = '$formname']/reciepients/reciepient[email='$email']");
		 $recepname = (string)$reciepient[0]->name;
	  }

  return $recepname;
}
function getmaxemails($username, $formname)
{
    $xml =new SimpleXMLElement("responses.xml", null, true);
    $maxemail = 0;
    if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response"))
	{  

		foreach($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response/field[fldname='E - Mail']") as $response)
		{
			$useremails = $response[0]->useremail;
			if(sizeof($useremails) > $maxemail) { $maxemail = sizeof($useremails); }
		}
	}
	return $maxemail;
}

?>