<?php
	include_once 'config.php';

	if($_COOKIE['auth'] == 'false' || !isset($_COOKIE['auth'])){
		$error = 'Вам необходимо авторизоваться, чтобы написать комментарий';
	}

	if($_COOKIE['auth'] == 'true'){
		$comment = trim($_POST['inputComment']);
		$id_lot = $_POST['id_lotCom'];
		$id = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login = '" .$_COOKIE['login']. "'"));
		$id_users = $id['id_users'];
		$date_dispatch = date('d.m.Y H:i');

		if(strlen($comment) == 0){
			$error = 'Вы не написали комментарий';
		}else{
			if(strlen($comment) > 1000){
				$error = 'Слишком длинный комментарий';
			}else{
				mysqli_query($link, "INSERT INTO comments (id_lot, comment, date_dispatch, id_users) 
				VALUES ('".$id_lot."','".$comment."', '".$date_dispatch."', '".$id_users."')");
			}
		}
	}

	echo $error;
?>