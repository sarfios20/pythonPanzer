<?php
	session_start();
	echo '-1- '.$_SESSION['PWM_1'].'-2- '.$_SESSION['PWM_2'];
	session_write_close();
?>