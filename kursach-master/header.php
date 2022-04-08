<?php 
	include_once 'config.php';
	//print_r(explode('/', $_SERVER['PHP_SELF'], -1));
	//echo '<br>'.way();
	//echo '<br>'.wayDir();

	$query = mysqli_query($link, "SELECT * FROM category");
?>
<nav class="header navbar navbar-light justify-content-between">
	<a class="navbar-brand" id="logo" href=<?= '"'.way().'"' ?>>Аукцион</a>
	<?php
		if($_COOKIE['auth']=='false' || !isset($_COOKIE['auth'])){
			echo '<form class="form-row mt-3" id="formAuthorization">
					<div class="form-group mr-sm-2">
						<input class="form-control" type="text" placeholder="Логин или Email" name="inputLoginAuth" id="inputLoginAuth">
						<a href="#" data-toggle="modal" data-target="#registrationModal">Регистрация</a>
						<div id="loginInfo"></div>
					</div>
					<div class="form-group mr-sm-2">
						<input type="password" class="form-control" placeholder="Пароль" name="inputPasswordAuth" id="inputPasswordAuth">
					</div>
					<div class="form-group">
						<input type="button" class="btn btn-primary" value="Войти" name="authorization" id="authorization">
					</div>
				  </form>';
		}
		if($_COOKIE['auth'] == 'true'){
			echo '<!-- приватный хидер -->
			<div class="private-header border">
				<div class="d-flex" style="height: 65px">
					<!-- аватар -->
				    <div class="p-2">
				    	<a href="'.way().'cabinet">';
				    	$user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login LIKE '" .$_COOKIE['login']. "'"));
				    	echo '<img src="'.wayDir().'img/img-user/id-' .$user["image"]. '.jpg" width="50" height="50" class="avatar">';

				    	
				   echo'</a>
				    </div>
				    <!-- логин, сообщения, деньги -->
				    <div class="align-self-start p-2 mr-4">
						<div class="flex-column">
							<a href="'.way().'cabinet">'.$_COOKIE['login'].'</a>
							<div class="mt-1">
								<a href="'.way().'cabinet/index.php?nav=msg"><img src="'.wayDir().'img/message.png" width="17" height="17" class="mb-1"><span id="message">0</span></a>    
								<a href="'.way().'cabinet/index.php?nav=money"><img src="'.wayDir().'img/rub.png" width="17" height="17" class="mb-1 ml-2"><span id="money">';

								$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT money FROM users WHERE login='".$_COOKIE['login']."'"));
								echo $data['money'];
								
								echo 
								'</span></a>
							</div>
						</div>						
				    </div>
				    <!-- меню приватного хидера -->
				    <div class="private-menu p-2 mt-2 ml-4">
						<div class="btn-group">
							<button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Действия</button>
							<div class="dropdown-menu">
								<form method="post">
									<a class="dropdown-item" href="'.way().'cabinet/index.php?newlot"><strong>Выставить на лот</strong></a>
									<a class="dropdown-item" href="'.way().'cabinet/index.php?nav=lots&activebets">Покупки и продажи</a>
									<a class="dropdown-item" href="'.way().'cabinet/index.php?nav=msg">Сообщения</a>
									<a class="dropdown-item" href="'.way().'cabinet/index.php?nav=settings&main">Настройки</a>
									<div class="dropdown-divider"></div>
									<input type="submit" class="dropdown-item" value="Выйти" name="logout">
								</form>
							</div>
						</div>
				    </div>
				    <!-- окончание меню -->
				</div>
			</div>
			<!-- конец приватного хидера -->';
		};
    ?>
</nav>

<!-- строка поиска, помощь и правила -->
<div class="container-fluid font-weight-bold p-2 my-3 " id="search">
    		<form>
    			<div class="form-row">
    					<div class="col-7">
    						<input type="text" class="form-control" placeholder=" Поиск" id="inputSearch" name="inputSearch">
    					</div>
    					<div class="col-2">
    						<select class="form-control" id="selectCategory">
    							<option value="0">Все категории</option>
    							<?php 
    							while ($cat = mysqli_fetch_assoc($query))
    							{ 
									echo '<option value="'. $cat['id_category'] .'">'. $cat['category'] .'</option>';
								}
    							?>
							</select>
    					</div>
    					<div class="col">
    						<button class="btn btn-outline-light" id="goSearch" type="button"><img src=<?php echo '"'.wayDir(); ?>img/search.png" width="20" height="20" style="vertical-align: middle; "></button>
    					</div>
						<a href=<?= '"'.way().'help"' ?> class="col">Помощь</a>
						<a href=<?= '"'.way().'rules"' ?> class="col">Правила</a>
    				</div>	
    		</form>
    	</div>

<!-- модальное окно регистрации -->
<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 0;">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalTitle">Регистрация</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formRegistration">
			<div class="form-group pb-3">
		    	<label class="pl-1">Логин:</label>
		    	<input type="text" class="form-control" name="inputLogin" id="inputLogin">
		    	<small class="form-text text-muted pl-1">Логин должен быть уникальным, без спецсимволов и пробелов, можно нижнее подчеркивание и тире, должен содержать от 3 до 20 символов</small>
			</div>
			<div class="form-group pb-3">
		    	<label class="pl-1">Пароль:</label>
		    	<input type="password" class="form-control" name="inputPassword" id="inputPassword">
		    	<small class="form-text text-muted pl-1">Пароль должен содержать от 6 до 30 символов, только латинские буквы в любом регистре и цифры</small>
			</div>
			<div class="form-group pb-3">
		    	<label class="pl-1">Повторите пароль:</label>
		    	<input type="password" class="form-control" name="inputRepeatPassword" id="inputRepeatPassword">
			</div>
			<div class="form-group pb-3">
		    	<label class="pl-1">E-mail:</label>
		    	<input type="email" class="form-control" name="inputEmail" id="inputEmail">
		    	<small class="form-text text-muted pl-1">Введите правильный адрес электронной почты</small>
			</div>
			<div class="form-check">
		    	<input type="checkbox" class="form-check-input" name="rulesAgree" id="rulesAgree">
		    	<label class="form-check-label">Я соглашаюсь с <a href=<?php echo '"'.way().'/rules"' ?> target="_blank">правилами</a></label>
			</div>
			<div id="regInfo" class="mt-3">
				<ul>
					<li id="infoLogin"></li>
					<li id="infoPassword"></li>
					<li id="infoRepeatPassword"></li>
					<li id="infoEmail"></li>
					<li id="infoCheck"></li>
				</ul>

			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary dontborderradius" data-dismiss="modal" id="closeModal">Закрыть</button>
        <input type="button" class="btn btn-success dontborderradius" value="Зарегистрироваться" id="ConfirmRegistration">
        </form>
      </div>
    </div>
  </div>
</div>