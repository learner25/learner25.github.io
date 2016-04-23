<?php

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');
if(isset($_POST['lol']))
$lol2 = $_POST['lol'];
echo 'welcome :' .$lol2;
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../'.$_FILES['upl']['name'])){
		echo '{"status":"success"}';
		//echo $lol2;
		exit;
	}
}

echo 'welcome'.$lol2;
exit;