<?php
$user_id = $_POST['user'];
$user_pass = $_POST['password'];

$con=mysqli_connect('iitbd.info:2082','iitbd_saimon','admin123','iitbd_user');
if(mysqli_connect_errno())
{
 echo "duh!!! failed to connect ".mysqli_connect_error();
}

else
{
 $result = mysqli_query($con,"INSERT INTO  iitbd_user.myusers (id ,username ,password)VALUES (NULL ,  '$user_id',  '$user_pass')");
  fopen($user_id.'.JSON','w+');
	file_put_contents($user_id.'.JSON','[]');
	header("location:main.php");
}

?>

<form action="reg.php" method="POST">
  user id: <input type="text" placeholder="username" name="user"><br>
   password: <input type="password" placeholder="password here" ><br>
   re-type password : <input type="password" placeholder="re-type password here" name="password"><br>
   <input type="submit">
</form>