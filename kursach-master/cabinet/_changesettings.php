<?php
	include_once '../config.php';

	$country = $_POST['country'];
	$city = $_POST['city'];
	$moreInfo = $_POST['moreInfo'];	
	$ok = 'false'; 



	if($country != 0){
		mysqli_query($link, "UPDATE users SET country = '". $country ."' WHERE login = '". $_COOKIE['login'] ."'");
		$ok = 'true';
	}

	if($city != 0){
		mysqli_query($link, "UPDATE users SET city = '". $city ."' WHERE login = '". $_COOKIE['login'] ."'");
		$ok = 'true';
	}

	if(strlen($moreInfo) != 0){
		mysqli_query($link, "UPDATE users SET info = '". $moreInfo ."' WHERE login = '". $_COOKIE['login'] ."'");
		$ok = 'true';
	}

	if((!empty($_FILES['user-image'])) && ($_FILES['user-image']['error'] == 0)){
		if ((($_FILES['user-image']['type'] == "image/jpeg")
		|| ($_FILES['user-image']['type'] == "image/jpg")
		|| ($_FILES['user-image']['type'] == "image/png"))
		&& ($_FILES['user-image']['type'] < 20000)){

			$id_for_file = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login = '". $_COOKIE['login'] ."'"));
			move_uploaded_file($_FILES['user-image']['tmp_name'], '../img/img-user/id-' .$id_for_file['id_users']. '.jpg');
			mysqli_query($link, "UPDATE users SET image = '". $id_for_file['id_users'] ."' WHERE login = '". $_COOKIE['login'] ."'");

			$ok = 'true';
		}
	}

	echo $ok;
?>