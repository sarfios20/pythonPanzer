<?php
	session_id($argv[1]);
	session_start();
	$pin_fordwards_1 = $_SESSION['PIN_FORDWARDS_1'];
	$pin_backwards_1 = $_SESSION['PIN_BACKWARDS_1'];
	$pin_current_1 = $pin_fordwards_1;
	$multiplier = 1;
	$pin_alternate_1 = $pin_backwards_1;
	$pin_pwm_1 = $_SESSION['PIN_MOTOR_1'];
	$pin_pwm_2 = $_SESSION['PIN_MOTOR_2'];
	session_write_close();
	$continue = True;

	while ($continue) {
		session_start();
		$pwm_1=$_SESSION['PWM_1'];
		$pwm_2=$_SESSION['PWM_2'];
		$flag=$_SESSION['FLAG'];
		$step=$_SESSION['STEP'];

		if ($_SESSION['DESTROY'] == "1") {
			$continue = False;
		}

		session_write_close();


		if ($flag == "-") {
			$multiplier = 0;
		}

		if ($pin_current_1 == $pin_fordwards_1) {
			if ($flag == "w") {
				$multiplier = 1;
			}
			else if ($flag == "s") {
				$multiplier = -1;
			}
		}
		else if ($pin_current_1 == $pin_backwards_1) {
			if ($flag == "w") {
				$multiplier = -1;
			}
			else if ($flag == "s") {
				$multiplier = 1;
			}
		}
		if ($pwm_1 + ($multiplier * $step) < 0) {
			$pwm_1=0;
			if ($pin_current_1 == $pin_fordwards_1) {
				$pin_current_1 = $pin_backwards_1;
				$pin_alternate_1 = $pin_fordwards_1;
			}
			else {
				$pin_current_1 = $pin_fordwards_1;
				$pin_alternate_1 = $pin_backwards_1;
			}
		}
		$pwm_1=$pwm_1 + ($multiplier * $step);
		$pwm_2=$pwm_2 + ($multiplier * $step);
		session_start();
		exec('gpio -g write '.$pin_current_1.' 1');
		exec('gpio -g write '.$pin_alternate_1.' 0');
		exec('gpio -g pwm '.$pin_pwm_1.' '.$pwm_1);
		exec('gpio -g pwm '.$pin_pwm_2.' '.$pwm_2);
		$_SESSION['PWM_1']=$pwm_1;
		$_SESSION['PWM_2']=$pwm_2;
		session_write_close();
		usleep(10000);
	}
?>