<div class="row pt-3">
	<div class="col-md-4 p-2 pl-4">
		<?php 
			if($_GET['nav'] == 'msg' && !isset($_GET['id']))
			{
				/*echo '<a href="index.php?nav=msg">Все</a> | 
					<a href="index.php?nav=msg&unread">Непрочитанные</a>';*/
			}else{
				if($_GET['nav'] == 'msg' && isset($_GET['id']))
				{
					$user_name = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = ".$_GET['id']));
					echo '<div>
						<- <a href="index.php?nav=msg" class="mr-4">Назад к диалогам</a>
						<span style="background: lightgray; padding: 5px; border-radius: 3px;">Диалог с: <a href="javascript:void(0)" class="font-weight-bold">'.$user_name['login'].'</a></span>
					</div>';	
				}
			}
		?>
	</div>
	<!-- поиск по пользователям -->
	<!--<div class="col-md-3 offset-md-5 search-user">
		<form class="form-inline" method="post">
			<div class="form-group mx-sm-2 mb-2">
				<input type="text" class="form-control" name="inputUserName" id="inputUserName" placeholder="Введите имя пользователя">
			</div>
			<button type="submit" class="btn btn-primary mb-2" name="search-msg">Найти</button>
		</form>
	</div>-->
</div>	
<?php 

	/* поиск */
	/*if(isset($_POST['search-msg']))
	{
		$search = mysqli_query("SELECT * FROM messages");
	}*/

	$self_id = mysqli_fetch_array(mysqli_query($link, "SELECT id_users FROM users WHERE login LIKE '".$_COOKIE['login']."'"));

	/* если просто msg, то просмотр сообщений */
	if($_GET['nav'] == 'msg' && !isset($_GET['id']))
	{
		/* получаем все дилоги со мной */
		$all_dialogs = mysqli_query($link, "SELECT * FROM messages WHERE to_id_users = ". $self_id[0] ." OR from_id_users = ". $self_id[0] ." GROUP BY from_id_users, to_id_users");

		/* проверяем и заносим в массив с диалогами*/
		while($dialogs = mysqli_fetch_array($all_dialogs))
		{
			$dialogs_array[] = $dialogs['from_id_users'];
			$dialogs_array[] = $dialogs['to_id_users'];
		}	

		/* убираем повторения и сортируем */
		$my_dialogs = array_unique($dialogs_array);
		sort($my_dialogs);
		

		/* выводим наши диалоги */
		foreach ($my_dialogs as $number_dialog) 
		{
			
			/* НЕ выводим диалог с самим собой */
			if($number_dialog != $self_id[0])
			{
				$dialog = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM messages WHERE from_id_users = ". $number_dialog ." AND to_id_users = ".$self_id[0]." OR from_id_users = ". $self_id[0] . " AND to_id_users = ". $number_dialog));
				$user_to = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = ".$dialog['to_id_users']));
				$user_from = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = ".$dialog['from_id_users']));
				$date = mysqli_fetch_row(mysqli_query($link, "SELECT date_dispatch FROM messages WHERE from_id_users = ". $number_dialog ." OR to_id_users = ". $number_dialog ." ORDER BY id DESC"));
				$query_lmsg = mysqli_query($link, "SELECT * FROM messages WHERE from_id_users = ". $self_id[0] ." OR to_id_users = ". $self_id[0] ." ORDER BY id DESC");	
				// echo '<pre>';
				// var_dump($dialog);
				// echo '</pre>';
				
				// echo '<pre>';
				// var_dump($user_from);
				// echo '</pre>';

				// echo '<pre>';
				// var_dump($user_to);
				// echo '</pre>';

				echo '<div class="dialogs">';
				/*  */
				while($lmsg = mysqli_fetch_array($query_lmsg))
				{
					/* если от кого - меня и кому - другому человеку*/
					if($lmsg['from_id_users'] == $self_id[0] && $lmsg['to_id_users'] == $number_dialog)
					{
						//echo $lmsg['message'];
						/* если от меня */
						$otmenya = true;
						break;
					}else{
						if($lmsg['from_id_users'] == $number_dialog && $lmsg['to_id_users'] == $self_id[0])
						{
							//echo $lmsg['message'];
							$otmenya = false;
							break;
						}
					}
				}
				if($user_to['id_users'] != $self_id[0])
				{
					echo '<div class="dialog border p-2" id="'. $number_dialog .'">
						<div class="row">
							<div class="col-md-2">
								<div class="d-flex">
									<div><img src="'.wayDir().'img/img-user/id-' .$user_to["image"]. '.jpg" width="50" height="50" class="avatar m-2"></div>
									<div>
										<div class="d-flex flex-column mt-2">
											<div><a href="javascript:void(0)">'. $user_to['login'] .'</a></div>
											<div><small style="color: gray; font-style: italic;">'.date_format(date_create($date[0]), 'd.m.Y').' в '.date_format(date_create($date[0]), 'H:i').'</small></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="border p-1 lastmsg">
									<div class="d-flex">
										<div><img src="'.wayDir().'img/img-user/id-'; 
										if($otmenya){ echo $user_from["image"]; }else{ echo $user_to['image']; }
										echo '.jpg" width="50" height="50" class="avatar m-2"></div>
										<div>'; 
										/* проверка от кого последние сообщение и вывод его */
										if($otmenya){ 
											$msgfrom = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM messages WHERE from_id_users = ". $self_id[0] ." AND to_id_users = ". $number_dialog ." ORDER BY id DESC"));
											echo $msgfrom['message'];
											/* если сообщшение не прочитано */
											//if($msgfrom['unread'] == 1) echo '<script>$("#'.$number_dialog.' .lastmsg").css({"background":"lightgray"})</script>';

										}else{ 
											$msgfrom = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM messages WHERE from_id_users = ". $number_dialog ." AND to_id_users = ". $self_id[0] ." ORDER BY id DESC"));
											echo $msgfrom['message'];
											/* если сообщшение не прочитано */
											//if($msgfrom['unread'] == 1) echo '<script>$("#'.$number_dialog.' .lastmsg").css({"background":"lightgray"})</script>';
										}
										echo '</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<form id="formSetReadMsg'.$number_dialog.'" class="hide">
						<input type="text" name="from" value="'.$self_id[0].'">
						<input type="text" name="to" value="'.$number_dialog.'">
					</form>';
				}else{
					echo '<div class="dialog border p-2" id="'. $number_dialog .'">
						<div class="row">
							<div class="col-md-2">
								<div class="d-flex">
									<div><img src="'.wayDir().'img/img-user/id-' .$user_from["image"]. '.jpg" width="50" height="50" class="avatar m-2"></div>
									<div>
										<div class="d-flex flex-column mt-2">
											<div><a href="javascript:void(0)">'. $user_from['login'] .'</a></div>
											<div><small style="color: gray; font-style: italic;">'.date_format(date_create($date[0]), 'd.m.Y').' в '.date_format(date_create($date[0]), 'H:i').'</small></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="border p-1 lastmsg">
									<div class="d-flex">
										<div><img src="'.wayDir().'img/img-user/id-';
										if($otmenya){ echo $user_to["image"]; }else{ echo $user_from['image']; }
										echo'.jpg" width="50" height="50" class="avatar m-2"></div>
										<div>';
										/* проверка от кого последние сообщение и вывод его */
										if($otmenya){ 
											$msgfrom = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM messages WHERE from_id_users = ". $self_id[0] ." AND to_id_users = ". $number_dialog ." ORDER BY id DESC"));
											echo $msgfrom['message'];
											/* если сообщшение не прочитано */
											//if($msgfrom['unread'] == 1) echo '<script>$("#'.$number_dialog.' .lastmsg").css({"background":"lightgray"})</script>';
										}else{ 
											$msgfrom = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM messages WHERE from_id_users = ". $number_dialog ." AND to_id_users = ". $self_id[0] ." ORDER BY id DESC"));
											echo $msgfrom['message'];
											/* если сообщшение не прочитано */
											//if($msgfrom['unread'] == 1) echo '<script>$("#'.$number_dialog.' .lastmsg").css({"background":"lightgray"})</script>';
										}
										echo '</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<form id="formSetReadMsg'.$number_dialog.'" class="hide">
						<input type="text" name="from" value="'.$self_id[0].'">
						<input type="text" name="to" value="'.$number_dialog.'">
					</form>';
				}
				echo '</div>';
			}
		}

		/* если нет диалогов */
		if(empty($dialogs_array)){ 
			echo '<script>$("#msg-content").html("Нет диалогов").css({"font-weight":"bold", "color":"red", "font-size":"25px"})</script>';
		}
	}else{
		/* 
		* иначе просмотр диалога с определенным пользователем 
		*/
		if($_GET['nav'] == 'msg' && isset($_GET['id']))
		{
			$messages = mysqli_query($link, "SELECT * FROM messages WHERE to_id_users = ". $self_id[0] ." OR from_id_users = ". $self_id[0] ." ORDER BY id ASC");
			while($message = mysqli_fetch_array($messages))
			{
				$user_to = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = ".$message['to_id_users']));
				$user_from = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = ".$message['from_id_users']));
				$date = mysqli_fetch_row(mysqli_query($link, "SELECT date_dispatch FROM messages WHERE id = ".$message['id']));

				echo '<div class="messages">';
				if($message['from_id_users'] != $self_id[0] && $message['from_id_users'] == $_GET['id'])
				{
					echo '<div class="border p-2">
						<div class="row">
							<div class="col-md-2">
								<div class="d-flex">
									<div><img src="'.wayDir().'img/img-user/id-' .$user_from['image']. '.jpg" width="50" height="50" class="avatar m-2"></div>
									<div>
										<div class="d-flex flex-column mt-2">
											<div><a href="javascript:void(0)">'. $user_from['login'] .'</a></div>
											<div><small style="color: gray; font-style: italic;">'.date_format(date_create($date[0]), 'd.m.Y').' в '.date_format(date_create($date[0]), 'H:i').'</small></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">'.$message['message'].'</div>
							<div class="col-md-2"></div>
						</div>
					</div>';
				}

				if($message['to_id_users'] != $self_id[0] && $message['to_id_users'] == $_GET['id'])
				{
					echo '<div class="border p-2">
						<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-8">'.$message['message'].'</div>
							<div class="col-md-2">
								<div class="d-flex">
									<div>
										<div class="d-flex flex-column mt-2">
											<div><a href="javascript:void(0)">'. $user_from['login'] .'</a></div>
											<div><small style="color: gray; font-style: italic;">'.date_format(date_create($date[0]), 'd.m.Y').' в '.date_format(date_create($date[0]), 'H:i').'</small></div>
										</div>
									</div>
									<div><img src="'.wayDir().'img/img-user/id-' .$user_from['image']. '.jpg" width="50" height="50" class="avatar m-2"></div>
								</div>
							</div>
						</div>
					</div>';
				}
				echo '</div>';
			}
			
			if($_GET['id'] != 1)
			{
				?>
				<div class="mt-5 mb-1 ml-1 font-weight-bold">Написать сообщение:</div>
				<form class="mb-4" id="formMessage">
					<div class="form-group">
						<textarea class="form-control" id="inputMessage" name="inputMessage" rows="3"></textarea>
						<input type="hidden" value=<?= '"'.$self_id[0].'"' ?> name="self_id">
						<input type="hidden" value=<?= '"'.$_GET['id'].'"' ?> name="to">
					</div>
					<button type="button" class="btn btn-primary" name="submitMessage" id="submitMessage">Отправить</button>
				</form>
				<div class="errorMessage font-weight-bold mb-3"></div>
				<?php	
			}

			 
		}
	}
?>			