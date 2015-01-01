<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">

<script type="text/javascript" src="../scripts/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.10.4.custom.min.js"></script>
<script>
  $(function()
  { 
    $("#accordion").accordion();
	$("#accordion1").accordion();
  });
</script>

</head>

<body>
<div class = 'smallheader'>
Response Management System
</div>

<div class = 'buttons'>
<a href = 'login.php' class ='bigbut'>Login</a>
Or
<a href = 'register.php' class ='bigbut'>Register</a>
</div>

<div class = 'tutorial tutorial' id="accordion" style="margin-top:2.4rem;">
<h1 class = 'head'> 
<div class = 'wid100'><div class = 'wid20 floatl'><img src="images/rtarrow.png" class = 'opicon'></div>
<div class = 'wid80 floatl'> About </div>
<div class = 'clear'></div>
</div> </h1>
<div>
<p>
This is a response management system. You can use it to generate a link where customer generated form can be filled up by any number of users and their reponse can be seen and managed using this system. 
</p>
</div>
</div>

<div class = 'feedback wid50 margauto margtop'> How it works ? : </div>
<div class = 'tutorial' id="accordion1">

<h1 class = 'head margtop'> 
<div class = 'wid100'><div class = 'wid20 floatl'><img src="images/rtarrow.png" class = 'opicon'></div>
<div class = 'wid80 floatl'> Create Form Fields </div>
<div class = 'clear'></div>
</div> </h1>
<div>
<p>
<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div><div class = 'wid80 floatl smpad'>create form fields of different data types.</div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'>Create unique and essential fields.</div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'>Create regular expressions for field input. </div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'>Generate form URL to view the form online. This allows users to fill this form and submit their response.</div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'>Reciepients of the form can be added while finalizing the form.</div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'>View responses of the users. </div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'>Save personal credentials like e-mail address, blog address and othe details. </div><div class = 'clear'></div></div>
</p>
</div>

<h1 class = 'head margtop'> 
<div class = 'wid100'><div class = 'wid20 floatl'><img src="images/rtarrow.png" class = 'opicon'></div>
<div class = 'wid80 floatl'> Display Form </div>
<div class = 'clear'></div>
</div> </h1>
<div>
<p>
<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'>Form URL opens the form page which presents the form that can be filled by users. </div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> Form field conditions and regular expressions are checked against submitted response. </div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> Unique and essential fields checked against submitted response. </div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> User can e-mail a copy of the response submitted to himself / herself.  </div><div class = 'clear'></div></div>

<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> Disfunctionality report on the form can be reported to the creator of form if e-mail address is provided as personal credentials while creating form. 
 </div><div class = 'clear'></div></div>
</p>
</div>

<h1 class = 'head margtop'> 
<div class = 'wid100'><div class = 'wid20 floatl'><img src="images/rtarrow.png" class = 'opicon'></div>
<div class = 'wid80 floatl'> View user responses </div>
<div class = 'clear'></div>
</div> </h1>
<div>
<p>
<div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> View all responses posted to the form.
 </div><div class = 'clear'></div></div>
 
 <div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> Search responses on per form field basis.
 </div><div class = 'clear'></div></div>
 
  <div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> Save search results. 
 </div><div class = 'clear'></div></div>
 
   <div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> E - Mail the responder and view the responses of the sender. 
 </div><div class = 'clear'></div></div>
 
    <div class = 'wid100 margleft'> <div class = 'wid10 floatl smpad'><img src="images/point.png" class = 'icon'></div>
<div class = 'wid80 floatl smpad'> Send e - mail to all the responders at once. 
 </div><div class = 'clear'></div></div>
</p>
</div>

</div>

</body>
</html>