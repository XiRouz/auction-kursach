<?php 
	include_once 'config.php';

	if($_COOKIE['auth'] == 'false' || !isset($_COOKIE['auth'])){
		$error = 'Вам необходимо авторизоваться, чтобы поставить на данный лот';
	}

	if($_COOKIE['auth'] == 'true'){
		$bet = $_POST['inputBet'];
		$id_lot = $_POST['id_lotH'];
		$start_price = $_POST['start_priceH'];
		$last_bet = $_POST['last_betH'];
		$price = $_POST['priceH'];
		$priceOrBet = $_POST['priceOrBet'];
		$date = date('d.m.Y H:i');

		if($bet == 0){
			$error = 'Вы не указали ставку';
		}else{
			if($priceOrBet == 0){
				if($bet < $start_price){
					$error = 'Нельзя поставить меньше назначенной цены';
				}else{
					if($bet == $start_price){
						$error = 'Вы указали такую же цену';
					}else{
						if($price != 0){
							if($bet == $price){
								$error = 'Размер ставки равен выкупной цене';
							}else{
								if($bet > $price){
									$error = 'Размер ставки больше выкупной цены';
								}else{
									$ok = true;
								}
							}
						}else{
							$ok = true;
						}
					}
				}
			}else{
				if($bet < $last_bet){
					$error = 'Нельзя поставить меньше назначенной цены';
				}else{
					if($bet == $last_bet){
						$error = 'Вы указали такую же цену';
					}else{
						if($price != 0){
							if($bet == $price){
								$error = 'Размер ставки равен выкупной цене';
							}else{
								if($bet > $price){
									$error = 'Размер ставки больше выкупной цены';
								}else{
									$ok = true;
								}
							}
						}else{
							$ok = true;
						}
					}
				}
			}
		}

		if($ok == true){
			$error = 'Ставка сделана';
			//ставим
			$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login = '" .$_COOKIE['login']. "'"));
			mysqli_query($link, "INSERT INTO bets (id_lot, id_user, bet, date_bet) VALUES ('".$id_lot."','".$data['id_users']."', '".$bet."', '".$date."')"); 	
		}
	}

	echo $error;
?>