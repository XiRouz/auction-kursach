<?php
	include_once 'config.php';
	
	$login = trim($_POST['inputLoginAuth']);
	$password = trim($_POST['inputPasswordAuth']);

	//проверка логина
	if($login == ''){
		$error = 'Ошибка: Вы не ввели логин';
	}else{
		if($password == ''){
			$error = 'Ошибка: Вы не ввели пароль';
		}else{
			$error = '';
			$ok = true;
		}
	}
		
	//если ввели логин и пароль, то проверяем и заходим
	if($ok){
		$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login='".mysqli_real_escape_string($link, $login)."' LIMIT 1"));
		if(mysqli_num_rows(mysqli_query($link, "SELECT * FROM users WHERE login='".mysqli_real_escape_string($link, $login)."' LIMIT 1")) == 0){
			$error = 'Ошибка: Неверный логин\пароль';
		}else{

			//if($data['password'] == $password){
			if(password_verify($password, $data['password'])){	
				$query = "UPDATE users SET last_enter = '" .date('d.m.Y H:i'). "' WHERE id_users = " .$data['id_users'];
				mysqli_query($link, $query);
				setCookie('auth', 'true', time()+ 3600, '/');
				setcookie('login', $data['login'], time()+3600, '/');
				print '<script type="text/javascript"> location.reload(); </script>';
			}else{
				echo 'Ошибка: Неверный логин\пароль ';
			}
		}
	}

	//вывод ошибки
	echo $error;
?>