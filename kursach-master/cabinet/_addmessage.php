<?php
	include_once '../config.php';

	$msg = trim($_POST['inputMessage']);
	$self_id = $_POST['self_id'];
	$to = $_POST['to'];

	if(strlen($msg) == 0)
	{
		$error = 'Ошибка: пустое сообщение';
	}else{
		if(strlen($msg) > 1000)
		{
			$error = 'Ошибка: слишком длинное сообщение';
		}else{
			mysqli_query($link, "INSERT INTO messages (id, message, date_dispatch, from_id_users, to_id_users, unread) VALUES (NULL, '".$msg."', '".date('d.m.Y H:i')."', '".$self_id."', '".$to."', true)");	
		}
	}

	echo $error;
?>