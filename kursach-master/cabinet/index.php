<?php 
	//редирект если не авторизован
	if($_COOKIE['auth']=='false' || !isset($_COOKIE['auth'])){
		print '<script type="text/javascript"> window.location.href = "../index.php" </script>';
	}

	include_once '../_logout.php';
	include_once '../config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Личный кабинет</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/style.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="../js/script.js"></script>
</head>
<body class="continer-fluid">
	<div class="container">

		<!-- шапка -->
		<!-- ================================================================================================= -->
	    <?php include_once '../header.php'; ?>	
	    
	    <div id="mainblock">
	    	<!-- хидер кабинета -->
	    	<div class="header-cabinet navbar justify-content-between">
	    		<a class="navbar-brand" href="index.php">Личный кабинет</a>
	    		<div></div>
	    		<a href="index.php?newlot" class="btn btn-primary" id="newlot">Создать лот</a>
	    		<div class="nav nav-tabs">
		    		<a class="nav-item nav-link" id="nav-lots" href="index.php?nav=lots">Лоты</a>
		    		<a class="nav-item nav-link" id="nav-msg" href="index.php?nav=msg">Сообщения</a>
		    		<a class="nav-item nav-link" id="nav-money" href="index.php?nav=money">Баланс</a>
		    		<a class="nav-item nav-link" id="nav-settings" href="index.php?nav=settings">Настройки</a>	
	    		</div>
	    	</div>
	    	<!-- конец хидера кабинета -->
			



			<!-- велком -->
			<div id="welcome-cabinet" class="my-5 px-3">
				<strong>Добро пожаловать в личный кабинет! Здесь вы можете посмотреть ваш баланс, изменить настройки, просмотреть свои выиграные и данные ставки на лоты, а также личные сообщения и уведомления.</strong>
			</div>



			<!-- ===================
					лоты 
			==================== -->
			<div id="lots-content" class="hide">
				<?php include_once 'lots.php'; ?>				
			</div>
			


			<!-- ===================
					сообщения 
			==================== -->
			<div id="msg-content" class="hide">
				<?php include_once 'msg.php'; ?>
			</div>
			


			<!-- ===================
					баланс
			==================== -->
			<div id="money-content" class="hide">
				<center><h4>баланс</h4></center>
			</div>
	


			<!-- ===================
					настройки 
			==================== -->
			<div id="settings-content" class="hide pt-3">
				<?php include_once 'settings.php'; ?>
			</div>



			<!-- ===================
			  создание нового лота 
			==================== -->
			<div id="newlot-content" class="hide">
				<h4 class="py-4"><strong>Создание нового лота</strong></h4>
				<form class="col-md-12 mb-5" enctype="multipart/form-data" method="post" name="formCreateLot" id="formCreateLot">

					<div class="form-group">
						<label>Название лота</label>
						<div class="row">
							<div class="col-6">
								<input type="text" class="form-control" name="inputLotName" id="inputLotName">
							</div>
							<div class="col mt-1" id="errorLotName"></div>
						</div>
						
					</div>

					<div class="form-group">
						<label>Описание</label>
						<div class="row">
							<div class="col-6">
								<textarea class="form-control" rows="5" name="inputDescription" id="inputDescription"></textarea>
							</div>
							<div class="col mt-1" id="errorDescription"></div>
						</div>
						
					</div>

					<div class="row">
						<div class="col-3">
							<label>Категория</label>
							<select class="form-control" id="select-category" name="select-category">
								<option value="0">Все категории</option>
								<?php 
									$query = mysqli_query($link, "SELECT * FROM category");
								    while ($row = mysqli_fetch_array($query)) {
								    	echo '<option value="'.$row['id_category'].'">'.$row["category"].'</option>';
								    }
								?>
					      	</select>
						</div>
						<div class="col-6">
							<label>Подкатегория</label>
							<div class="row">
								<div class="col-6">
									<select class="form-control" id="select-subcategory" name="select-subcategory">
							        	<option value="0-0">Все подкатегории</option>
							        	<?php 
											$query = mysqli_query($link, "SELECT * FROM subcategory");
										    while ($row = mysqli_fetch_array($query)) {
										    	echo '<option value="'.$row["id_category"].'-'.$row["id_subcategory"].'" class="hide">'.$row["subcategory"].'</option>';
										    }
										?>
							      	</select>
								</div>
								<div class="col mt-1" id="errorSubcategory"></div>
							</div>
							
						</div>
					</div>

					<div class="form-group">
						<label>Начальная цена</label>
						<div class="row">
							<div class="col-6">
								<input type="number" min="1" class="form-control" name="inputStartPrice" id="inputStartPrice">
								<small>Оставьте поле пустым, если лот можно будет только выкупить</small>
							</div>
							<div class="col mt-1" id="errorStartPrice"></div>
						</div>
						
					</div>

					<div class="form-group">
						<label>Цена выкупа</label>
						<div class="row">
							<div class="col-6">
								<input type="number" min="1" class="form-control" name="inputPrice" id="inputPrice">
								<small>Оставьте поле пустым, если не хотите быстрой покупки лота</small>
							</div>
							<div class="col mt-1" id="errorPrice"></div>
						</div>
						
					</div>

					<div class="form-group">
						<label>Изображение</label>
						<div class="row">
							<div class="col-6">
								<input type="file" class="form-control-file" name="inputImage" id="inputImage">
							</div>
							<div class="col mt-1" id="errorImage"></div>
						</div>
						
					</div>

					<div class="form-group">
						<label>Местонахождение</label>
						<div class="row">
							<div class="col-6">
								<textarea class="form-control" rows="2" name="inputLocation" id="inputLocation"></textarea>
							</div>
							<div class="col mt-1" id="errorLocation"></div>
						</div>
						
					</div>

					<div class="form-group">
						<label>Доставка</label>
						<div class="row">
							<div class="col-6">
								<textarea class="form-control" rows="2" name="inputDelivery" id="inputDelivery"></textarea>
							</div>
							<div class="col mt-2" id="errorDelivery"></div>
						</div>
					</div>

					<div class="form-group">
						<label>Дата окончания</label>
						<div class="row">
							<div class="col-6">
								<input type="date" class="form-control" name="inputDateEnd" id="inputDateEnd">
							</div>
							<div class="col mt-1" id="errorDateEnd"></div>
						</div>
						
					</div>

					<div class="row justify-content-center col-6">
						<input type="button" class="btn btn-primary col-lg-2" value="Создать" id="createLot">
					</div>

				</form>
				<div class="createLotInfo row justify-content-center hide h4 pb-5"></div>
			</div>



	    	<?php 
	    		//если авторизованы
	    		if($_COOKIE['auth']=='true'){ 
    				//открываем лоты
					if($_GET['nav']=='lots'){
						echo '<script>
								$("#nav-lots").addClass("active"); 
								$("#lots-content").addClass("show");
								$("#welcome-cabinet").addClass("hide");
						      </script>';
					}

					//открываем сообщения
					if($_GET['nav']=='msg'){
						echo '<script>
								$("#nav-msg").addClass("active"); 
								$("#msg-content").addClass("show");
								$("#welcome-cabinet").addClass("hide");
						      </script>';
					}

					//открываем баланс
					if($_GET['nav']=='money'){
						echo '<script>
								$("#nav-money").addClass("active"); 
								$("#money-content").addClass("show");
								$("#welcome-cabinet").addClass("hide");
						      </script>';
					}

					/* открываем настройки */
					if($_GET['nav']=='settings'){
						echo '<script>
							$("#nav-settings").addClass("active"); 
							$("#settings-content").addClass("show");
							$("#welcome-cabinet").addClass("hide");
						</script>';

						/* основные настройки */
						if(isset($_GET['main'])){
							echo '<script>
								$("#main_settings").show();
								$("#pass_settings").hide();
							</script>';
						}

						/* изменение пароля */
						if(isset($_GET['pass'])){
							echo '<script>
								$("#pass_settings").show();
								$("#main_settings").hide();
							</script>';
						}
					}

					if(isset($_GET['newlot'])){
						echo '<script>
								$("#newlot-content").addClass("show");
								$("#welcome-cabinet").addClass("hide");
						      </script>';
					}

/*
					if(isset($_POST['changeSettings'])){
						if((!empty($_FILES['inputAvatar'])) && ($_FILES['inputAvatar']['error'] == 0)){
							if ((($_FILES['inputAvatar']['type'] == "image/jpeg")
							|| ($_FILES['inputAvatar']['type'] == "image/jpg")
							|| ($_FILES['inputAvatar']['type'] == "image/png"))
							&& ($_FILES['inputAvatar']['type'] < 20000)){
								$user = mysqli_fetch_assoc(mysqli_query("SELECT * FROM users WHERE login LIKE '" .$_COOKIE['login']. "'"));
								mysqli_query("UPDATE users SET image = '1' WHERE id_users = " .$user['id_users']);
								//перемещаем загруженный файл в новое место
								move_uploaded_file($_FILES['inputAvatar']['tmp_name'], '../img/img-user/id-' .$user["id_users"]. '.jpg');
							}else{
								echo '<strong style="color: red;">- Файл не является изображением</strong>';
							}
						}else{
							echo '<strong style="color: red;">- Вы не выбрали изображение</strong>';
						}
					}*/
	    		}
	    	?>
	    </div>

	    <?php include_once '../footer.php'; ?>
	</div>
</body>
</html>