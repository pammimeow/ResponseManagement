<?php
session_start();

include_once('includeFunctions.php');

if($_POST['op'] == "subformname")
{	
	/*check normal field constraints.
	check if formname already exists and if does then prompt to enter another */
		
	 $formname = $_POST['fname'];
	 $sessuser = $_SESSION['user'];
	 $xml =new SimpleXMLElement("formelems.xml", null, true);
     $elems = $xml->xpath("/elems/users");
	 
	 // check if the form name already exists. 
	 if($xml->xpath("/elems/users/user[username='$sessuser']/form[formname='$formname']"))
	 {
		 // check if the form name already exists then send error code. 
		 echo "errorcode5555#This Formname Already Exists. Please choose a different Formname";
	 }
	 else 
	 {
		 
	 if($xml->xpath("/elems/users/user[username='$sessuser']"))
	 {
		 $user = $xml->xpath("/elems/users/user[username='$sessuser']");
		 
		 $form = $user[0]->addChild('form');
		 $form->addChild('formname', $formname);
     }
	 else
	 {
		 $user = $elems[0]->addChild('user');
		 $user->addChild('username', $sessuser);
		 $form = $user->addChild('form');
		 $form->addChild('formname', $formname);
	 }
	 
	 $fields = $form->addChild('fields');
	 $field = $fields->addChild('field');
	 $field->addChild('fldname', 'Name');
	 $field->addChild('fldtype', 'text');
	 $field->addChild('essential', 'yes');
	 $field->addChild('textboxtype', 'chars');
	 $field->addChild('subtype', 'textother');
	 
	 $field = $fields->addChild('field');
	 $field->addChild('fldname', 'E - Mail');
	 $field->addChild('fldtype', 'text');
	 $field->addChild('essential', 'yes');
	 $field->addChild('textboxtype', 'chars');
	 $field->addChild('subtype', 'email');
	 
	 $_SESSION['formname'] = $formname;
	 $_SESSION['new'] = $formname;
	 echo " formname is ".$_SESSION['formname'];
	 $xml->asXML("formelems.xml");
	 
	 }
}

if($_POST['op'] == "addoption")
{
	 $type = $_POST['type'];
	 $opval = $_POST['opval'];
	 
	 $xml =new SimpleXMLElement("optionvals.xml", null, true);
     $elems = $xml->xpath("/values/".$type);
	 $elems[0]->addChild('option',$opval);
	 $xml->asXML("optionvals.xml");
}

if($_POST['op'] == "deletefld")
{
	$username = $_SESSION['user'];
	$formname = $_POST['form'];
	
	$index = $_POST['index'];
	echo "form ".$formname." index ".$index;
	$xml =new SimpleXMLElement("formelems.xml", null, true);
 
    $iterate = 0;	
	foreach($xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field") as $fld)
{
	if($iterate == $index)
	{
     	unset($fld[0]);
		break;
	}
	$iterate++;
}
	$xml->asXML("formelems.xml");
	
}

if($_POST['op'] == "finalform")
{
	unset($_SESSION['new']);
}

if($_POST['op'] == "deleteform")
{
	$formname = $_POST['form'];
	$username = $_SESSION['user'];
	
	if($formname == $_SESSION['new'])
	{
		unset($_SESSION['new']);
	}
	
	$xml =new SimpleXMLElement("formelems.xml", null, true);
	
	if($xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']"))
	{
		foreach($xml->xpath("/elems/users/user[username='$username']/form") as $form)
		{
		   if($form[0]->formname == $formname)
		   {
			   unset($form[0]);
			   $xml->asXML("formelems.xml");
			   break;
		   }
		}
	}
	
}

if($_POST['op'] == "createlink")
{
	$formname = $_POST['form'];
	$username = $_SESSION['user'];
	
	$xml =new SimpleXMLElement("formelems.xml", null, true);
	
	if($xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']"))
	{
		$form = $xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']");
		
		$link = "http://localhost/Assignment/Portfolio/responseMgmt/research/formDisplay.php?user=".$username+"&form=".$formname;
		$form[0]->appendChild('link', $link);
		$xml->asXML("formelems.xml");
	}
}


if($_POST['op'] == 'getsearches')
{
$op = $_POST['op'];
$username = $_POST['user'];
$formname = $_POST['form'];

$offset = 220;
$currleft = 100;
$top = 10;
$topoffset = 40;
$topratiomax = 1;
// see if there are any responses. 
  $xml =new SimpleXMLElement("responses.xml", null, true);
  if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response")) 
  {
  // creating headers
  $xml =new SimpleXMLElement("formelems.xml", null, true);
     
   if($xml->xpath(  "/elems/users/user[username='$username']/form[formname='$formname']/fields/field"))
	{  
	   $fields = $xml->xpath(  "/elems/users/user[username='$username']/form[formname='$formname']/fields/field");
	   
	   if(sizeof($fields) > 6)
	   {
		   //echo "<img src='images/rtarrow.jpg' class = 'floatr wid5'>";
	   }
	   echo "<div style='position:relative; left:0px; top : 0px;'>";
	   for($i=0;$i<sizeof($fields);$i++)
	   {
	   $top = 35;
	   $fldname = $fields[$i]->fldname;
	   $fldtype = $fields[$i]->fldtype;
       
	   if(!($fldtype == "image" || $fldtype == "video" || $fldtype == "doc" || $fldtype == "audio"))  {
		   $inputidfld = $fldname."input";
		   $stsearchid = $fldname."search";
		   $closesearchid = $fldname."close";
		   $elemid = $fldname."elem";
		   $datepclass = "";
		   if($fldtype == "datep") { $datepclass = "datepicker"; } 
	   	   echo "<div style='position:absolute; left:".$currleft."px; top : ".$top."px; min-width:".$offset."px;' class = 'searchbox'><img src='images/search.png' class = 'icon' onclick = \"prepsearch('$fldname')\" id = '$elemid'><input type = 'hidden' id = '$inputidfld' size = 18 class = '$datepclass' style='padding:0.1rem;'><img src='images/selectdis.png' class = 'icon smmargleft' id = '$stsearchid' style='display:none;' onclick = \"savesearch('$username','$formname','$fldname')\"><img src='images/closeicon.png' class = 'icon smmargleft' id = '$closesearchid' style='display:none;' onclick = \"closesearch('$fldname')\"></div>";	
	}
	 $currleft = $currleft + $offset;
   }// close for
   $maxemail = getmaxemails($username, $formname);
   $fldname = "useremail";
   for($i=0;$i<$maxemail;$i++)
   {
   $stsearchid = "usearch".$i;
   $closesearchid = "uclose".$i;
   $elemid = "uelem".$i; 
   $inputidfld = "useremail".$i; 
   echo "<div style='position:absolute; left:".$currleft."px; top : ".$top."px; min-width:".$offset."px;' class = 'searchbox'><img src='images/search.png' class = 'icon' onclick = \"prepsearch('useremail', '$i')\" id = '$elemid'><input type = 'hidden' id = '$inputidfld' size = 18 class = '$datepclass' style='padding:0.1rem;'><img src='images/selectdis.png' class = 'icon smmargleft' id = '$stsearchid' style='display:none;' onclick = \"savesearch('$username','$formname','useremail', '$i')\"><img src='images/closeicon.png' class = 'icon smmargleft' id = '$closesearchid' style='display:none;' onclick = \"closesearch('useremail', '$i')\"></div>"; 
    $currleft = $currleft + $offset;
   }
   echo "</div>";
  } // if for xml response field check
  }// if responses >0
  else
  {
	 // no responses found 
	 echo "<div class = 'feedback' style='position:absolute; left:".$currleft."px; top : ".$top."px;'> No Responses were submitted to the form.  </div>";
  }
}// close of if post
// for viewing the responses.
if($_POST['op'] == 'viewresp')
{
$op = $_POST['op'];
$username = $_POST['user'];
$formname = $_POST['form'];
$newparams = array();
$foundresp = false;
//echo "size of post array is ".sizeof($_POST);
foreach($_POST as $key=>$arrelem) { if(!($key == "op" || $key == "user" || $key == "form"))                          // getting new param elems
                                     { $newparams[$key] = $arrelem; }
                                   }
$offset = 220;
$currleft = 100;
$top = 10;
$topoffset = 40;
$topratiomax = 1;

$echostr = "";

$echostr = "<div style='position:relative; left:0px; top : 0px;'>";
  
  // creating headers
  $xml =new SimpleXMLElement("formelems.xml", null, true);
     
   if($xml->xpath(  "/elems/users/user[username='$username']/form[formname='$formname']/fields/field"))
	{  
	   $fields = $xml->xpath(  "/elems/users/user[username='$username']/form[formname='$formname']/fields/field");
	   
	   if(sizeof($fields) > 6)
	   {
		   //echo "<img src='images/rtarrow.jpg' class = 'floatr wid5'>";
	   }
	   
	   for($i=0;$i<sizeof($fields);$i++)
	   {
	   $top = 35;
	   $fldname = $fields[$i]->fldname;
	   $fldtype = $fields[$i]->fldtype;
       // for search bar adition
	   $top = $top + 40;
	  
	   $echostr .= "<div style='position:absolute; left:".$currleft."px; top : ".$top."px; width:".$offset."px;z-index:1;' class = 'fieldbox'>".$fldname."</div>";	   
	   
	   $currleft = $currleft + $offset;
	   }
	   $maxemail = getmaxemails($username, $formname);
	   for($i=0;$i<$maxemail;$i++)
	   { $echostr .= "<div style='position:absolute; left:".$currleft."px; top : ".$top."px; width:".$offset."px;' class = 'fieldbox'>User Email</div>";	
	   $currleft = $currleft + $offset;
	   }
	   //$echostr .= "</div>";
	   echo $echostr;
	}
	
	
  $echostr = "";
	 // loading responses
  $xml =new SimpleXMLElement("responses.xml", null, true);
     
  if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response"))
	  {
	   $responses = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response");
	   
	   for($i=0;$i<sizeof($responses);$i++)
	   {
	   // setting origin position
	   $topoffset = 50;
	   $currleft = 25;
	   $top = $top + ($topratiomax * $topoffset);
	   $topratiomax = 1;
	   $respid = $responses[$i]->respid;
	   $canshow = true;
	   
	   foreach($newparams as $keyfield=>$keyfieldval) {
		                               if (strpos($keyfield,'useremail') !== false)
									   { $emailindex = explode("useremail", $keyfield);                                        $emailindex =(int)$emailindex[1];          
									     $iffield = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='E - Mail']"); 
			$useremails = $iffield[0]->useremail;
			if(sizeof($useremails) >= $emailindex) {
			$allemails = $iffield[0]->useremail;
			
			$searchstr = (string)$allemails[$emailindex]->sent->subject;
			$searchstr .= (string)$allemails[$emailindex]->sent->messagebody->value;            $recds = $allemails[$emailindex]->recd;
			if($recds[0]->subject) { foreach($recds as $recd) {
			$searchstr .= (string)$recd[0]->subject;
			$searchstr .= (string)$recd[0]->message;                                              }} // close for and if
			if(!(preg_match("/".$keyfieldval."/i",$searchstr))) { $canshow = false; }
			} else   // if($iffield[0]->useremail)
			{  $canshow = false; }
			} //close upper two ifs
									   else {
		                                $searchfld = str_replace("_"," ", $keyfield);
										$iffield = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='$searchfld']");
										$storedval = $iffield[0]->value;
	  if($keyfieldval != "")      {
	  if(sizeof($storedval) == 1) {
	  if(!(preg_match("#".$keyfieldval."#",$storedval))) { $canshow = false; break; }
		                                               } }
	  else { $mulcontains = false; 
	         foreach($storedval as $val) 
			 { 
			  if(preg_match("/".$keyfieldval."/i",$val)){ $mulcontains = true; break;}
			 } 
			 if($mulcontains == false) { $canshow = false; }
		   } } } // end of for
	   if($canshow == true) 
	   {
	   if(sizeof($newparams) > 0) { // add resp checked value. 
	   $response = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']");
	   if($response[0]->checked) { 
	   if((string)$response[0]->checked != "off")
	   { $response[0]->checked = "true"; } }
	   else { $response[0]->addChild('checked', 'true'); }
	   $xml->asXML("responses.xml");
	   }
	   // check if input box is checked. 
	   $checked = "";
	   if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/checked"))
	   { $checked = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/checked");  
	     if($checked[0] == "true" || $checked[0] == "on") { $checked = "checked"; } }
	   $foundresp = true;
       $echostr .= "<div style='position:absolute; left:".$currleft."px; top : ".$top."px; width:25px;' class = 'smmargtop'><input type ='checkbox' onclick = \"check('$username', '$formname', '$respid')\" ".$checked."></div>";
	   $currleft = $currleft + 25;
	   
	    // adding buttons to operate on responses
	     
	   $field = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='E - Mail']");
	   
	   $email = (string)$field[0]->value;
	   $echostr .= "<div style='position:absolute; left:".$currleft."px; top : ".$top."px; width:50px;' class = 'respoptions'> <span class = ''  onclick = \"sendemail('$username', '$formname', '$respid', '$email', 'false', '')\"'> <img src='images/mail.png' class ='icon'> </span></div>";
	   
	   $currleft = $currleft + 50;
	   // added buttons to operate on responses
	   
	   // preparing to display the data of the row. 
	   $fields = $responses[$i]->field;
	   
	   for($j=0;$j<sizeof($fields);$j++)
	   {
		   $valuestr = "";
		   $topoffratio = 1;
		   $values = $fields[$j]->value;
		   $type = $fields[$j]->fldtype;
		   
		   $fieldname = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='Name']");
			$name = $fieldname[0]->value;
  		   $id = str_replace(" ", "_", $name).$j;

		   if($type == "image" || $type == "doc" || $type == "audio" || $type == "video")
		   { 
		    $fieldname = $xml->xpath("/responses/users/user[username = '$username']/form[formname ='$formname']/response[respid='$respid']/field[fldname='E - Mail']");
			$email = $fieldname[0]->value;
		   if(strlen($values) >0) { 
		   if($type == "image") {
		   $valuestr .= "<div class = 'wid100 orangebutton'  onclick =\"openimage('$formname', '$name', '$email','$values')\"> Open Image </div>"; } 
		   else if($type == "doc")
		   { $valuestr .= "<a href = '$values' class='link'><div class = 'wid100 orangebutton'  onclick =\"opendoc('$formname', '$name', '$email','$values')\"> Open Document </div></a>"; }
		    } }
		   else {
		   if(sizeof($values) > 1)
		   {
			 // multiple value display  
			 foreach($values as $value)
			 { if(strlen($value) > 0)   { 
			 $valuestr .= "<div class = ''>".(string)$value."</div>"; 
			 $topoffratio = $topoffratio + 1; 
			                           if(strlen($value) > 150) { $remlen = strlen($valuestr) - 150; 
			                            $ratio = $remlen / 150;
										$topoffratio = $topoffratio + $ratio;                                          } }  }
		   }
		   else
		   {
			    $valuestr .= "<div class = '' onMouseOver=bringontop('$id') onMouseOut=bringbottom('$id')>".(string)$values."</div>";
			   if(strlen($valuestr) > 150) { $remlen = strlen($valuestr) - 150; 
			                                 $ratio = $remlen / 150;
											 $topoffratio = $topoffratio + $ratio;                                            }
		   }}//if(strlen($value) > 0)  and else of type == "image" etc
		   
		   $echostr .= "<div id = '$id' style='position:absolute; left:".$currleft."px; top : ".$top."px; min-width:".$offset."px;' class='respcell' onMouseOver=bringontop('$id') onMouseOut=bringbottom('$id')>".$valuestr."</div>";
		   $currleft = $currleft + $offset;
		   if($topoffratio > $topratiomax)  { $topratiomax = $topoffratio; }
	   }// for end for field vals for responses. 
	   $useremailfld = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='E - Mail']");
	   $useremails = $useremailfld[0]->useremail;
	   if(sizeof($useremails) >0) { if($topratiomax == 1) {$topratiomax = 2;} }
	   $uemailindex = 0;
	   $emailno = 0;
	   foreach($useremails as $useremail)
	   {
		   $subject = $useremail->sent->subject;
		   $msgbody = $useremail->sent->messagebody->value;
		   $recd = $useremail->recd;
		   $sentorno=$useremail->sentorno;
		   $parentid = "par".$uemailindex;
		   $echostr .= "<div style='position:absolute; left:".$currleft."px; top : ".$top."px; min-width:".$offset."px;' id = '$parentid' class='respcell'><div class ='wid100 bg1'> $subject </div><div class ='wid100'>".substr($msgbody,0,30)."</div><div class ='wid100 bg1'><img src = 'images/responseicon.jpg' class = 'wid30 floatl icon smmargleft' onclick = \"showmore('$username', '$formname', '$respid','$emailno')\">";
		   if($sentorno == "false")
		   { $echostr.="<div class = 'wid10 floatl smmargleft' onclick = \"retryemailhtml('$username', '$formname', '$respid','$emailno')\"><img src = 'images/retryicon.png' class ='icon'></div>"; } 
		   else
		   {// show how many responses are recieved.
		   $sizeofrecd = sizeof($recd);
		   if(sizeof($recd) == 1) { if(!($recd[0]->subject)) { $sizeofrecd = 0; } }
		   $echostr .= "<div style = 'background-color:#0c0; border-radius:1rem;height:1rem;width:1rem;' class = 'wid10 floatl smmargleft whitefont exsmfont'>".$sizeofrecd."</div>";
		   }
		   $fwdid = "fwd".$uemailindex;
		   $repid = "rep".$uemailindex;
		   $echostr.="<div class = 'wid10 floatr smmargright' onclick = \"sendemail('$username', '$formname', '$respid', '', 'false', '$msgbody', '$parentid')\" id = '$fwdid'><img src = 'images/forwardicon.png' class ='icon'></div><div class = 'wid10 floatr smmargright' onclick = \"sendemail('$username', '$formname', '$respid', '$email', 'false', '', '$parentid')\" id = '$repid'><img src = 'images/replyicon.png' class ='icon'></div></div></div>";
		   $currleft = $currleft + $offset;
		   $uemailindex = $uemailindex + 1;
		   $emailno = $emailno + 1;
	   }// end of for for user emails.
	   } // end of if can show. 
	   }// end of for for responses check. 
	   
	   $echostr .= "</div>";
	   if($foundresp == false && sizeof($newparams) > 0) { //$echostr .= "<div class = 'wid100 floatr smmargright' style= 'position:absolute;left:0px;top:0px;'> There were no responses found for this form or for the search predicate that you entered. </div>"; 
	   }
	   if(sizeof($responses) == 0) {  }
	   echo $echostr;
	}
	
    echo "<div class = ''> &nbsp; </div>";
}


if($_POST['op']== "savefolder")
{
   $foldername = $_POST['foldername'];
   $sendparam = $_POST['sendparam'];
   $formname = $_POST['formname'];
   $username = $_SESSION['user'];
   //echo "send param is ".$sendparam;
   $xml =new SimpleXMLElement("responses.xml", null, true);
     
    if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']"))
	{
		$form = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']");
		if($form[0]->folders) { $folders = $form[0]->folders; }
		else { $folders = $form[0]->addChild('folders');}
		$folder = $folders->addChild('folder');
		$folder[0]->addChild('foldername', $foldername);
		$folder[0]->addChild('param', $sendparam);
		$xml->asXML("responses.xml");
	}
}
if($_POST['op'] == "showsearchfolders")
{
	 $formname = $_POST['formname'];
	 $username = $_SESSION['user'];
	 $xml =new SimpleXMLElement("responses.xml", null, true);
     
    if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/folders"))
	{
		$folders = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/folders/folder");
		echo "<div class = '' id = 'userfolders'>";
		foreach($folders as $folder)
		{ $foldername = $folder[0]->foldername;
		  $param = $folder[0]->param;
		  //echo "foldername ".$foldername;
		  echo "<div class = 'wid100 menuelem alink' onClick=\"showsearch('$param')\"> $foldername</div>"; 
	    }
		echo "</div>";
	}
}
//var param = "op=showfolders&formname="+formname;
if($_POST['op'] == "showfolders")
{
	 $formname = $_POST['formname'];
	 $username = $_SESSION['user'];
	 $xml =new SimpleXMLElement("responses.xml", null, true);
     
    if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/userfolders"))
	{
		$folders = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/userfolders/folder");
		echo "<div class = ''>";
		echo "<div class = 'wid100 orangebutton' onClick=\"createfolderhtml('$formname')\"> Create Folder </div>"; 
		foreach($folders as $folder)
		{ $foldername = $folder[0]->foldername;
		  //echo "foldername ".$foldername;
		  echo "<div class = 'wid100 menuelem alink' onClick=\"showfolder('$foldername')\"> $foldername</div>"; 
	    }
    	  echo "</div>";

	}
}

if($_POST['op'] == "showvertical")
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$respid = $_POST['respid'];
	$echostr = "";
	
	$xml =new SimpleXMLElement("responses.xml", null, true);
     
    if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']"))
	{
        $response = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']");
		
        $field = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='Name']");
		
		$fromuser = (string)$field[0]->value;
		
		$field = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='E - Mail']");
	   
	   $email = (string)$field[0]->value;
	   
	    // displaying the form name and the name of the responder
		$echostr .= "<div class = 'feedback'> <p>Form name : $formname</p> 
		                                      <p>From User : $fromuser</p>
										      </div>";
										   
		$echostr .= "<div class = 'head'> 
		            <span class = 'orangebutton' onclick = \"sendemail('$username', '$formname', '$respid', '$email', '')\"> Send E-Mail </span>
					<span class = 'orangebutton'> Delete </span>
					</div>";
		
		$echostr .= "<div class = 'margtop'>";					
		$fields = $response[0]->field;
		
		for($i=0;$i<sizeof($fields);$i++)
		{
			$fldname = $fields[$i]->fldname;
			$value = $fields[$i]->value;
			echo "value is ".$value;
			$echostr .= "<div class = 'wid100 smmarg'>
			             <div class = 'head3 floatl wid30'>
						 $fldname
						 </div>
						 <div class = 'head3 floatl wid30'>
						 $value
						 </div>
						 <div class = 'clear'></div>
						 </div>";
			
			
		}
		$echostr .= "</div>";
	}
	echo $echostr;
}

if($_POST['op'] == "email")
{	
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$respid = $_POST['respid'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$emailid = uniqid('email');
	
	// adding the sent response to responses.xml
	 $xml =new SimpleXMLElement("responses.xml", null, true);
     
	foreach($_SESSION['receparray'] as $email)
	{
    if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response/field[fldname='E - Mail' and value='$email']"))
	{   
		$response = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response/field[fldname='E - Mail' and value='$email']");
		$useremail = $response[0]->addChild('useremail');
		$useremail->addChild('emailid', uniqid('email'));
		$sent = $useremail->addChild("sent");
		$sent->addChild('subject', $subject);
		$messagebody = $sent->addChild('messagebody');
        $messagebody->value = "".$message."";
		$useremail->addChild('recd','');
   
	$sendmessage = $message."<div><a href = 'http://localhost/Assignment/Portfolio/responseMgmt/research/useremailresp.php?user=$username&form=$formname&respid=$respid&emailid=$emailid'> Click here </a> to respond </div>";
	// sending email
	$succ = @mail($email, $subject, $sendmessage); 
	if($succ)
	{
		echo "E-Mail Successfully Sent to ".$email;
		$useremail->addChild('sentorno', 'true');
	}
	else
	{
		echo "<div class = 'bg1 pad' style='margin:0.5rem;'>E-Mail Not Sent to ".$email."</div>";
     	$useremail->addChild('sentorno', 'false');
	}
	$xml->asXML("responses.xml");
	}// end of if for xml check
   	}// end of foreach
}

if($_POST['op']=="addrecep")
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$reciepientemail = $_POST['recepemail'];
	$reciepientname = $_POST['recepname'];
	
	 $xml =new SimpleXMLElement("reciepients.xml", null, true);
     
    if($xml->xpath("/users/user[username = '$username']/form[formname = '$formname']/reciepients"))
	{
		// reciepients exists
		$reciepients = $xml->xpath("/users/user[username = '$username']/form[formname = '$formname']/reciepients");
		$reciepients = $reciepients[0];
	}
	else if($xml->xpath("/users/user[username = '$username']/form[formname = '$formname']"))
	{
		// formname exists.Add first reciepient
		$form = $xml->xpath("/users/user[username = '$username']/form[formname = '$formname']");
		$reciepients = $form[0]->addChild('reciepients');
	}
	else if($xml->xpath("/users/user[username = '$username']"))
	{
		// username exists.Add formname
		$user = $xml->xpath("/users/user[username = '$username']");
		$form = $user[0]->addChild('form');
		$form->addChild('formname', $_POST['formname']);
		$reciepients = $form->addChild('reciepients');
	}
	else
	{
	   // add the username	
	   $users = $xml->xpath("/users");
	   $user = $users[0]->addChild('user');
	   $user->addChild('username', $_POST['username']);
	   $form = $user->addChild('form');
	   $form->addChild('formname', $_POST['formname']);
	   $reciepients = $form->addChild('reciepients');
	}
	
	$reciepient = $reciepients->addChild('reciepient');
	$reciepient->addChild('name', $reciepientname);
	$reciepient->addChild('email', $reciepientemail);
	$reciepient->addChild('sent', "false");
	$reciepient->addChild('source', "own");
	
	$xml->asXML("reciepients.xml");
}

if($_POST['op']=="updatereceps")
{
   $username = $_POST['username'];
   $formname = $_POST['formname'];
   
   showreceps($username, $formname);	
}

if($_POST['op']=="editrecep")
{
   $username = $_POST['username'];
   $formname = $_POST['formname'];
   $recepemail = $_POST['recepemail'];
   $newrecepemail = $_POST['newrecepemail'];
   $reciepientname = $_POST['recepname']; 
   
   $xml =new SimpleXMLElement("reciepients.xml", null, true);
     
    if($xml->xpath("/users/user[username = '$username']/form[formname = '$formname']/reciepients/reciepient[email='$recepemail']"))
	{
		$reciepient = $xml->xpath("/users/user[username = '$username']/form[formname = '$formname']/reciepients/reciepient[email='$recepemail']");
		$reciepient[0]->name = $reciepientname;
		$reciepient[0]->email = $newrecepemail;
		$xml->asXML("reciepients.xml");
	}
	else
	{
	   echo "unfound";	
	}
}

if($_POST['op']=="deleterecep")
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$recepemail = $_POST['recepemail'];
	
	$xml =new SimpleXMLElement("reciepients.xml", null, true);
		
	foreach($xml->xpath("/users/user[username = '$username']/form[formname = '$formname']/reciepients/reciepient") as $reciepient)
{
	if($reciepient[0]->email == $recepemail)
	{
		//echo "looping <br>";
     	unset($reciepient[0]);
		break;
	}
}
	$xml->asXML("reciepients.xml");
}

if($_POST['op'] == "storescroll")
{
	$scrollval = $_POST['scrollval'];
	$_SESSION['scrollval'] = $scrollval;
}
if($_POST['op'] == "getscroll")
{
	if(isset($_SESSION['scrollval']))
	{
	  echo $_SESSION['scrollval'];
	  //unset($_SESSION['scrollval']);
	}
	else
	{
	  echo "0";	
	}
	$_SESSION['scrollval'] = 0;
}

//var param = "op=saveop&username="+username+"&formname="+formname+"&fldname="+fldname+"&optionval="+optionval+"&newval="+newval;
if($_POST['op'] == 'saveop')
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$fldname = $_POST['fldname'];
	$optionval = $_POST['optionval'];
	$newval = $_POST['newval'];
	
	$xml =new SimpleXMLElement("formelems.xml", null, true);
 
	if($xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fldname']/options"))
    {
		echo "enter";
		$options = $xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fldname']/options/option");
		print_r($options);
	
// #### need to check if the field name already exists. and send back error code. 
		for($i=0;$i<sizeof($options);$i++)
		{
			$option = (string)$options[$i];
            echo "option is".$option;
			if($option == $optionval)
			{
			   echo "found val replace value ".$options[$i]->option;
			   $options[$i]->option = $newval;
			   $xml->asXML("formelems.xml");
			   break;	
			}
		}
		
    }
}

//	var param = "op=editfld&formname="+formname+"&username="+username+"&fieldname="+fieldname+"&newfldname="+newfldname+"&essfld="+essfld+"&unifld="+unifld;

if($_POST['op'] == 'editfld')
{
	$formname = $_POST['formname'];
	$username = $_POST['username'];
	$fieldname = $_POST['fieldname'];
	$newfldname = $_POST['newfldname'];
	$essfld = $_POST['essfld'];
	$unifld = $_POST['unifld'];
	
	$xml =new SimpleXMLElement("formelems.xml", null, true);
 
	if($xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fieldname']"))
    {
		echo "reaching";
		$field= $xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fieldname']");
		$field[0]->fldname = $newfldname;
		$field[0]->essential = $essfld;
		$field[0]->unique = $unifld;
		
		print_r($xml);
		
		$xml->asXML("formelems.xml");
	}
}
//param is op=saveregex&username=sameeksha_k2001@yahoo.com&formname=my form&fldname=image field&fldtype=image
if($_POST['op'] == "saveregex")
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$fieldname = $_POST['fldname'];
	$fldtype = $_POST['fldtype'];
	
	$xml =new SimpleXMLElement("formelems.xml", null, true);
 
	if($xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fieldname']"))
	{
		$field = $xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fieldname']");
		if($xml->xpath(	"/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fieldname']/regex"))
		{
			$regex = $field[0]->regex;
			$regex = $regex[0];
		}
		else
		{
			$regex = $field[0]->addChild('regex');
	    }
		

	// types of regex - standard(contains tablist), custom, numlen
	if($fldtype == "chars" || $fldtype == "tdesc")
	{ 
	  if(isset($_POST['startswith'])) {
	  $startswith = $_POST['startswith'];
	  $endswith = $_POST['endswith'];
	  $length = $_POST['length']; 
	  $regex->type = "standard";
	  
	  if($regex->startswith) { $regex->startswith = $startswith ;
	                           $regex->endswith = $endswith;
							   $regex->length = $length;}
	  else { $regex->addChild('startswith', $startswith); 
	         $regex->addChild('endswith', $endswith);
			 $regex->addChild('length', $length);  } 
	  }
	  else
	  { // cust regex is set 
	    $custregex = $_POST['custregex'];   
		$regex->type = "custom"; 
		
		if($regex->custregex) { $regex->custregex = $custregex;}
		else { $regex->addChild('custregex',$custregex);}
	  }
	}// end of if for elems check
	else if($fldtype == "nums")
	{
		if(isset($_POST['startrange'])) {
		$startrange = $_POST['startrange'];
		$endrange = $_POST['endrange'];
		$regex->type = "standard";
		
		if($regex->startrange) { $regex->startrange = $startrange ;
								 $regex->endrange = $endrange; }
		else { $regex->addChild('startrange', $startrange); 
			   $regex->addChild('endrange', $endrange);  } 
		}
		else if(isset($_POST['length'])) {
			$regex->type = "length";
			$length = $_POST['length'];
			if($regex->length) { $regex->length = $length ; }
			else { $regex->addChild('length', $length);} }
		else { // cust regex is set 
		  $custregex = $_POST['custregex'];   
		  $regex->type = "custom"; 
		  
		  if($regex->custregex) { $regex->custregex = $custregex;}
		  else { $regex->addChild('custregex',$custregex);} }
	}// close $fldtype == "nums"
	else if($fldtype == "image" || $fldtype == "doc" || $fldtype == "video")
	{
		$maxsize = $_POST['maxsize'];
		$elemsarray=explode(',', $_POST['enitems']);
	    $regex->type = "standard"; 
		if($regex->maxsize) { $regex->maxsize = $maxsize; }
		else { $regex->addChild('maxsize',$maxsize); }
		if($regex->elems) { $elems = $regex->elems;
		                    $allelems = $elems[0]->elem;
							//deleting old vals
							foreach($xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field[fldname='$fieldname']/regex/elems") as $elems)
							{ unset($elems[0]);	}
							
		 }
		$elems = $regex->addChild('elems');
	    foreach($elemsarray as $elemval)
	    { $elems->addChild('elem', $elemval); }
	} 
    
	$xml->asXML("formelems.xml");
  }// end of xml if check
}
//var param = "op=regexinfo&username="+username+"&formname="+formname+"&dispfldn"+dispfldn;
if($_POST['op'] == "regexinfo")
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$fieldname = $_POST['dispfldn'];
	
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
			  if($startswith != "") { echo "<div class = 'menuelem'> <span class = 'highlightred'>$fieldname </span>should start with string <span class = 'highlightred'>$startswith</span></div>"; }
			  $endswith = $regex[0]->endswith;
			  if($endswith != "") { echo "<div class = 'menuelem'> <span class = 'highlightred'> $fieldname </span> should end with string <span class = 'highlightred'>$endswith </span></div>"; }
			  $length = $regex[0]->length;
			  if($length != "") { echo "<div class = 'menuelem'> <span class = 'highlightred'>$fieldname</span> can have maximum length of <span class = 'highlightred'>$length </span> characters</div>"; }
		                             
		     }// if $fldtype == text	 
		else if($fldtype == "nums") { 
		       $startrange = $regex[0]->startrange;
			  if($startrange != "") { echo "<div class = 'menuelem'> <span class = 'highlightred'>$fieldname</span> should start from <span class = 'highlightred'>$startrange </span></div>"; }
			  $endrange = $regex[0]->endrange;
			  if($endrange != "") { echo "<div class = 'menuelem'> <span class = 'highlightred'>$fieldname</span> should be within <span class = 'highlightred'>$endrange.</span></div>"; }
			  }// if $fldtype == nums	
	    else if($fldtype == "image" || $fldtype == "video" || $fldtype == "doc")
		      { $elems = $field[0]->regex->elems->elem;
			    $maxsize = $field[0]->regex->maxsize;
				
				echo "<div class = 'wid100'>
				      <div class = 'wid40 head3 floatl'> Maximum Size Allowed : </div>
					  <div class = 'wid40 head3 floatl'> $maxsize </div>
					  <div class = 'clear'></div>
					  </div>
					  ";
			    if(sizeof($elems) > 0) {
			    echo "<div class = 'head3'> <span class = 'highlightred'> <span class = 'highlightred'>$fieldname</span> </span> can only support upload of formats listed below. </div>"; 
				foreach($elems as $elem)
				{ echo "<div class = 'menuelem wid30'>$elem</div>";}
				}
			  }
		 } //if($regtype == "standard") 
		else if($regtype == "length") {
			$length = $regex[0]->length;
			if($length != "") { echo "<div class = 'menuelem'> <span class = 'highlightred'>$fieldname</span> can have maximum length of <span class = 'highlightred'>$length </span> digits.</div>"; }
		}
		else if($regtype == "custom")
		{ $custregex = $regex[0]->custregex;
		  if($custregex != "") { echo "<div class = 'menuelem'> <span class = 'highlightred'>$fieldname</span> complies with a regular expression <span class = 'highlightred'>$custregex </span></div>"; }
		}
		
	    //print_r($regex);
		
		  }
}
//var param = "op=addrespemail&email="+email;
if($_POST['op'] == "addrespemail")
{
$username = $_POST['username'];
$formname = $_POST['formname'];
$respid = $_POST['respid'];
$email = $_POST['email'];

addresp($username, $formname, $respid, $email);
}

function addresp($username, $formname, $respid, $email)
{
	if(!(preg_match("/".$email."/", $_SESSION['recepadded'])))
	{ $_SESSION['recepadded'] = $_SESSION['recepadded']."<span class='sep'/><span class = 'bg1 smpad smmargtop floatl smmargleft'>$email <img src='images/stopicon.jpg' class = 'icon' onclick=\"removerecep('$username', '$formname', '$respid','$email')\"></span>"; 
	 $_SESSION['receparray'] = array();
	 array_push($_SESSION['receparray'], $email);
	 }
}

if($_POST['op'] == "emailall")
{   
    $_SESSION['recepadded'] = ""; 
	$_SESSION['receparray'] = array();
	$formname = $_POST['formname'];
	$username = $_SESSION['user'];

	$xml =new SimpleXMLElement("responses.xml", null, true);
	
	if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response"))
	  {    	
		   foreach($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response") as $response)
	       {  $respid = (string)$response[0]->respid;
		      $emailfld = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='E - Mail']");
			  $email = $emailfld[0]->value;
			  echo "for email ".$email;
			  if(!(preg_match("/".$email."/", $_SESSION['recepadded'])))
	          { $_SESSION['recepadded'] = $_SESSION['recepadded']."<span class='sep'/><span class = 'bg1 smpad smmargtop floatl smmargleft'>$email <img src='images/stopicon.jpg' class = 'icon' onclick=\"removerecep('$username', '$formname', '$respid','$email')\"></span>";  
	            //array_push($_SESSION['receparray'], $email);
	//$_SESSION['receparray'][sizeof($_SESSION['receparray'])] = $email; 
	          }
		   }
		   print_r($_SESSION['receparray']);
	  }
}
//var param = "op=removerecep&email="+email;
if($_POST['op'] == "removerecep")
{
	$respcont = $_SESSION['recepadded'];
	$_SESSION['recepadded'] = "";
	$username = $_POST['username'];
    $formname = $_POST['formname'];
    $respid = $_POST['respid'];
	$email =$_POST['email'];
	
	if (in_array($email, $_SESSION['receparray'])) {
     $index =  array_search($email, $_SESSION['receparray']);
	 unset($_SESSION['receparray'][$index]);
    }
	//print_r($_SESSION['receparray']);
	$_SESSION['recepadded'] = "";
	foreach($_SESSION['receparray'] as $arrelem)
	{
		$_SESSION['recepadded'] = $_SESSION['recepadded']."<span class = 'bg1 smpad smmargtop floatl smmargleft'>$arrelem<img src='images/stopicon.jpg' class = 'icon' onclick=\"removerecep('$username', '$formname', '$respid','$arrelem')\"></span>"; 
	}
	echo "recep ".$_SESSION['recepadded'];
	/*$spans = explode("<span class='sep'/>", $respcont);
	print_r($spans);
	foreach($spans as $span)
	{ if(!(preg_match("/".$email."/", $span))) 
	  {
		$innerhtml =  explode("<span", $span);
		print_r("innerhtml ".$innerhtml);
		$innerhtml = $innerhtml[1];
		$innerhtml =  explode("<img src='images/stopicon.jpg'", $innerhtml);
		$innerhtml = $innerhtml[0];
		if($_SESSION['recepadded'] != "") { $_SESSION['recepadded'] = $_SESSION['recepadded']."<span class='sep'/>";}
		$_SESSION['recepadded'] = $_SESSION['recepadded']."<span class = 'bg1 smpad smmargtop floatl smmargleft'>$innerhtml<img src='images/stopicon.jpg' class = 'icon' onclick=\"removerecep('$username', '$formname', '$respid','$email')\"></span>"; 
	  } 
	}*/
}
if($_POST['op'] == "retryemail")
{
	$username = $_POST['username'];
	$formname = $_POST['formname'];
	$respid = $_POST['respid'];
	$emailno = (int)$_POST['emailno'];
	
	$xml =new SimpleXMLElement("responses.xml", null, true);
    if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']"))
	  {
		   $response = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid='$respid']/field[fldname='E - Mail']");
		   $emailid = (string)$response[0]->value;
		   $useremails = $response[0]->useremail;
		   $sentsub = $useremails[$emailno]->sent->subject;
		   $sentbody = $useremails[$emailno]->sent->messagebody->value;
		   
		  $succ = @mail($emailid, $sentsub, $sentbody); 
		  if($succ)
		  {  $useremails[$emailno]->sentorno = 'true'; }
		  else
		  {   echo "errorcode5555#E - Mail not sent. Retry again !!! ".$email;
			  $useremails[$emailno]->sentorno = 'false';              	  }
		  $xml->asXML("responses.xml");
	  }
}
if($_POST['op'] == 'uncheckall')
{
	 $username = $_POST['username'];
	 $formname = str_replace("_"," ",$_POST['formname']);
     $xml =new SimpleXMLElement("responses.xml", null, true);
	
	 $responses = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response");
	// print_r("responses is ".$xml);
     foreach($responses as $response)
	 {
	      if($response[0]->checked) { 
		  $checkedval = (string)$response[0]->checked;
		  //echo "checkedval ".$checkedval;
		  if($checkedval == "true" || $checkedval == "on" || $checkedval == "off") 
		  { $response[0]->checked = "false"; }
          }
	 }	
	 $xml->asXML("responses.xml");
}
//var param = "op=check&username="+username+"&formname="+formname+"&respid="+respid;
if($_POST['op'] == "check")
{
    $username = $_POST['username'];
	$formname = $_POST['formname'];
	$respid = $_POST['respid'];
	
	$xml =new SimpleXMLElement("responses.xml", null, true);
	$response = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response[respid = '$respid']");
	if($response[0]->checked)
	{ 
	if($response[0]->checked == "true" || $response[0]->checked == "on") 
	{ $response[0]->checked = "off"; }
	else { $response[0]->checked = "on"; }}
	else {
		  $response[0]->addChild('checked', "on");
	  }
	$xml->asXML("responses.xml");
	
	if($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response"))
	{
		$totchecked = 0;
		foreach($xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response") as $checkresp) { 
		$checkedval = (string)$checkresp[0]->checked;
		if($checkedval == "true" || $checkedval == "on") { $totchecked++; }
	    }// end of foreach
		echo $totchecked;
	}
	else { echo "0"; }
}
//var param = "op=deleterecord"+"&formname="+formname;
if($_POST['op'] == "deleterecord")
{
	$formname = $_POST['formname'];
	$username = $_SESSION['user'];
	
	$xml =new SimpleXMLElement("responses.xml", null, true);
	$responses = $xml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']/response");
	foreach($responses as $response)
	{ if((string)$response[0]->checked == "true" || (string)$response[0]->checked == "on")
	  { unset($response[0]);		  
	}}
	$xml->asXML("responses.xml");
}

?>