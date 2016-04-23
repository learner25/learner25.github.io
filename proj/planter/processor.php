<?php
$datas = $_POST['data'];
$username = $_POST['username'];
file_put_contents($username.'.JSON', $datas);

?>