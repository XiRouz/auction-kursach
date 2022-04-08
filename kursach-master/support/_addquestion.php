<?php
	include_once '../config.php';

	/* если не авторизованы */
	if($_COOKIE['auth'] == 'false' || !isset($_COOKIE['auth'])){
		$errorList['auth'] = 'Вам необходимо авторизоваться, чтобы задать вопрос в тех. поддержку';
	}else{
		/* иначе проверяем и добавляем */
		$title = $_POST['question_head'];
		$priority = $_POST['priority'];
		$question = $_POST['question'];

		/* тема */
		if(strlen($title) == 0){
			$errorList['title'] = '- Вы не указали тему';
			$errorList['titleOk'] = false;
		}else{
			$ok['title'] = true;
			$errorList['titleOk'] = true;
		}

		/* вопрос */
		if(strlen($question) == 0){
			$errorList['question'] = '- Нужно описать вопрос';
			$errorList['questionOk'] = false;
		}else{
			if(strlen($question) < 3){
				$errorList['question'] = '- Слишком короткий вопрос';
				$errorList['questionOk'] = false;
			}else{
				if(strlen($question) > 1000){
					$errorList['question'] = '- Слишком длинный вопрос';
					$errorList['questionOk'] = false;
				}else{
					$ok['question'] = true;
					$errorList['questionOk'] = true;
				}
			}	
		}

		/* файл вопроса */
		/*if((!empty($_FILES['questionImage'])) && ($_FILES['questionImage']['error'] == 0)){
			if ((($_FILES['questionImage']['type'] == "image/jpeg")
			|| ($_FILES['questionImage']['type'] == "image/jpg")
			|| ($_FILES['questionImage']['type'] == "image/png"))
			&& ($_FILES['questionImage']['type'] < 20000)){
				$lastid = mysqli_fetch_row(mysqli_query("SELECT MAX(id) FROM issues")); $lastid[0]++;
				//перемещаем загруженный файл в новое место
				move_uploaded_file($_FILES['questionImage']['tmp_name'], dirname(__FILE__).'/img/img-question/id-' .$lastid[0]. '.jpg');

				$ok['question_image'] = true;
				$errorList['questionImageOk'] = true;
			}else{
				$errorList['questionImage'] = '- Файл не является изображением';
				$errorList['questionImageOk'] = false;
			}
		}*/

		if($ok['title'] && $ok['question'] /*&& $ok['question_image']*/){
			$user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login LIKE '". $_COOKIE['login'] ."'"));
			mysqli_query($link, "INSERT INTO issues (id_user, title, priority, question, date_submit) VALUES ('". $user['id_users'] ."', '". $title ."', '". $priority ."', '". $question ."', '". date('d.m.Y H:i') ."')");	
			// echo mysqli_error($link);
			$errorList['createQuestion'] = true;
		}
	}
	
	echo json_encode($errorList);
?>