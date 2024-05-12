<?php 
	$connection = new mysqli('localhost', 'root','','dbbitayof2');
	
	if (!$connection){
		die (mysqli_error($mysqli));
	}
		
?>