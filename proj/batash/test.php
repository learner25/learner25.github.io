<?php
	$file = fopen('wind.txt', 'r');
	while(!feof($file))
	{
		echo(fgets($file));
	}
	fclose($file);
?>