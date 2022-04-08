<?php
	include_once '../config.php';

	mysqli_query($link, "UPDATE messages SET unread = 0 WHERE from_id_users = ". $_POST['from'] ." AND to_id_users = ". $_POST['to']);
	mysqli_query($link, "UPDATE messages SET unread = 0 WHERE from_id_users = ". $_POST['to'] ." AND to_id_users = ". $_POST['from']);

	echo $_POST['to'];
?>