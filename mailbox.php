<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="script.js"></script>
<script>
window.onload = function()
{
	var content = document.getElementById("content");
	// ajax call to get all messages first. in the content. 
}
</script>
</head>

<body>

<div class = 'exsmsmallheader'>
Response Management System
</div>

<?php
if(isset($_GET['formname']))
   $formname = $_GET['formname'];
?>
<div class = 'wid70 margtop margauto smpad bg1'>
<div class = 'orangebutton floatl wid25 textcenter'> <a href = 'mailbox.php?formname=hello' class = 'whitefont'><img src='images/folder.png' class = 'menuicon'> <div class = 'spreadfont smfont'>Folders</div></a> </div> <!-- includes the search saved and will retrieve the value based on search, should combine with the current ajax search -->
<div class = 'orangebutton floatl wid25 textcenter'> <img src='images/mail.png' class = 'menuicon'> <div class = 'spreadfont smfont'> Mail Box </div></div> 
<div class = 'orangebutton floatl wid25 textcenter'> <a href = 'mailbox.php' class = 'whitefont'><img src='images/deleteicon.png' class = 'menuicon'> <div class = 'spreadfont smfont'> Delete </div> </a></div> 
<div class = 'orangebutton floatl wid25 textcenter'> <a href = 'mailbox.php' class = 'whitefont'> <img src='images/createfoldericon.png' class = 'menuicon'> <div class = 'spreadfont smfont'>New Folder </div></a></div> <!-- saves a new search and shows its results -->
<div class ='clear'> </div>
</div>

<!-- starts area diff from responses now. -->
<div class = 'wid100 margtop container'>
<div class = 'menu section'>
<div class = 'feedback textcenter margbot'> <span class = 'margauto bluebutton'>Send Message. </span></div>
<div class = 'menuelem alink wid100' onclick = "showmailmessageshtml('all', '<?php echo $formname;?>')">
<img src="" class = 'menuicon wid40 floatl'> <span class ='floatl wid40'>All</span> <span class = 'clear'></span>
</div> <!--closed -->
<div class = 'menuelem alink wid100' onclick = "showmailmessageshtml('sent', '<?php echo $formname;?>')">
<img src="images/sentmessageicon.png" class = 'menuicon wid40 floatl'> <span class ='floatl wid40'>Sent</span> <span class = 'clear'></span>
</div> <!--closed -->
<div class = 'menuelem alink wid100' onclick = "showmailmessageshtml('recd', '<?php echo $formname;?>')">
<img src="images/recdmessageicon.png" class = 'menuicon wid50 floatl'> <span class ='floatl wid50'>Recieved</span> <span class = 'clear'></span>
</div> <!--closed -->
<span class = 'clear'></span>
</div> <!-- screen division wid20 div section closed -->
<div class = 'wid20 floatl section'>
</div> <!-- screen division menu section closed -->

<div class = 'content section' id = 'content'>
</div> <!-- content section closed -->
</div><!-- div container is closed -->
</body>
</html>