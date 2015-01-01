<?php
session_start();
include_once('includeFunctions.php');
$location = $_POST['location'];

if(isset($_POST['savecred']))
{
	// gathering post
	 $compname = $_POST['compname'];
	 $tagline = $_POST['tagline'];
	 $blogaddress = $_POST['blogaddress'];
	 $email = $_POST['email'];
	 
	 if(isset($_FILES["logo"]["name"]))
	 {
	 $filename = $_FILES["logo"]["name"];
	 }
	 else
	 {
	 $filename = "";	 
	 }
	 echo "filename is ".$_FILES["logo"]["name"];
	 $path = "";
	 $username = $_SESSION['user'];
	// error checking
	 if($compname == "")
	 {
		   header("Location:$location?message=message1");
	 }
   
    if($filename != "")
	{
	// if file has been uploaded. 
	if(!(preg_match("/.(gif|jpg|png|jpeg)$/i", $_FILES["logo"]["name"])))
	{
		 header("Location:$location?message=message2");
	}
    
	$size = $_FILES["logo"]["size"]/1024;
	if($size > 5000)
	{
		header("Location:$location?message=message3");
	}
    	
	 // file uploading
     $_FILES["logo"]["name"] = "GlobalLogo.".pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
     $path = "userdata/".$username."/".$_FILES["logo"]["name"];
	 if(file_exists($path)) unlink($path);
	 
	 $result = move_uploaded_file($_FILES["logo"]["tmp_name"],$path);	
	 
	}
	 // saving the information in the file
	$xml =new SimpleXMLElement("formelems.xml", null, true);
 
	if($xml->xpath(	"/elems/users/user[username='$username']"))
    {
		$user = $xml->xpath("/elems/users/user[username='$username']");
		if($user[0]->compname)
		{
			$user[0]->compname = $compname;
			$user[0]->tagline=$tagline;
			$user[0]->blogaddress=$blogaddress;
			$user[0]->email = $email;
			
			$storedpath = $user[0]->logopath;
			
			if(strlen($path) > 0)
			{
			   // then there was a file input.
			   $user[0]->logopath=$path; 	
			}
		}
		else
		{
			// create the structure. 
			$user[0]->addChild('compname', $compname);
			$user[0]->addChild('tagline', $tagline);
			$user[0]->addChild('blogaddress', $blogaddress);
			$user[0]->addChild('email', $email);
			$user[0]->addChild('logopath', $path);
        } 
		}
		$xml->asXML("formelems.xml");
		header("Location:$location");
}
	


if(isset($_POST['subform']))
{
   $username = $_SESSION['fduser'];
   $formname = $_SESSION['fdform'];
	  
   //echo "<pre>"; print_r($_POST); echo "</pre>";
   
   // -------------------------will generate an error report. --------------- 
   // 1. check if all the essential field have been filled in or no.
   // 2. if values have been input proper, check if string in number fields. 
         // checking regex for numbers and text length for text areas.  
   // 3. if any file is been uploaded
         // check for right image and document format as specified by the user. 
	// 4. check regex expressions


   $errorrep = "";
	 
   $xml =new SimpleXMLElement("formelems.xml", null, true);
     
   if($xml->xpath(  "/elems/users/user[username='$username']/form[formname='$formname']/fields/field"))
	{   
	   $elems = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field");
       
	   $errorrep .= "<ul> Errors are : ";
	   for($i=0; $i<sizeof($elems);$i++)
	   {
			 $dispfldn = $elems[$i]->fldname;
			 $dispfldt = $elems[$i]->fldtype;
			 $essential = $elems[$i]->essential;
			 
			 $dispfldn = str_replace(" ", "_", $dispfldn);
             
			 // checking for file types sample presented
			if($dispfldt == "image" || $dispfldt == "doc" || $dispfldt == "video")
			 {
				 if($essential == "yes")
				 {
					 if($_FILES[$dispfldn]["name"] == "")
                     {
						 $errorrep .= "<li class = 'menuelem'> Essential file <span class = 'blockdisp'>".$dispfldn."</span> not chosen </li>";  
					 }
				 }
					 if($_FILES[$dispfldn]["name"] != "")
                     {
				     $maxsize = 0;
					 $maxsize = $elems[$i]->regex->maxsize;
					 $elemsarray = $elems[$i]->regex->elems->elem;
					 $recdfilesize = $_FILES[$dispfldn]["size"]; 
					 
					 $filetype = $_FILES[$dispfldn]["type"];
					 if($maxsize != "") {
					 if($recdfilesize / 1024 > $maxsize) {
					  $errorrep .= "<li  class = 'menuelem'> Cannot upload file ".$_FILES[$dispfldn]["name"]." with size ".$_FILES[$dispfldn]["size"]." as it is greater than allowed maximum size of $maxsize."."</li>";                 } }
					  $ext = pathinfo($_FILES[$dispfldn]["name"], PATHINFO_EXTENSION);
					 
					  // checking if filetype is allowed. 
					  $allowedext = true;
					  $searchext = false;
					  echo "ext is ".$ext;
					  foreach($elemsarray as $elem) { 
						  if (strpos($elem,"".$ext."") !== false)
						  { $searchext = true; break; }
					  }
					  if(sizeof($elemsarray) > 0 && $searchext == false)
					  { $allowedext = false; }
					  if($allowedext == false)
					  {  $errorrep .= "<li  class = 'menuelem'> Cannot upload file ".$_FILES[$dispfldn]["name"]." with extension ".$ext." as it is not the type of file that should be uploaded.Look for <span class = ''><img src='images/infoicon.jpg' class = 'icon smmargleft'> near field name. </span></li>"."</li>";   }  
				   }
			 }
			 
			 if(isset($_POST[$dispfldn]))
			 {	
			
			 // part 1 of error report
			 if($essential == "yes")
			 {
				 if($_POST[$dispfldn] == "")
				 {
				   $dispfldn = str_replace("_", " ", $dispfldn);
				   $errorrep .= "<li  class = 'menuelem'> Essential field <span class = 'blockdisp'>".$dispfldn."</span> not filled in</li>"; 
				 } 
		     }
			 
			 $dispfldn = str_replace(" ", "_", $dispfldn);
			 
			 if($dispfldt == "text" || $dispfldt == "tdesc")  {
             // part two of error report
			 if($elems[$i]->textboxtype)
			 {
				 if($elems[$i]->textboxtype == "nums")
				 {
					 if(!(is_numeric($_POST[$dispfldn])) && $_POST[$dispfldn] != "")
					 {
						 $errorrep .= "<li> Numeric field <span class = 'blockdisp'>".$dispfldn."</span> cannot contain alphabets</li>"; 
					 }
					 else if(hasregex($username, $formname, (string)$elems[$i]->fldname))
					 {
					   $regextype = $elems[$i]->regex->type;
					   
					   if($_POST[$dispfldn] != "")
					   { 
					   if($regextype == "standard") 
					   {
					   $startrange = intval($elems[$i]->regex->startrange);
					   $endrange = intval($elems[$i]->regex->endrange); 
					  
					   if($startrange != "" && $endrange != "") {
						
					     if(intval($_POST[$dispfldn]) < $startrange ||  $_POST[$dispfldn] > $endrange)                     {
						     $errorrep .= "<li> Numeric field <span class = 'blockdisp'>".$dispfldn."</span> should be between $startrange and $endrange. Look for <span class = ''><img src='images/infoicon.jpg' class = 'icon smmargleft'> near field name. </span></li>";    
						                     }
					                         }
											 
					   else if($startrange != "" && $endrange == "")
					   {  if(($_POST[$dispfldn] < $startrange))   {
						   $errorrep .= "<li> Numeric field <span class = 'blockdisp'>".$dispfldn."</span> value should always be greater than $startrange. Look for <span class = ''><img src='images/infoicon.jpg' class = 'icon smmargleft'> near field name. </span></li>";    
					       }
						   
					   }
					    else if($startrange == "" && $endrange != "")
					   {  if(($_POST[$dispfldn] > $startrange))   {
						   $errorrep .= "<li> Numeric field <span class = 'blockdisp'>".$dispfldn."</span> cannot be greater than $endrange. Look for <span class = ''><img src='images/infoicon.png' class = 'icon smmargleft'> near field name. </span></li>";    
					       } 
					       }
					   }//has regex type = standard
					   if($regextype == "length")
					   { $length = intval($elems[$i]->regex->length); 
					     if(strlen($_POST[$dispfldn]) > $length) {
							  $errorrep .= "<li> Numeric field <span class = 'blockdisp'>".$dispfldn."</span> cannot have length greater than $length. Look for <span class = ''><img src='images/infoicon.png' class = 'icon smmargleft'> near field name. </span></li>";                                             }
					    }
						if($regextype == "custom")
						{ $custregex = $elems[$i]->regex->custregex;
                          $pattern = "/".$custregex."/";
						 
                          if(!(preg_match($pattern, $_POST[$dispfldn])))
						  {  $errorrep .= "<li> Numeric field <span class = 'blockdisp'>".$dispfldn."</span> does not comply with the regular expression. Look for <span class = ''><img src='images/infoicon.png' class = 'icon smmargleft'> near field name. </span></li>"; } }
						 
					   }//  if($_POST[$dispfldn] != "")
					 }// has regex if
				 }//if $elems[$i]->textboxtype == "nums"
				 else if($elems[$i]->textboxtype == "chars" || $dispfldt == "tdesc")
				 {  
				    if(hasregex($username, $formname, (string)$elems[$i]->fldname))
					 {
					   $regextype = $elems[$i]->regex->type;
					   
					   if($_POST[$dispfldn] != "")
					   { 
					   if($regextype == "standard") 
					   {
					   $startswith = $elems[$i]->regex->startswith;
					   $endswith = $elems[$i]->regex->endswith; 
					   $length = $elems[$i]->regex->length;
					   
					   $expr = "/^".$startswith."/";
                      echo " sw ".$expr." ".preg_match($expr, $_POST[$dispfldn]);
					  if(!(preg_match( "/^".$startswith."/", $_POST[$dispfldn])) || !(preg_match( "/".$endswith."$/", $_POST[$dispfldn])) || strlen($_POST[$dispfldn]) > $length)           {
					   $errorrep .= "<li  class = 'menuelem'> Text field <span class = 'blockdisp'>".$dispfldn."</span>";
					   if(!(preg_match( "/^".$startswith."/", $_POST[$dispfldn]))) {  $errorrep .= " should start with $startswith."; }
					   if(!(preg_match( "/".$endswith."$/", $_POST[$dispfldn]))) { $errorrep .= " , should end with $endswith.";}
					   if($length != "" && strlen($_POST[$dispfldn]) > $length) {$errorrep .= " , should not be longer than $length."; }
					   $errorrep .= "Look for <span class = ''><img src='images/infoicon.jpg' class = 'icon smmargleft'> near field name. </span></li>";    
					}					
					}//has regex type = standard
					if($regextype == "custom")
						{ $custregex = $elems[$i]->regex->custregex;
                          $pattern = "/".$custregex."/";
						  echo "custom".$pattern;
                          if(!(preg_match($pattern, $_POST[$dispfldn])))
						  {  $errorrep .= "<li  class = 'menuelem'> Text field <span class = 'blockdisp'>".$dispfldn."</span> does not comply with the regular expression. Look for <span class = ''><img src='images/infoicon.png' class = 'icon smmargleft'> near field name. </span></li>";           }
					    }//has regex type = custom
						 
					  }//  if($_POST[$dispfldn] != "")
					 }// hasregex
				  }
			    }// if($dispfldt == "text" || $dispfldt == "tdesc")
			    else if($dispfldt == "image" || $dispfldt == "doc" || $dispfldt == "video")
				{
					//handled out
				}
			 }// end of elems looping
	      }// end of last if 
	   }
	   $errorrep .= "</ul>";
	   
	   submitform($errorrep, $username, $formname, $location);
	}
}

function submitform($errorrep, $username, $formname, $location)
{
   if((strlen($errorrep)) > 25)
   {
	   $location = $location."?error";
	   $_SESSION['errorrep']=$errorrep;
	   echo $location." error ".$_SESSION['errorrep'];
   }
 else
   {
   $location = $location."?success";   
   // submit the form 
   $xml =new SimpleXMLElement("formelems.xml", null, true);
   $respxml = new SimpleXMLElement("responses.xml", null, true);
   
   //setting up xml space for responses. 
   if($respxml->xpath("/responses/users/user[username = '$username']"))
   {
	    $user = $respxml->xpath("/responses/users/user[username = '$username']");
		if($respxml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']"))
			     {
				    $form = $respxml->xpath("/responses/users/user[username = '$username']/form[formname = '$formname']");
					
					$form = $form[0];
				 }
				 else
				 {
					 // create the form entry
					 $user = $respxml->xpath("/responses/users/user[username = '$username']");
					 $form = $user[0]->addChild('form');
					 $form->addChild('formname', $formname);
				 }
			 }
			 else
			 {
				 // create the user entry
				 $responses = $respxml->xpath("/responses/users");
				 $user = $responses[0]->addChild('user');
				 $user->addChild('username', $username);
				 $form = $user->addChild('form'); 
				 $form->addChild('formname', $formname); 
			 }
			
			 
			// recording the responses
			$response = $form->addChild('response');
			$response->addChild('respid', uniqid());
			
   
   
   if($xml->xpath(  "/elems/users/user[username='$username']/form[formname='$formname']/fields/field"))
	{   
	       $elems = $xml->xpath("/elems/users/user[username='$username']/form[formname='$formname']/fields/field");
       

	   for($i=0; $i<sizeof($elems);$i++)
	   {
			 $dispfldn = $elems[$i]->fldname;
			 $dispfldt = $elems[$i]->fldtype;
			 
			 $dispfldn = str_replace(" ", "_", $dispfldn);
             
			 $field = $response->addChild('field'); 
			 $field->addChild('fldname', str_replace("_", " ", $dispfldn));
			 
			 if(isset($_FILES[$dispfldn]["name"]))
			 {
    		 if($_FILES[$dispfldn]["name"] != "")
			 {
				 $filetype = ""; $path = "";
				
				 $filetype = $_FILES[$dispfldn]["type"];
				 echo "looking for file ".$_FILES[$dispfldn]["name"]. " with type ".$_FILES[$dispfldn]["type"]." strpos val ".preg_match("/application/", $filetype);
				 if(preg_match("/image/", $filetype) != false) {
				 $path = "userdata/".$username."/Images/".$_FILES[$dispfldn]["name"]; 
				  }
				 else if(preg_match("/video/", $filetype) != false) {
				 exec('ffmpeg -i /tmp/'.$_FILES[$dispfldn]["name"].' /tmp/'.$_FILES[$dispfldn]["name"].'.mp4');
				 $path = "userdata/".$username."/Videos/".$_FILES[$dispfldn]["name"]; 
				  }
				  else if(preg_match("/audio/", $filetype) != false) {
				 $path = "userdata/".$username."/audio/".$_FILES[$dispfldn]["name"]; 
				  }
				  else if(preg_match("/application/", $filetype) != false || preg_match("/text/", $filetype)) {
				  $path = "userdata/".$username."/docs/".$_FILES[$dispfldn]["name"]; 
				  }
				 echo "path is ".$path." filetype ".$filetype;
	             $result = move_uploaded_file($_FILES[$dispfldn]["tmp_name"],$path);
				 $field->addChild('value', $path); 
			 }
			 }
			 
			 if(isset($_POST[$dispfldn]))
			 {	
			    if($dispfldt == "check")
				{
					foreach ($_POST[$dispfldn] as $checkval) 
					{
                       $field->addChild('value', $checkval);   
                    }
				}
				else
				{
				$field->addChild('value', $_POST[$dispfldn]);
				}
			 }
			 else
			 {
				$field->addChild('value', "");
			 }
			 
			 $field->addChild('fldtype', $dispfldt);
			 
	   }// end of for
	   
	         $saved = $respxml->asXML("responses.xml");
			 
			 if($saved == 1)
			 {
			    echo "Response Submitted";	 
		     }
			 else
			 {
				echo "Response Could not be submitted. Try Again!!";	 
			 }
     }    
   }/// else close
  header("Location:$location");
}

//header("Location:$location");
?>