<?php 

$user_id = $_POST['id'];
$status = $_POST['status'];
$pass = $_POST['pass'];

$con=mysqli_connect('iitbd.info','iitbd_saimon','admin123','iitbd_user');
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}



else
{

$result = mysqli_query($con,"SELECT * FROM myusers where username='$user_id' and password= '$pass' ");

$fetch = mysqli_fetch_array($result);

{
  
   if($fetch['username']!=null)
     {
	  echo "login success!!";
   if($status==="1")
   
	header("location:index.php?user=".urldecode(base64_encode($user_id)));
	}
	 else
	 {
	   echo 'failed';
	  break;
	  }
 }
}
//$row = mysql_fetch_array( $users );
/* if($user_id== $row['username'] && $pass=="123456" ):
   
   echo "login success!!";
  
    fopen($user_id.'.JSON','w+');
	header("location:index.php?user=".$user_id);
	

  
 
   else:
   echo "failed";
  // header("location:main.php");
  
   endif;*/
  mysqli_close($con);
?>