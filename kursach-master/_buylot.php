<?php
	include_once 'config.php';

	if($_COOKIE['auth'] == 'false' || !isset($_COOKIE['auth'])){
		$error = 'Вам необходимо авторизоваться, чтобы выкупить данный лот';
	}

	if($_COOKIE['auth'] == 'true'){
		$id_lot = $_POST['id_lotH'];
		$bet = 'buy';
		$date = date('d.m.Y H:i');
		
		$lot = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM lot WHERE id_lot = '". $id_lot ."'"));
		$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login = '" .$_COOKIE['login']. "'"));

		// отправка сообщения
		mysqli_query($link, "INSERT INTO messages (message, date_dispatch, from_id_users, to_id_users, unread) VALUES ('Пользователь <strong><a href=\'../cabinet/index.php?nav=msg&id=". $data['id_users'] ."\'>". $data['login'] ."</a></strong> купил ваш лот <strong><a href=\"../lot/index.php?id=". $id_lot ."\">#". $id_lot ." ". $lot['lot_name'] ."</a></strong> <i>". date('d.m.Y') ."</i> в <i>". date('H:i') ."</i>.', '". $date ."', '1', '". $lot['id_users'] ."', '1')");

		// покупка
		mysqli_query($link, "INSERT INTO bets (id_lot, id_user, bet, date_bet) VALUES ('".$id_lot."','".$data['id_users']."', '".$bet."', '".$date."')"); 
	}
?>