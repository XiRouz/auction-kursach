<?php
	include_once 'config.php';

	$lot_name = trim($_POST['inputLotName']);
	$start_price = trim($_POST['inputStartPrice']);
	$price = trim($_POST['inputPrice']);
	$description = trim($_POST['inputDescription']);
	$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT id_users FROM users WHERE login='".mysqli_real_escape_string($link, $_COOKIE['login'])."' LIMIT 1")); $id_users = $data['id_users'];
	$date_start = date('d.m.Y H:i');
	$date_end_notformat = date_create($_POST['inputDateEnd']);
	$date_end = date_format($date_end_notformat, 'd.m.Y').' '.date('H:i');
	$location = trim($_POST['inputLocation']);
	$delivery = trim($_POST['inputDelivery']); 
	$explode_subcategory = explode('-', trim($_POST['select-subcategory']), 2); $id_subcategory = $explode_subcategory[1];


	//название лота
	if(strlen($lot_name) == 0){
		$errorList['lot_name'] = '- Вы не ввели название лота';
		$errorList['lot_nameOk'] = false;
	}else{
		if(strlen($lot_name) < 3){
			$errorList['lot_name'] = '- Слишком короткое название лота';
			$errorList['lot_nameOk'] = false;
		}else{
			if(strlen($lot_name) > 100){
				$errorList['lot_name'] = '- Слишком длинное название лота';
				$errorList['lot_nameOk'] = false;
			}else{
				$ok['lot_name'] = true;
				$errorList['lot_nameOk'] = true;
			}
		}	
	}

	//описание
	if(strlen($description) == 0){
		$errorList['description'] = '- Нужно заполнить описание';
		$errorList['descriptionOk'] = false;
	}else{
		if(strlen($description) > 1000){
			$errorList['description'] = '- Слишком длинное описание лота';
			$errorList['descriptionOk'] = false;
		}else{
			$ok['description'] = true;
			$errorList['descriptionOk'] = true;
		}	
	}

	//если начальные цены пустые, равны 0 или отрицательны
 	if(strlen($start_price) == 0 || $start_price == 0){
		$null_start_price = true;
	}else{
		if($start_price < 0){
			$neg_start_price = true;
		}
	}
	if(strlen($price) == 0 || $price == 0){
		$null_price = true;
	}else{
		if($price < 0){
			$neg_price = true;
		}
	}
	if($null_start_price == true && $null_price == true){
		$errorList['need_another_price'] = '- Нужно указать одну из цен';
		$errorList['need_another_priceOk'] = false;
	}else{
		$ok['need_another_price'] = true;
		$errorList['need_another_priceOk'] = true;
	}
	if($neg_start_price == true) {
		$errorList['neg_start_price'] = '- Начальная цена не может быть отрицательной';
		$errorList['neg_start_priceOk'] = false;
	}else{
		$ok['neg_start_price'] = true;
		$errorList['neg_start_priceOk'] = true;
	}
	if($neg_price == true) {
		$errorList['neg_price'] = '- Цена выкупа не может быть отрицательной';
		$errorList['neg_priceOk'] = false;
	}else{
		$ok['neg_price'] = true;
		$errorList['neg_priceOk'] = true;
	}

	// //если начальные цены отрицательны
	// if($start_price < 0){
	// 	$neg_start_price = true;
	// }
	// if($price < 0){
	// 	$neg_price = true;
	// }
	// if($null_start_price == true && $null_price == true){
	// 	$errorList['need_another_price'] = '- Нужно указать одну из цен';
	// 	$errorList['need_another_priceOk'] = false;
	// }else{
	// 	$ok['need_another_price'] = true;
	// 	$errorList['need_another_priceOk'] = true;
	// }


	//местонахождение
	if(strlen($location) == 0){
		$errorList['location'] = '- Нужно указать местонахождение';
		$errorList['locationOk'] = false;
	}else{
		if(strlen($location) < 5){
			$errorList['location'] = '- Слишком короткое описание местонахождение';
			$errorList['locationOk'] = false;
		}else{
			if(strlen($location) > 100){
				$errorList['location'] = '- Слишком длинное описание местонахождение';
				$errorList['locationOk'] = false;
			}else{
				$ok['location'] = true;
				$errorList['locationOk'] = true;
			}
		}
	}

	//доставка
	if(strlen($delivery) == 0){
		$errorList['delivery'] = '- Нужно указать способ доставки';
		$errorList['deliveryOk'] = false;
	}else{
		if(strlen($delivery) < 5){
			$errorList['delivery'] = '- Слишком короткое описание доставки';
			$errorList['deliveryOk'] = false;
		}else{
			if(strlen($delivery) > 200){
				$errorList['delivery'] = '- Слишком длинное описание доставки';
				$errorList['deliveryOk'] = false;
			}else{
				$ok['delivery'] = true;
				$errorList['deliveryOk'] = true;
			}
		}	
	}

	if(strlen($date_end) == 0){
		$errorList['date_end'] = '- Вы не указали дату окончания';
		$errorList['date_endOk'] = false;
	}else{
		$ddate_e = date_create($date_end);
		$ddate_s = date_create($date_start);
		if($ddate_e < $ddate_s || $ddate_e == $ddate_s){
			$errorList['date_end'] = '- Нельзя указывать прошлую дату или сегодняшнюю дату';
			$errorList['date_endOk'] = false;
		}else{
			$ok['date_end'] = true;
			$errorList['date_endOk'] = true;
		}
	}

	//категория
	if($id_subcategory == 0){
		$errorList['subcategory'] = '- Вы не выбрали подкатегорию лота';
		$errorList['subcategoryOk'] = false;
	}else{
		$ok['subcategory'] = true;
		$errorList['subcategoryOk'] = true;
	}

	/* проверка изображения */
	// $errorList['image'] = $_FILES['lot-image']['name'];
	// $errorList['imageOk'] = false;
	if((!empty($_FILES['lot-image'])) && ($_FILES['lot-image']['error'] == 0)){
		if ((($_FILES['lot-image']['type'] == "image/jpeg")
		|| ($_FILES['lot-image']['type'] == "image/jpg")
		|| ($_FILES['lot-image']['type'] == "image/png"))
		&& ($_FILES['lot-image']['type'] < 20000)){
			$lastid = mysqli_fetch_row (mysqli_query($link, "SELECT MAX(id_lot) FROM lot")); $lastid[0]++;
			//перемещаем загруженный файл в новое место
			move_uploaded_file($_FILES['lot-image']['tmp_name'], dirname(__FILE__).'/img/img-lot/id-' .$lastid[0]. '.jpg');

			$ok['image'] = true;
			$errorList['imageOk'] = true;
		}else{
			$errorList['image'] = '- Файл не является изображением';
			$errorList['imageOk'] = false;
		}
	}else{
		$errorList['image'] = '- Вы не выбрали изображение';
		$errorList['imageOk'] = false;
	}


	if($ok['lot_name'] && $ok['description'] && $ok['neg_start_price'] && $ok['neg_price'] && $ok['location'] && $ok['delivery'] && $ok['date_end'] && $ok['subcategory'] && $ok['image']){
		$query = "INSERT INTO lot (id_lot, lot_name, start_price, price, decription, id_users, date_start, date_end, location, delivery, id_subcategory) VALUES (NULL, '".$lot_name."', '".$start_price."', '".$price."', '".$description."', '".$id_users."', '".$date_start."', '".$date_end."', '".$location."', '".$delivery."', '".$id_subcategory."')";
		$sql = mysqli_query($link, $query);	

		$errorList['createLot'] = true;
		$errorList['id_now_create_lot'] = mysqli_insert_id($link);
	}
	
	echo json_encode($errorList);
?>