<?php
	include_once '../config.php';

	$oldpass = trim($_POST['oldPassword']);
	$newpass1 = trim($_POST['newPassword1']);
	$newpass2 = trim($_POST['newPassword2']);

	/*
	* старый пароль
	*/
	if(strlen($oldpass) == 0){
		$error_list['oldpass'] = 'Вы не ввели старый пароль';
	}else{
		$current_password = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login LIKE '". $_COOKIE['login'] ."'"));

		/* проверка нового пароля */
		//if($oldpass != $current_password['password']){
		if(password_verify($oldpass, $current_password['password'])==0){
			$error_list['oldpass'] = 'Вы ввели неправильный пароль';
		}else{
			$ok['oldpass'] = true;
			$error_list['oldpass'] = '';
		}
	}

	/* проверка нового пароля */
	if(strlen($newpass1) == 0){
		$error_list['newpass1'] = 'Вы не ввели пароль';
	}else{
		//короткий ли пароль
		if(strlen($newpass1) < 6){
			$error_list['newpass1'] = 'Пароль слишком короткий';
		}else{
			//длинный ли пароль
			if(strlen($newpass1) > 30){
				$error_list['newpass1'] = 'Пароль слишком длинный';
			}else{
				//правильность пароля
				if(preg_match('/^[a-zA-Z0-9]{6,30}$/', $newpass1)){
					$ok['newpass1'] = true;
					$error_list['newpass1'] = '';	
				}else{
					$error_list['newpass1'] = 'Пароль не соответствует требованиям';
				}	
			}
		}	
	}

	/* проверка подтверждения пароля */
	if(strlen($newpass2) == 0){
		$error_list['newpass2'] = 'Повторите пароль';	}else{
		//совпадают ли пароли
		if($newpass2 == $newpass1){
			$ok['newpass2'] = true;
			$error_list['newpass2'] = '';
		}else{
			$error_list['newpass2'] = 'Пароли не совпадают';
		}
	}

	if($ok['oldpass'] && $ok['newpass1'] && $ok['newpass2']){
		$hashedPassword = password_hash($newpass1, PASSWORD_DEFAULT);
		mysqli_query($link, "UPDATE users SET password = '". $hashedPassword ."' WHERE login LIKE '". $_COOKIE['login'] ."'");
		
		$error_list['change_ok'] = true;

		//echo mysqli_error($link);
	}
	echo json_encode($error_list);
?>