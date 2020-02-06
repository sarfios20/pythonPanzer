<?php
	session_start();
	$SID = session_id();
	$_SESSION['PWM_1']=0;
	$_SESSION['PWM_2']=0;

	$_SESSION['FLAG']  = '-';
	$_SESSION['STEP'] = 0;

	$_SESSION['PIN_FORDWARDS_1'] = 23;
	$_SESSION['PIN_BACKWARDS_1'] = 24;
	$_SESSION['PIN_MOTOR_1'] = 12;

	$_SESSION['PIN_FORDWARDS_2'] = 17;
	$_SESSION['PIN_BACKWARDS_2'] = 27;
	$_SESSION['PIN_MOTOR_2'] = 13;

	$_SESSION['DESTROY'] = 0;

	exec('gpio -g mode '.$_SESSION['PIN_MOTOR_1'].' pwm');
	exec('gpio -g pwm '.$_SESSION['PIN_MOTOR_1'].' 0');

	exec('gpio -g mode '.$_SESSION['PIN_MOTOR_2'].' pwm');
	exec('gpio -g pwm '.$_SESSION['PIN_MOTOR_2'].' 0');

	exec('gpio -g mode '.$_SESSION['PIN_MOTOR_2'].' pwm');
	exec('gpio -g pwm '.$_SESSION['PIN_MOTOR_2'].' 0');

	exec('gpio -g mode '.$_SESSION['PIN_FORDWARDS_1'].' out');
	exec('gpio -g write '.$_SESSION['PIN_FORDWARDS_1'].' 1');
	exec('gpio -g mode '.$_SESSION['PIN_BACKWARDS_1'].' out');
	exec('gpio -g write '.$_SESSION['PIN_BACKWARDS_1'].' 0');

	exec('gpio -g mode '.$_SESSION['PIN_FORDWARDS_2'].' out');
	exec('gpio -g write '.$_SESSION['PIN_FORDWARDS_2'].' 1');
	exec('gpio -g mode '.$_SESSION['PIN_BACKWARDS_2'].' out');
	exec('gpio -g write '.$_SESSION['PIN_BACKWARDS_2'].' 0');

	exec('php loop.php '.$SID.' > /dev/null 2>&1 &');
	echo session_id();
?>