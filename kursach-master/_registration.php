<?php 
	include_once 'config.php';

	$login = trim($_POST['inputLogin']);
	$password = trim($_POST['inputPassword']);
	$repeatPassword = trim($_POST['inputRepeatPassword']);
	$email = trim($_POST['inputEmail']);
	$checkbox = $_POST['rulesAgree'];

	//проверка логина
	//введен ли логин
	if(strlen($login) == 0){
		$errorList['login'] = 'Вы не ввели логин';
		$errorList['loginOk'] = false;
	}else{
		//короткий ли логин
		if(strlen($login) < 3){
			$errorList['login'] = 'Логин слишком короткий';
			$errorList['loginOk'] = false;
		}else{
			//длинный ли логин
			if(strlen($login) > 20){
				$errorList['login'] = 'Логин слишком длинный';
				$errorList['loginOk'] = false;
			}else{
				//правильность логина
				if(preg_match('/^[-_a-zA-Z0-9]{3,20}$/', $login)){
					$ok['login'] = true;
					$errorList['loginOk'] = true;
				}else{
					$errorList['login'] = 'Логин не соответствует требования';
					$errorList['loginOk'] = false;
				}
			}
		}	
	}
	
	//проверка пароля
	//введен ли пароль
	if(strlen($password) == 0){
		$errorList['password'] = 'Вы не ввели пароль';
		$errorList['passwordOk'] = false;
	}else{
		//короткий ли пароль
		if(strlen($password) < 6){
			$errorList['password'] = 'Пароль слишком короткий';
			$errorList['passwordOk'] = false;
		}else{
			//длинный ли пароль
			if(strlen($password) > 30){
				$errorList['password'] = 'Пароль слишком длинный';
				$errorList['passwordOk'] = false;
			}else{
				//правильность пароля
				if(preg_match('/^[a-zA-Z0-9]{6,30}$/', $password)){
					$ok['password'] = true;
					$errorList['password'] = true;
				}else{
					$errorList['password'] = 'Пароль не соответствует требования';
					$errorList['passwordOk'] = false;
				}	
			}
		}	
	}

	//проверка подтверждения пароля
	if(strlen($repeatPassword) == 0){
		$errorList['repeatPassword'] = 'Повторите пароль';
		$errorList['repeatPasswordOk'] = false;
	}else{
		//совпадают ли пароли
		if($repeatPassword == $password){
			$ok['repeatPassword'] = true;
			$errorList['repeatPasswordOk'] = true;
		}else{
			$errorList['repeatPassword'] = 'Пароли не совпадают';
			$errorList['repeatPasswordOk'] = false;
		}
	}

	//проверка почты
	//введена ли почта
	if(strlen($email) == 0){
		$errorList['email'] = 'Вы не ввели электронную почту';
		$errorList['emailOk'] = false;
	}else{
		//правильность почты
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			$ok['email'] = true;
			$errorList['emailOk'] = true;
		}else{
			$errorList['email'] = 'Электронная почта не соответствует требования';
			$errorList['emailOk'] = false;
		}
	}

	//проверка на таких же имен пользоватей
	if($ok['login']){
		//ищем в бд
		$checkLogins = mysqli_query($link, "SELECT id_users FROM users WHERE login='".$login."'");
		//проверяем
		if (mysqli_num_rows($checkLogins) == 0) {
			$ok['checkLogins'] = true;
			$errorList['loginOk'] = true;			
		}else{
			$errorList['login'] = 'Такой пользователь уже существует';
			$errorList['loginOk'] = false;
		}
	}

	//проверка на таких же почт
	if($ok['email']){
		//ищем в бд
		$checkEmails = mysqli_query($link, "SELECT id_users FROM users WHERE email='".$email."'");
		//проверяем
		if (mysqli_num_rows($checkEmails) == 0) {
			$ok['checkEmails'] = true;
			$errorList['emailOk'] = true;			
		}else{
			$errorList['email'] = 'Такая электронная почта уже зарегистрирована';
			$errorList['emailOk'] = false;
		}
	}
	
	if($checkbox == 'on'){
		$ok['checkbox'] = true;
		$errorList['Ok'] = true;
	}else{
		$errorList['checkbox'] = 'Вы не согласились с правилами';
		$errorList['checkboxOk'] = false;
	}
	//наконец регистрируем пользователя
	if($ok['login'] && $ok['password'] && $ok['repeatPassword'] && $ok['email'] && $ok['checkLogins'] && $ok['checkEmails'] && $ok['checkbox']){

		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		mysqli_query($link, "INSERT INTO users (login, password, email, rating, date_registration, money, image, country, city, last_enter) 
			VALUES ('".$login."','".$hashedPassword."', '".$email."', '0', '".date('d.m.Y H:i')."' , '0', '0', '0', '0', '".date('d.m.Y H:i')."')");
			$errorList['confirmRegistration'] = true;
	}

	//вывод данных
	echo json_encode($errorList);
 ?>