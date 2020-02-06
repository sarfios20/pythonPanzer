<?php
	session_start();
	$_SESSION['FLAG']  = $_POST['Flag'];
	$_SESSION['STEP'] = $_POST['Step'];
	//echo $_SESSION['FLAG'].' '.$_SESSION['STEP'];
	echo session_id();
?>