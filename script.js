// JavaScript Document
var fademodalint;
var ajaxerror = false;
var ajaxresp;

window.onload = function()
{
	getscroll();
}

function saveform(username, formname)
{
	document.getElementById("formlink").className = "link formlinkon";
	document.getElementById("formresp").className = "link formlinkon";	
}

function subformname()
{
	var formname = document.getElementById("formname");
	fval = formname.value;
    console.log("sub form fired");
	if(fval.trim() == "")
	{
		//alert("fval "+fval);
		createfademessage("Form Name Cannot be blank please !!!", 400, "error", true);
	}
	else
	{
		// send an ajax request to save the form name.
		ajaxcall("functions.php", "op=subformname&fname="+fval, "Form name saved", "message", "", false, "", true);	
		
		if(ajaxerror == false)
		{
		document.getElementById("formnamecont").innerHTML = "<div class = 'smheader pad'>"+fval+"</div>";
		}
		else
		{
		document.getElementById("formname").value = "";	
		}

	}
}


function shownewfields(type)
{
	if(type == "textbox")
	{
	   hideother();
	   document.getElementById("textwrap").className = "wid100 smmargtop show";
	   document.getElementById("texttemp").className = "wid100 smmargtop show";
	   document.getElementById("fldtyperep").innerHTML = "Text Box";
	   document.getElementById("ftypeval").value = "text";
	}
	else if(type == "selbox")
	{
		hideother();
		document.getElementById("selectwrap").className = "show";
		document.getElementById("fldtyperep").innerHTML = "Select Box";
		document.getElementById("ftypeval").value = "select";
	}
	else if(type == "radio")
	{
		hideother();
		document.getElementById("radiowrap").className = "show";
		document.getElementById("radiootherwrap").className = "show";
		document.getElementById("fldtyperep").innerHTML = "Radio Buttons";
		document.getElementById("ftypeval").value = "radio";
	}
	else if(type == "check")
	{ 
	    hideother();
		document.getElementById("fldtyperep").innerHTML = "Check Boxes";
		document.getElementById("checkwrap").className = "show";
		document.getElementById("ftypeval").value = "check";
	}
	else if(type == "datep")
	{
		hideother();
		document.getElementById("fldtyperep").innerHTML = "Date Picker";
		document.getElementById("ftypeval").value = "datep";
	}
	else if(type == "time")
	{
		hideother();
	  	document.getElementById("fldtyperep").innerHTML = "Time";
		document.getElementById("ftypeval").value = "time";
	}
	else if(type == "image")
	{
		hideother();
		document.getElementById("fldtyperep").innerHTML = "Image";
		document.getElementById("ftypeval").value = "image";
	}
	else if(type == "doc")
	{
		hideother();
		document.getElementById("fldtyperep").innerHTML = "Word / Pdf Document";
		document.getElementById("ftypeval").value = "doc";
	}
	else if(type == "tdesc")
	{
		hideother();
		document.getElementById("fldtyperep").innerHTML = "Text Description";
		document.getElementById("ftypeval").value = "tdesc";
	}
	else if(type == 'video')
	{
		hideother();
		document.getElementById("fldtyperep").innerHTML = "Video";
		document.getElementById("ftypeval").value = "video";
	}
	else if(type == 'audio')
	{
		hideother();
		document.getElementById("fldtyperep").innerHTML = "Audio";
		document.getElementById("ftypeval").value = "audio";
	}
	
	
	// checking sub ops of text box selection
	if(type == "chars")
	{
		document.getElementById("numtemp").className = "wid100 smmargtop hide";
		document.getElementById("texttemp").className = "wid100 smmargtop show";
		document.getElementById("textwraprep").innerHTML = "Character";
		document.getElementById("texttype").value = "chars";
	}
	else if(type == "nums")
	{
		document.getElementById("texttemp").className = "wid100 smmargtop hide";
		document.getElementById("numtemp").className = "wid100 smmargtop show";
		document.getElementById("textwraprep").innerHTML = "Numbers";
		document.getElementById("texttype").value = "nums";
	}
	
	// checking for char templates
	if(type == "email")
	{
		document.getElementById("texttemprep").innerHTML = "E-Mail Address";
		document.getElementById("chartype").value = "email";
	}
	else if(type == "address")
	{
	   document.getElementById("texttemprep").innerHTML = "Address";
	   document.getElementById("chartype").value = "address";
	}
	else if(type == "textother")
	{
	   document.getElementById("texttemprep").innerHTML = "Other";
	   document.getElementById("chartype").value = "other";
	}
	
	
	
	// checking for num templates
	if(type == "phoneno")
	{
		document.getElementById("numtemprep").innerHTML = "Phone Number";
		document.getElementById("numtype").value = "phoneno";
	}
	else if(type == "zip")
	{
		document.getElementById("numtemprep").innerHTML = "Zip Code";
		document.getElementById("numtype").value = "zip";
	}
	else if(type == "numother")
	{
		document.getElementById("numtemprep").innerHTML = "Other";
		document.getElementById("numtype").value = "other";
	}
	
	
	// checking sub ops of radio button selection
	if(type == "morf")
	{
		document.getElementById("radiotemprep").innerHTML = "Male / Female";
		document.getElementById("radiootherwrap").className = "hide";
		document.getElementById("radiotype").value = "morf";
	}
	else if(type == "yorno")
	{
		document.getElementById("radiotemprep").innerHTML = "Yes / No";
		document.getElementById("radiootherwrap").className = "hide";
		document.getElementById("radiotype").value = "yorno";
	}
	else if(type == "rwother")
	{
		document.getElementById("radiotemprep").innerHTML = "Other";
		document.getElementById("radiootherwrap").className = "show";
		document.getElementById("radiotype").value = "rwother";
	}
	
	
	// checking for essential field
	if(type == "essyes")
	{
		document.getElementById("essval").innerHTML = "Yes";
		document.getElementById("essential").value = "yes";
	}
	else if(type == "essno")
	{
		document.getElementById("essval").innerHTML = "No";
		document.getElementById("essential").value = "no";
	}
    
	
    // checking for unique field
	if(type == "uniyes")
	{
		document.getElementById("unival").innerHTML = "Yes";
		document.getElementById("unique").value = "yes";
	}
	else if(type == "unino")
	{
		document.getElementById("unival").innerHTML = "No";
		document.getElementById("unique").value = "no";
	}

}

function hideother()
{
	 document.getElementById("textwrap").className = "hide";
	 document.getElementById("selectwrap").className = "hide";
	 document.getElementById("radiowrap").className = "hide";
	 document.getElementById("radiootherwrap").className = "hide";
	 document.getElementById("checkwrap").className = "hide";
}


function addoption(fortype)
{
	if(fortype == "radio")
	    var opval = document.getElementById("addtoradio").value;
	else if(fortype == "check")
	    var opval = document.getElementById("addtocheck").value;
	else
	    var opval = document.getElementById("addtoselbox").value;
		
		
	ajaxcall("functions.php", "op=addoption&type="+fortype+"&opval="+opval, "Option Added", "message", "", false, "", true);
}

function createlink(username, formname)
{
	var linkis = "http://localhost/Assignment/Portfolio/responseMgmt/research/formDisplay.php?user="+username+"&form="+formname;
	document.getElementById("formlink").innerHTML = linkis;
	document.getElementById("formlink").className = "formlinkon margtop";
}

function deleteform(username, formname)
{
	ajaxcall("functions.php", "op=deleteform&form="+formname, "Form deleted", "fieldmsg","", false, "", true);
	var location = window.location.href;
	location = location.split("?");
	location = location[0];
	location = location + "?form=new";
	window.location = location;
}

function finalform(username, formname)
{
	ajaxcall("functions.php", "op=finalform&form="+formname, "Form Finalised", "","", false, "", true);
	var location = window.location.href;
	location = location.split("?");
	location = location[0];
	location = location + "?form=new";
	window.location = location;
}

function delfld(form, index)
{
	storescroll();
	ajaxcall("functions.php", "op=deletefld&index="+index+"&form="+form, "Field deleted", "fieldmsg","", false, "", true);

    window.location = window.location;
}
function editfldhtml(username, formname, fieldname)
{
	var param = "op=editfldhtml&formname="+formname+"&username="+username+"&fldname="+fieldname;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Edit Field", true);
}
function editfld(username, formname, fieldname)
{
	var newfldname = document.getElementById("editfldname").value;
	var essfld = document.getElementById("editessentialfld").value;
	var unifld = document.getElementById("editunifld").value;
	
	// error checking for input
	if(newfldname == "" || essfld == "" || unifld == "")
	{
		createfademessage("Cannot leave input blank ", 200, "error", true);
	}
	if(!(essfld == "yes" || essfld == "no"))
	{
		createfademessage("Essential field value can be Yes or No.", 400, "error", true);
	}
	if(!(unifld == "yes" || unifld == "no"))
	{
		createfademessage("Unique field value can be Yes or No.", 400, "error", true);
	}
	
	var param = "op=editfld&formname="+formname+"&username="+username+"&fieldname="+fieldname+"&newfldname="+newfldname+"&essfld="+essfld+"&unifld="+unifld;
	ajaxcall("functions.php", param, "Field Edited", "", "formlink", false, "Edit Field", true);
	storescroll();
	window.location = window.location.href;
}

function editcred(what)
{
  if(what == 'logoimg')
  {
	  document.getElementById(what).style.display = "inline";
  }
  else
  {
  document.getElementById(what).type = "text";
  }
  
  var previd = document.getElementById("prev"+what);
  var nextid = document.getElementById("next"+what);
  var closeid = document.getElementById("close"+what);

  closeid.style.display = "inline";
  previd.style.display = "none";
  nextid.style.display = "none";	
}

function restorecrededit(what)
{
  if(what == 'logoimg')
  {
	  document.getElementById(what).style.display = "none";
  }
  else
  {
  document.getElementById(what).type = "hidden";
  }
  var previd = document.getElementById("prev"+what);
  var nextid = document.getElementById("next"+what);
  var closeid = document.getElementById("close"+what);
  
  closeid.style.display = "none";
  previd.style.display = "inline";
  nextid.style.display = "inline";	

}

function showvertical(username, formname, respid)
{
	var filename = "functions.php";
	var param = "op=showvertical&username="+username+"&formname="+formname+"&respid="+respid;
	var message = "";
	var msglocation = "";
	var contlocation = "";
	ajaxcall(filename, param, message, msglocation, contlocation, true, "Form Response", true);
}

function sendemail(username, formname, respid, email, hasreceps, content, startloc)
{
	var param = "op=emailhtml&username="+username+"&formname="+formname+"&respid="+respid+"&email="+email+"&hasreceps="+hasreceps+"&content="+content;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Send E-Mail", true, startloc);
}
function sendformdispemail(username, formname, respid, email, hasreceps, content, startloc)
{
	var param = "op=emailhtmlformdispemail&username="+username+"&formname="+formname+"&respid="+respid+"&email="+email+"&hasreceps="+hasreceps+"&content="+content;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Report to form owner", true, startloc);
}
function addemailrecep(username, formname, respid, email)
{
	var param = "op=emailrecephtml&username="+username+"&formname="+formname+"&respid="+respid+"&email="+email;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Add E-Mail Reciepients.", false);
}
function emailall(username,formname)
{
  var param = "op=emailall&formname="+formname;
  ajaxcall("functions.php", param, "", "", "", "", "", false);
  sendemail(username, formname, "", "", true, "", "");
}
function processemail(username, formname, respid, email)
{
	var subject = document.getElementById("subject").value;
	var message = document.getElementById("emailmsg").value;
	if(subject == "") { createfademessage("Subject cannot be blank", 400, "error", true);	}
	else if(message == "")
	{ createfademessage("Message body cannot be blank", 400, "error", true); }
    else {
	var param = "op=email&username="+username+"&formname="+formname+"&respid="+respid+"&email="+email+"&subject="+subject+"&message="+message;
	ajaxcall("functions.php", param, "", "", "sendemailresp", false, "", true); }
}

function bringontop(id)
{
	document.getElementById(id).style.zIndex = 1000;
   console.log("id is "+id+" zindex "+document.getElementById(id).style.zIndex);
}
function bringbottom(id)
{
	document.getElementById(id).style.zIndex = 1;
}
function recephtml(username, formname)
{
	var param = "op=addrecephtml&username="+username+"&formname="+formname;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Add Reciepients", true);
}

function addrecep(username, formname)
{
	var recepemail= document.getElementById("recepemail").value;
	var recepname= document.getElementById("recepname").value;
	
	var param = "op=addrecep&username="+username+"&formname="+formname+"&recepemail="+recepemail+"&recepname="+recepname;
	//alert("param is "+param);
	ajaxcall("functions.php", param, "Reciepient Added", "", "", false, "Add Reciepients", true);
	
     updatereciepients(username, formname);
}

function updatereciepients(username, formname)
{
	var param = "op=updatereceps&username="+username+"&formname="+formname;
	ajaxcall("functions.php", param, "", "", "receplist", false, "",true);
}

function editrecephtml(username, formname, recepemail)
{
    var param = "op=editrecephtml&username="+username+"&formname="+formname+"&recepemail="+recepemail;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Edit Reciepient", true);	
}

function editrecep(username, formname, recepemail)
{
	var newrecepemail= document.getElementById("recepemail").value;
	var recepname= document.getElementById("recepname").value;
	
    var param = "op=editrecep&username="+username+"&formname="+formname+"&recepemail="+recepemail+"&recepname="+recepname+"&newrecepemail="+newrecepemail;
	ajaxcall("functions.php", param, "", "", "", false, "", true);	
	
	updatereciepients(username, formname);
	createfademessage("Item edited", 400, "general", true);	
}

function deleterecephtml(username, formname, recepemail)
{
	var sendparam = "sendop=deleterecep#username="+username+"#formname="+formname+"#recepemail="+recepemail;
	//sendparam.replace(" ", "%20%");
	//alert("oaram is "+sendparam);
    var param = "op=deletehtml&what=reciepient"+"&param="+sendparam+"&username="+username+"&formname="+formname;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Delete Reciepient ?", true);	
}

function deletefieldhtml(formname, index)
{
		var sendparam = "sendop=deletefld#formname="+formname+"#index="+index;
		var param = "op=deletehtml&what=field&param="+sendparam+"&formname="+formname;
		ajaxcall("ajaxhtml.php", param, "", "", "", true, "Delete Field ?", true);
}

function deleteitem(param, username, formname)
{
	param = param.replace(/#/g, "&");
	param = param.replace("send", "");
	ajaxcall("functions.php", param, "", "", "", false, "", true);
	createfademessage("Item deleted", 400, "general", true);
	updatereciepients(username, formname);
	closemodal();
}


function showinput(id)
{
	document.getElementById(id).type = "text";
	document.getElementById(id+"check").style.display = "inline";
	document.getElementById(id+"close").style.display = "inline";
    document.getElementById(id).previousSibling.innerHTML = "";
}

function restoreinputval(id)
{
	var prevval = document.getElementById(id).dataset.prevval;
	document.getElementById(id).previousSibling.innerHTML = prevval;
	document.getElementById(id).type = "hidden";
	document.getElementById(id+"check").style.display = "none";
	document.getElementById(id+"close").style.display = "none";
}
function saveoptval(username,formname,fldname,optionval,inputidval)
{
	var newval = document.getElementById(inputidval).value;
	
	if(newval == "")
	{
		createfademessage("Option value cannot be blank.", 200, "error", true);	
	}
	else
	{
		var param = "op=saveop&username="+username+"&formname="+formname+"&fldname="+fldname+"&optionval="+optionval+"&newval="+newval;
		ajaxcall("functions.php", param, "Option Saved", "", "", "", "", true);
	}
}

function showregexhtml(formname, fldname, fldtype)
{
	var param = "op=showregexhtml&formname="+formname+"&fldname="+fldname;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Field Regular Expression", true);
	
	if(fldtype == 'datep')
	{
		makedatefield("startdate");
		makedatefield("enddate");

	}
}

function makedatefield(id)
{
	document.getElementById(id).datepicker();
}

function toggleenable(what)
{
	if(what == 'textcharsel')
	{
		var enable  = document.getElementById("textcharsel").dataset.en;
		console.log("currstate is"+enable);
		if(enable == "en")
		{
		document.getElementById("textcharsel").dataset.en = "dis";
		// when this is enabled. 
		// change class of standard header
		document.getElementById("stdconstheader").className = "wid100 bg1 pad";
		// change dis img
		document.getElementById("textcharsel").src = "images/selectdis.png";
		// make fields disablned
		document.getElementById("startswith").disabled = true;
		document.getElementById("endswith").disabled = true;
		document.getElementById("length").disabled = true;
	    // make text disabled
		document.getElementById("startwithheadid").className = "wid40 floatl disabledtext";
		document.getElementById("endswithheadid").className = "wid40 floatl disabledtext";
		document.getElementById("lengthheadid").className = "wid40 floatl disabledtext";       
		}//if(enable == "en")
		else
		{
		// can enable only if custregex is off
		var custregexsel = document.getElementById("custregexsel");
		if(custregexsel.dataset.en == "dis")
		{
			// when it is disabled. 
		document.getElementById("textcharsel").dataset.en = "en";
		// when this is enabled. 
		// change class of standard header
		document.getElementById("stdconstheader").className = "wid100 feedback";
		// change dis img
		document.getElementById("textcharsel").src = "images/selecten.png";
		// make fields disablned
		document.getElementById("startswith").disabled = false;
		document.getElementById("endswith").disabled = false;
		document.getElementById("length").disabled = false;
	    // make text disabled
		document.getElementById("startwithheadid").className = "wid40 floatl enabledtext";
		document.getElementById("endswithheadid").className = "wid40 floatl enabledtext";
		document.getElementById("lengthheadid").className = "wid40 floatl enabledtext";        } //custregexsel.dataset.en == "dis"
		else
		{
			createfademessage("Custome Regular Expressions are on.!!", 300, "error", true);
		}//custregexsel.dataset.en == "en"
		}//if(enable == "dis")
	}
	else if(what == 'textnumsel')
	{
		var enable  = document.getElementById("textnumsel").dataset.en;
		console.log("currstate is"+enable);
		if(enable == "en")
		{
		document.getElementById("textnumsel").dataset.en = "dis";
		console.log("en is "+document.getElementById("textnumsel").dataset.en);
		// when this is enabled. 
		// change class of standard header
		if(document.getElementById("numlensel").dataset.en == "dis")
		{
		document.getElementById("stdconstheader").className = "wid100 bg1 pad";
		}
		// change dis img
		document.getElementById("textnumsel").src = "images/selectdis.png";
		// make fields disablned
		document.getElementById("startrange").disabled = true;
		document.getElementById("endrange").disabled = true;
	    // make text disabled
		document.getElementById("startrangeheadid").className = "wid40 floatl disabledtext";
		document.getElementById("endrangeheadid").className = "wid40 floatl disabledtext";

		}//if(enable == "en")
	else
		{
		// can enable only if custregex is off and len is off
		var custregexsel = document.getElementById("custregexsel");
		var numlensel = document.getElementById("numlensel");
		if(custregexsel.dataset.en == "dis" && numlensel.dataset.en == "dis")
		{
			// when it is disabled.
		document.getElementById("textnumsel").dataset.en = "en";
		// when this is enabled. 
		// change class of standard header

		document.getElementById("stdconstheader").className = "wid100 feedback";
		// change dis img
		document.getElementById("textnumsel").src = "images/selecten.png";
		// make fields disablned
		document.getElementById("startrange").disabled = false;
		document.getElementById("endrange").disabled = false;
	    // make text disabled
		document.getElementById("startrangeheadid").className = "wid40 floatl enabledtext";
		document.getElementById("endrangeheadid").className = "wid40 floatl enabledtext";        
} //custregexsel.dataset.en == "dis"
		else
		{
			createfademessage("Other constraints are on.!!", 300, "error", true);
		}//custregexsel.dataset.en == "en"
		}//if(enable == "dis")
	}
	else if(what == 'numlensel')
	{
		var enable  = document.getElementById("numlensel").dataset.en;
		if(enable == "en")
		{
			document.getElementById("numlensel").dataset.en = "dis";
			document.getElementById("numlensel").src = "images/selectdis.png";
			document.getElementById("length").disabled = true;
			document.getElementById("lengthheadid").className = "wid40 floatl  disabledtext";
			document.getElementById("stdconstheader").className = "wid100 bg1 pad";
		}
		else
		{
		   // check if reg exp are on or stand const are on	
		   var textnumenable  = document.getElementById("textnumsel").dataset.en;
		   var custregexsel = document.getElementById("custregexsel").dataset.en;
		   console.log("enable is "+textnumenable + " dd "+custregexsel);
		   var canenable = false;
		   if(document.getElementById("textnumsel").dataset.en == "en")
		   {
			  createfademessage("Disable other standard constraint !!", 300, "error", true);
			  canenable = false; 
		   }
		   else if(document.getElementById("custregexsel").dataset.en == "en")
		   {
			  console.log("reach is custregexsel"+textnumenable + " dd "+custregexsel);
			  createfademessage("Disable custom regex !!", 300, "error", true);
			  canenable = false; 
		   }
		   else
		   {
			console.log("reach is "+textnumenable + " dd "+custregexsel);
			document.getElementById("numlensel").dataset.en = "en";
			document.getElementById("numlensel").src = "images/selecten.png";
			document.getElementById("length").disabled = false;
			document.getElementById("lengthheadid").className = "wid40 floatl  enabledtext";
			document.getElementById("stdconstheader").className = "wid100 bg1 feedback";
		   }
		}
	}
	else if(what == 'custregexsel')
	{
		var custregexsel = document.getElementById("custregexsel");
		if(custregexsel.dataset.en == "dis")
		{
		var canenable = false;
		if(document.getElementById("textcharsel") != null)
		{
		   // text sel is on
			var textenable  = document.getElementById("textcharsel").dataset.en;
			if(textenable == "en")
			{
				createfademessage("Standards Consraints are on.!!", 300, "error", true);
			}
			else
			{
				// no problem in putting the cust regex enabled. 
				canenable = true;
			}
		
		}
		else
		{
			// num sel is on
			var textenable  = document.getElementById("textnumsel").dataset.en;
			var lenselenable  = document.getElementById("numlensel").dataset.en;
			if(textenable == "en" || lenselenable == "en")
			{
				createfademessage("Standards Consraints are on.!!", 300, "error", true);
			}
			else
			{
				// no problem in putting the cust regex enabled. 
				canenable = true;
			}
		}
		
		if(canenable == true)
		{
			custregexsel.dataset.en = "en";
			custregexsel.src = "images/selecten.png";
			document.getElementById("custregexpheader").className = 'wid40 floatl enabledtext';
			document.getElementById("custregexfld").disabled = false;
		}
		
		}// custregexsel.dataset.en == "dis"
		else
		{
		   	// when custregex is enabled.
			custregexsel.dataset.en = "dis"; 
			custregexsel.src = "images/selectdis.png";
			document.getElementById("custregexpheader").className = 'wid40 floatl disabledtext';
			document.getElementById("custregexfld").disabled = true;
		}
	}
}

function toggleactiveopt(idvalimg, idval)
{
	console.log("called");
	if(document.getElementById(idvalimg).dataset.en == "en")
	{
	document.getElementById(idvalimg).dataset.en = "dis";
	document.getElementById(idvalimg).src = "images/disable.png";
	//document.getElementById(idval).style.backgroundColor = "#ccc";
	document.getElementById(idval).className= "disabletab pad wid40 floatl ";
	}
	else
	{
	document.getElementById(idvalimg).dataset.en = "en";
	document.getElementById(idvalimg).src = "images/disabledeactive.png";
	//document.getElementById(idval).className= "menuelem pad wid40 floatl";
	//document.getElementById(idval).style.backgroundColor = "#F7EC7A";
	document.getElementById(idval).className= "enabletab pad wid40 floatl ";
	}
}

function saveregex(username, formname, fldname, fldtype)
{
	var cansave = true;
	var param = "op=saveregex&username="+username+"&formname="+formname+"&fldname="+fldname+"&fldtype="+fldtype;
	if(fldtype == "chars" || fldtype == "tdesc")
	{ if(document.getElementById("textcharsel").dataset.en == "en")
	  {
	  var startswith = document.getElementById("startswith").value;
	  var endswith = document.getElementById("endswith").value; 
	  var length = document.getElementById("length").value; 
	  if(!(IsNumeric(length)))
	  {
		  createfademessage("Length constraint cannot have charaters in it. ", 400, "error", true);
		   cansave = false;
	  }
	  else
	  {
		  // can save the constraints.
		  console.log("reached here"); 
		  param=param+"&startswith="+startswith+"&endswith="+endswith+"&length="+length;
	  }
	  }//document.getElementById("textcharsel").dataset.en == "en"
	  else if(document.getElementById("custregexsel").dataset.en == "en")
	  {
		  // custom regex to be stored.    
		  var custregex = document.getElementById("custregexfld").value;
		  if(custregex == "")
		  { createfademessage("Regular Expression has no value ", 400, "error", true); 
		    cansave = false; }
		  else
		  { // can save the reg exp. 
		    param=param+"&custregex="+custregex; 
		  }
      }//document.getElementById("custregexsel").dataset.en == "en"
	  else
	  { cansave = false; }
	} //fldtype == "chars"
	else if(fldtype == "nums")
	{
	  if(document.getElementById("textnumsel").dataset.en == "en")
	  {
	  var startrange = document.getElementById("startrange").value;
	  var endrange = document.getElementById("endrange").value; 
	  
	  if(!(IsNumeric(startrange) || IsNumeric(endrange)))
	      { createfademessage("Range can only be a number. ", 400, "error", true);
		    cansave = false; }
	  else
	  {  param = param+"&startrange="+startrange+"&endrange="+endrange; }
	  }
	  else if(document.getElementById("numlensel").dataset.en == "en")
	  {
		  var length = document.getElementById("length").value;
		  
		  if(length == "")
		  { createfademessage("Length Field cannot be blank ", 400, "error", true); 
		    cansave = false; }
		  else if(!(IsNumeric(length)))
	      { createfademessage("Length contraint cannot have characters", 400, "error", true);
		    cansave = false; }
		  else
		  {// can save const 
		    console.log("length is "+length); 
			param = param+"&length="+length; }
	  }
	  else if(document.getElementById("custregexsel").dataset.en == "en")
	  {
		  var custregex = document.getElementById("custregexfld").value;
		  if(custregex == "")
		  { createfademessage("Regular Expression has no value ", 400, "error", true); 
		    cansave = false; }
		  else
		  { // can save the reg exp. 
		    param=param+"&custregex="+custregex; 
		  }
	  }
	  else
	  { cansave = false; }
	} //fldtype == "nums"
	else if(fldtype == "image" || fldtype == "video" || fldtype == "doc")
	{
		var enableditems = document.getElementsByClassName("enabletab pad wid40 floatl"); 
		if(enableditems.length == 0)
		{ createfademessage("No values are enabled. ", 400, "error", true); }
		else {
		var maxsize = document.getElementById("maxsize").value;
		var enitems = new Array();
		for(var i=0;i<enableditems.length;i++)
		{
			enitems[i]=enableditems[i].innerHTML.trim();
		}
		JSON.stringify(enitems); 
		param = param +"&maxsize="+maxsize+"&enitems="+enitems; }
	}//fldtype == "image" || fldtype == "video" || fldtype == "doc"
	  
	 console.log("param is "+param);
	 if(cansave == true)
	 {	ajaxcall("functions.php", param, "Regular Expression Saved.", "", "formlink", false, "", true); }
	 else
	 { if(document.getElementById("fademodal") == null)
	   {
		  createfademessage("Nothing was saved. ", 400, "error", true); 
	   }  }
}


function IsNumeric(num) {
     return (num >=0 || num < 0);
}

function showregexinfo(username, formname, dispfldn)
{
	var param = "op=regexinfo&username="+username+"&formname="+formname+"&dispfldn="+dispfldn;
	ajaxcall("functions.php", param, "", "", "", true, "Field Constraints", true);
}

function showerror(errorrep)
{
	console.log("error "+errorrep);
	errorrep = errorrep.replace(/#/g,"'");
	createmodal(errorrep, "Error Report", true);
}
function showmailmessageshtml(type, formname)
{
	alert("type "+type+" formname "+formname);
	var param = "op=showmailmessageshtml&type="+type+"&formname"+formname;
	ajaxcall(filename, param, message, msglocation, contlocation, showmodal, modaltitle, true);
}
function showsearchfolders(formname)
{
	if(document.getElementById("allfolders").innerHTML != "")
	{ document.getElementById("allfolders").innerHTML = ""; }
	else {
	var param = "op=showsearchfolders&formname="+formname;
	document.getElementById("allfolders").style.position = "absolute";
	ajaxcall("functions.php", param, "", "", "allfolders",false, "", true);
	document.getElementById("allfolders").style.left = document.getElementById("savedsearchbox").offsetLeft + "px";
	document.getElementById("allfolders").style.top = document.getElementById("savedsearchbox").offsetTop + 90 + "px";
	document.getElementById("allfolders").style.zIndex = 3;
	document.getElementById("allfolders").style.width = document.getElementById("savedsearchbox").offsetWidth + "px";
	}
	//document.getElementById("allfolders").innerHTML = "</div><div class = 'wid20 menuelem'> Folder1</div>";
}
function showfolders(formname)
{
	var param = "op=showfolders&formname="+formname;
	ajaxcall("functions.php", param, "", "", "alluserfolders",false, "", true);
}

function addresponderemail(username, formname, respid, email)
{
	var param = "op=addrespemail&username="+username+"&formname="+formname+"&respid="+respid+"&email="+email;
	ajaxcall("functions.php", param, "", "", "responseme",false, "", true);
}
function removerecep(username, formname, respid,email)
{
	console.log("remove");
	var param = "op=removerecep&username="+username+"&formname="+formname+"&respid="+respid+"&email="+email;
	ajaxcall("functions.php", param, "", "", "allfolders",false, "", true);
	var param = "op=emailhtml&username="+username+"&formname="+formname+"&respid="+respid+"&email="+email+"&hasreceps="+"true";
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Send E-Mail", true);
}
function showmore(username, formname, respid, emailno)
{
  var param = "op=showmoreemail&username="+username+"&formname="+formname+"&respid="+respid+"&emailno="+emailno;	
  ajaxcall("ajaxhtml.php", param, "", "", "", true, "E-Mail Details :", true);
}
function retryemailhtml(username, formname, respid, emailno)
{
	  var param = "op=retryemail&username="+username+"&formname="+formname+"&respid="+respid+"&emailno="+emailno;	
	  ajaxcall("ajaxhtml.php", param, "", "", "", true, "Retry E - mail :", true);
}
function retryemail(username, formname, respid, emailno)
{
	  var param = "op=retryemail&username="+username+"&formname="+formname+"&respid="+respid+"&emailno="+emailno;	
	  ajaxcall("functions.php", param, "E - Mail Sent.", "", "", false, "", false);
}
function check(username, formname, respid)
{
	var param = "op=check&username="+username+"&formname="+formname+"&respid="+respid;
	ajaxcall("functions.php", param, "", "", "", false, "", false);
	if(parseInt(ajaxresp) >= 0)
	{ 	ajaxresp = parseInt(ajaxresp);
	  if(ajaxresp == 0) { deactivebutts(); }
	  else { alivebutts(); }  
    }
}
function deleterecordshtml(formname)
{
	if(document.getElementById("deletebutt").className == "orangebutton floatl wid25 textcenter")
	{console.log("called del"); 
	var param = "op=deleterechtml"+"&formname="+formname;
	ajaxcall("ajaxhtml.php", param, "", "", "", true, "Delete Records ?", true);
	}
}
function deleterecord(formname)
{
	var param = "op=deleterecord"+"&formname="+formname;
	ajaxcall("functions.php", param, "Responses Deleted ", "", "allfolders", false, "", false);

}
function createfolderhtml(formname)
{
	var param = "op=createfolderhtml"+"&formname="+formname;
	ajaxcall("ajaxhtml.php", param, "", "", "allfolders", true, "Create New Folder ", true);
}
function createfolder(formname)
{
	var foldername = document.getElementById("foldername").value;
	var param = "op=createfolder"+"&formname="+formname+"&foldername="+foldername;
	ajaxcall("functions.php", param, "", "", "userfolders", false, "", false);
}
function openimage(formname, name, email, source)
{ 
  var param = "op=openimage&formname="+formname+"&name="+name+"&email="+email+"&source="+source;
  console.log(param);
  ajaxcall("ajaxhtml.php", param, "", "", "", true, "Image View", true);
}
// general functions
function changemessage(message, delay)
{
	setTimeout(function()
	{
		document.getElementById("message").innerHTML = message;
	}
	, delay);
}
function ajaxcall(filename, param, message, msglocation, contlocation, showmodal, modaltitle, showclose, startloc)
{  
		   var xhr = new XMLHttpRequest();
		   xhr.open("post", filename, false);
		   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		  
		   xhr.onreadystatechange = function()
		   {
			   if(xhr.readyState == 4)
			  {
				 var resp = xhr.responseText;
				 
				 // check if response contains error code
				 if(resp.indexOf("errorcode5555") > -1)
				 {
				    // business logic error returned from php. 
					var errormessage = resp.split("errorcode5555#");	 
					createfademessage(errormessage[1], 400, "error", "general", true);
					ajaxerror = true;
				 }
				 else
				 {
				 if(contlocation != "")
				 {
				 document.getElementById(contlocation).innerHTML = resp;
				 }
			     
				 if(showmodal == true)
				 {
					 createmodal(resp, modaltitle, showclose, startloc);
				 }
				 else
				 {
					 if(message != "")
					 {
					 // show fading message for user. 
					 createfademessage(message, 400, "general", true);
					 }
				 }
				 ajaxerror = false;;
				 }// end of error code check if. 
				//document.getElementById("formlink").innerHTML = resp;	
				ajaxresp = resp;	  	 
			  } 
	       }
	       xhr.send(param);
	
}

function createfademessage(message, delay, type, canfade)
{
	if(document.getElementById("fademodal") == null)
	{
	var messagebox = document.createElement("div");
	messagebox.className = "wid100 fademodal";
	if(type == "error")
	{
	   messagebox.style.backgroundColor = "#f00";	
	}	
	else
	{
	   messagebox.style.backgroundColor = "#000";
	}
	messagebox.id = "fademodal";
	messagebox.innerHTML = message;
	messagebox.style.position = "absolute";
	messagebox.style.top = window.pageYOffset+30+"px";
    messagebox.style.opacity = 0.7;
	
	var remwid = (window.innerWidth - window.innerWidth * 40/100);
	remwid = remwid/2;
	messagebox.style.left = remwid + "px";
	var offht = window.pageYOffset + 200;
	//offht = offht - (modal.offsetHeight/2);
	messagebox.style.top = offht + "px";
	
	var closeicon = document.createElement("div");
	closeicon.className = 'wid10 floatr';
	closeicon.innerHTML = "<img src='images/closeicon.png' class = 'icon'><div class ='clear'></div>";
	closeicon.onclick = closefademsg;
	messagebox.appendChild(closeicon);
	
	document.body.appendChild(messagebox);
	if(canfade == true)
	{ fademodalint = setInterval(fademodal, delay);	}
	}
}
function closefademsg()
{
	if(document.getElementById("fademodal") != null)
	{
		document.body.removeChild(document.getElementById("fademodal"));
	}
}
function fademodal()
{
	console.log("fading");
	var fademodal = document.getElementById("fademodal");
	
	if(fademodal != null)
	{
	   if(fademodal.style.opacity > 0)
	   {
		  console.log("fading big");
		  fademodal.style.opacity = fademodal.style.opacity - 0.05;   
		  if(fademodal.style.opacity < 0.15)
		  {
			  fademodal.style.opacity = 0;
		  }
	   }	
	   else
	   {
		   console.log("fading low");
		   fademodal.style.opacity = 0; 
		   document.body.removeChild(fademodal);
		   clearInterval(fademodalint);
	   }
	}
}

window.onscroll = function()
{
  if(document.getElementById("modal") != null)
  {
	  if(document.getElementById("modal").offsetHeight < 600)
	  {
	  var modal = document.getElementById("modal");
	  modal.style.top = window.pageYOffset + 20 + "px"; 
	  }
  }	
  if(document.getElementById("fademodal") != null)
  {
	  var fademodal = document.getElementById("fademodal");
	  
	  fademodal.style.top = window.pageYOffset + 700 + "px"; 
  }	
}
function createmodal(html, titletext, showclose, startloc)
{
	//alert("show cloase is "+showclose);
	closemodal();
	
	var modal = document.createElement("div");
	modal.className = "wid100 modal";	
	modal.id = "modal";
	
	var titlewrap = document.createElement("div");
	titlewrap.className = "wid100";
	modal.appendChild(titlewrap);
	
	var title = document.createElement("div");
	title.className = "head3 wid50 floatl";
	titlewrap.appendChild(title);
	title.innerHTML = titletext;
	
	if(showclose == false) 
	{}
	else
	{
	var closeme = document.createElement("div");
	closeme.className = "head3 wid30 floatr";
	closeme.innerHTML = "<img src='images/delete.png' class = 'icon floatr margright roundborder' onclick = closemodal()>";
	closeme.onclick = closemodal;
	titlewrap.appendChild(closeme);
	}
	titlewrap.innerHTML = titlewrap.innerHTML + "<div class ='clear'></div>";
	
	var modalcontent = document.createElement("div");
	modalcontent.className = "modalcont";
	modalcontent.innerHTML = html;
	modal.appendChild(modalcontent);

	var remwid = (window.innerWidth - window.innerWidth * 90/100);
	remwid = remwid/2;
	modal.style.position = "absolute";
	modal.style.left = remwid + "px";
	modal.style.top = 20 + "px";
    window.scrollTo(0,0);
    document.body.appendChild(modal);
}
function closemodal()
{
   var modal = document.getElementById("modal");
   
   if(modal != null) 
      document.body.removeChild(modal);	
}
function storescroll()
{
	var scrollval = window.pageYOffset;
	//alert("storing "+scrollval);
	var param = "op=storescroll&scrollval="+scrollval;
	ajaxcall("functions.php", param, "", "", "", "", "");
}
function getscroll()
{
	var param = "op=getscroll";
	ajaxcall("functions.php", param, "", "", "", "", "");
	//alert("getting "+ajaxresp);
	window.scrollBy(0, parseInt(ajaxresp));
}