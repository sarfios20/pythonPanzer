<?php
	session_start();
	$pwm_1=$_SESSION['PWM_1'];
	$pwm_2=$_SESSION['PWM_2'];

	exec('gpio -g mode '.$pwm_1.' pwm');
	exec('gpio -g pwm '.$pwm_1.' 0');
	unset ($_SESSION["PWM_1"]);

	exec('gpio -g mode '.$pwm_2.' pwm');
	exec('gpio -g pwm '.$pwm_2.' 0');
	unset ($_SESSION["PWM_2"]);

	session_destroy();
?>