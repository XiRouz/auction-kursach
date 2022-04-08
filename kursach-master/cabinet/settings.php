<div class="row">
	<div class="col-md-2">
		<div class="list-group list-group-settings">
			<a href="index.php?nav=settings&main" class="list-group-item list-group-item-action dontborderradius p-3" id="nav-main_sett">Основные настройки</a>
			<a href="index.php?nav=settings&pass" class="list-group-item list-group-item-action dontborderradius p-3" id="nav-password_sett">Изменение пароля</a>
		</div>	
	</div>
	<div class="col-md-10">

		<!-- основные настройки -->
		<div id="main_settings">
			<h4>Основные настройки:</h4>
			<hr>
			<form enctype="multipart/form-data" id="formMainSettings">
				<div class="form-row mx-0">
					<div class="form-group">
					<?php
						$user_settings = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login LIKE '". $_COOKIE["login"] ."'"));
						echo '<img src="'.wayDir().'img/img-user/id-' .$user_settings["image"]. '.jpg" width="100" height="100" class="avatar">';
					?>
					</div>
					<div class="form-group m-3">
						<label class="mb-0">Измените фотографию для Вашего личного профиля.</label>
						<input type="file" class="form-control border-0 pl-0" id="inputAvatar" name="inputAvatar">
					</div>
					
				</div>
				<div class="form-group p-2" style="border: 3px solid lightgray; border-radius: 5px">
					<?= 'Просмотр вашего профиля: <a href="'. way() .'profile/?id='. $user_settings["id_users"] .'"> http:/'. way() .'profile/?id='. $user_settings["id_users"] .'</a>'; ?>
				</div>
				<h5 class="mt-5">Местонахождение:</h5>
				<hr>
				<div class="form-row mx-0">
					<div class="form-group mr-2">
						<label class="ml-1">Страна:</label>
						<select class="form-control" id="inputCountry" name="inputCountry">
							<?php 
								$country = ['Выберите страну', 'Россия'];
								$i = 0;
								foreach ($country as $ctry) {
									echo '<option value="'. $i .'">'. $ctry .'</option>';
									$i++;
								}
							?>
						</select>
					</div>
					<div class="form-group ml-2">
						<label class="ml-1">Город:</label>
						<select class="form-control" id="inputCity" name="inputCity">
							<?php 
								$city = ['Выберите город', 'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Нижний Новгород', 'Магнитогорск', 'Казань', 'Челябинск', 'Омск', 'Самара', 'Ростов-на-Дону', 'Уфа', 'Красноярск', 'Пермь', 'Воронеж', 'Волгоград'];
								$i = 0;
								foreach ($city as $cty) {
									echo '<option value="'. $i .'">'. $cty .'</option>';
									$i++;
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group pt-5">
					<label>Дополнительная контактная информация:</label>
					<small class="form-text text-muted m-0 mb-3">
						Дополнительные телефонные номера, email, ICQ, Skype и др. Эта информация будет полезна, при совершении с Вами какой-либо сделки, например при покупке или продаже товаров.
					</small>
    				<textarea class="form-control" id="inputMoreInfo" name="inputMoreInfo" rows="5"></textarea>
				</div>
				<input type="button" class="btn btn-primary mb-3" id="changeSettings" name="changeSettings" value="Сохранить">
			</form>
			<div id="infoChangeMainSettings" class="mb-3"></div>
		</div>

		<!-- изменение пароля -->
		<div id="pass_settings">
			<h4>Изменение пароля:</h4>
			<hr>
			<form id="formChangePassword" name="formChangePassword" class="mb-3">
				<div class="form-group">
					<label>Введите старый пароль</label>
					<input type="password" class="form-control col-md-6" id="inputOldPassword">
					<div id="errorOldPassword" class="mx-2"></div>
				</div>
				<div class="form-group">
					<label>Введите новый пароль</label>
					<input type="password" class="form-control col-md-6" id="inputNewPassword1">
					<div id="errorNewPassword1" class="mx-2"></div>
				</div>
				<div class="form-group">
					<label>Повторите новый пароль</label>
					<input type="password" class="form-control col-md-6" id="inputNewPassword2">
					<div id="errorNewPassword2" class="mx-2"></div>
				</div>
				<input type="button" id="GoChangePassword" name="GoChangePassword" class="btn btn-primary" value="Изменить">
			</form>
			<div id="infoChangePassword" class="mb-3"></div>
		</div>
		
	</div>
</div>

<?php 
	/* выделение итемов в меню */
	if(isset($_GET['main'])) echo '<script>$(".list-group-settings #nav-main_sett").addClass("bg-info text-white");</script>';
	if(isset($_GET['pass'])) echo '<script>$(".list-group-settings #nav-password_sett").addClass("bg-info text-white");</script>';
?>