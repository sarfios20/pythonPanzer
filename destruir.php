<?php
	session_start();
	$_SESSION['DESTROY']  = $_POST['destroy'];
	echo session_id();
?>