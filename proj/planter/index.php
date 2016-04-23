<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" href="wtfdiary.css" type="text/css" />
<title>The planter</title>
<script type="text/javascript">
$(document).ready(function(){
	  $("#shadow").fadeIn("normal");
         $("#loginform").fadeIn("normal");
         $("#uname").focus();
		 
	$("#login_hide").click(function(){
        $("#loginform").fadeOut("normal");
        $("#shadow").fadeOut();
   });
   
});
</script>
</head>
<body style="background:url('bg-log.JPG') 100% 100%;">

<div>

</div>

    <div id="loginform" style="top:10%;">

    	<form action="login.php" method="POST">
			<label><small><i>Enter User Name and Password<i><small> <br>			or,

<a href="reg.php" style="text-decoration:none;color:green;"><b>register</b></a> a new user</label><br>
 <input type="hidden" value="1" name="status"/>
			<br><input type="email" name="id" value="" id="name1" class="input" placeholder="email" />
			
			<input type="password" name="pass" value=""  class="input" placeholder="password" />
			<br/>
			<input type="submit"  style="background-color:#44A517;" id="login" value="Login" />

		</form>
    </div>
	<div id="shadow" class="popup"></div>
</body>
</html>
<!-- <form action="login.php" method="POST">
 <input type="hidden" value="1" name="status"/>
  <input type="text" name="id" value="" id="name1"/>
  <input type="password" name="pass" value="" />
  <input type="submit" />
  
  
   
</form>
or,<br>
<br>
<a href="reg.php">register</a> -->
