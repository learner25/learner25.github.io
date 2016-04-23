<?php
$filetoblank = $_POST['userfile'];

file_put_contents($filetoblank.".JSON","[]");
?>