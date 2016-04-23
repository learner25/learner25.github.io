<link rel="stylesheet" href="regcss.css" type="text/css" />
<?php
$user_id = $_POST['user'];
$user_pass = $_POST['password'];

$con=mysqli_connect('localhost','iitbd_saimon','admin123','iitbd_user');
if(mysqli_connect_errno())
{
 echo "failed to connect".mysqli_connect_error();
}

else
{
  if (!empty($user_id) && !empty($user_pass))
  {
 $result = mysqli_query($con,"INSERT INTO  iitbd_user.myusers (id ,username ,password)VALUES (NULL ,  '$user_id',  '$user_pass')");
  fopen($user_id.'.JSON','w+');
	file_put_contents($user_id.'.JSON','[]');
	header("location:index.php");
	}
}
//else
//header("location:main.php");
?>
<h1>welcome to registration </h1>
<form action="reg.php" method="POST">

  E-mail: <input type="email" placeholder="type your email here" name="user" style="margin-left:95px;"><br>
   Password: <input type="password" placeholder="password here" style="margin-left:70px;"><br>
   Retype password : <input type="password" placeholder="re-type password here" name="password" style="margin-left:14px;"><br>
   <input type="submit">
</form>