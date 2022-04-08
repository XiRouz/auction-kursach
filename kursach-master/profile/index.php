<?php
	include_once '../_logout.php';
	include_once '../config.php';

	/* если есть id, тогда все норм */
	if($_GET['id'] == '' || !isset($_GET['id'])){
		$isset_id = false;
	}else{
		$query_profile_user = mysqli_query($link, "SELECT * FROM users WHERE id_users = '". $_GET['id'] ."'");

		/* пустой ли запрос */
		if(mysqli_num_rows($query_profile_user) == 0){
			$isset_id = false;
		}else{
			$profile_user = mysqli_fetch_assoc($query_profile_user);
			$isset_id = true;
		}
		
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>
	<?php
		if($isset_id) echo 'Просмотр профиля: '. $profile_user['login']; else echo 	'Нет такого пользователя';
	?>
	</title>
	<link rel="shortcut icon" href="../img/favicon.jpg" type="image/png">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="../js/script.js"></script>
<body class="container-fluid">
	<div class="container">

	<!-- шапка -->
	<!-- ================================================================================================= -->
    <?php include_once '../header.php'; ?>	
	
   	<!-- основной блок -->
   	<!-- ================================================================================================= -->
    <div class="mainblock">
    	<?php
    		if($isset_id){
    			echo '<div class="profile_user">
		    		<div class="d-flex flex-row p-2">
						<div class="col-md-2"><img src="'.wayDir().'img/img-user/id-' .$profile_user["image"]. '.jpg" width="100%" height="100%" class="avatar"></div>
						<div class="col-md-10 row mx-0">
							<div class="col-md-9">
								<div class="h5">'. $profile_user['login'] .'</div>
								<div>Зарегистрирован: <i>'. $profile_user['date_registration'] .'</i></div>
								<div>Последний вход: <i>'. $profile_user['last_enter'] .'</i></div>
								<div>Страна: <i>';

									$country = ['Не указано', 'Россия'];
									$i = 0;
									foreach ($country as $ctry) {
										if($profile_user['country'] == $i) echo $ctry;
										$i++;
									}

								echo '</i></div>
								<div>Город: <i>';

								$city = ['Не указано', 'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Нижний Новгород', 'Магнитогорск', 'Казань', 'Челябинск', 'Омск', 'Самара', 'Ростов-на-Дону', 'Уфа', 'Красноярск', 'Пермь', 'Воронеж', 'Волгоград'];
								$i = 0;
								foreach ($city as $cty) {
									if($profile_user['city'] == $i) echo $cty;
									$i++;
								}

								echo '</i></div>
							</div>
							<div class="col-md-3 pt-1">';

								if($_COOKIE['login'] != $profile_user['login']) echo '<div><a href="'. way() .'cabinet/index.php?nav=msg&id='. $profile_user["id_users"] .'">Написать сообщение <img src="' .wayDir(). 'img/message.png" width="15" height="15" style="padding-bottom: 1px;"></a></div>';
								
								echo '<div><a href="'. way() .'lot/index.php?search=&category=0&user='. $profile_user["id_users"] .'">Товары пользователя <img src="' .wayDir(). 'img/goods.jpg" width="15" height="15" style="padding-bottom: 1px;"></a></div>
							</div>
						</div>
					</div>
					<div class="row pb-2 mt-2">
						<div class="col-md-6 border-right" style="padding-left: 40px;"><u>Дополнительная информация</u>: <br>'. $profile_user['info'] .'</div>
						<div class="col-md-6"><u>Отзывы:</u></div>
					</div>
		    	</div>';
    		}else{
    			echo '<div class="h4 my-4">Такого пользователя не существует</div>';
    		}
    	?>
	</div>

    <!-- подвал -->
    <!-- ================================================================================================= -->
    <?php include_once '../footer.php'; 

    ?>    
	</div>	
</body>
</html>