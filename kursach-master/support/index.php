<?php
	include_once '../_logout.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Тех. Поддержка</title>
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
    	<h3>Тех. поддержки и решение вопросов</h3>
		<hr class="line line-exposed">

		<div class="row">
			<div class="col-md-3">
				<div class="list-group list-group-question">
					<?php 
						if($_COOKIE['login'] == 'admin'){
							echo '<div class="list-group-item list-group-item-action dontborderradius" id="myQuestion">Все вопросы</div>
							<script>$("#myQuestion").css({"background": "#17a2b8", "color": "white"});</script>';
						}else{
							echo '<div class="list-group-item list-group-item-action dontborderradius" id="startQuestion" style="background: #17a2b8; color: white;">Задать вопрос</div>
							<div class="list-group-item list-group-item-action dontborderradius" id="myQuestion">Мои вопросы</div>';
						}
					?>
				</div>
			</div>

			<div class="col-md-9 content_startQuestion <?php if($_COOKIE['login'] == 'admin') echo 'hide'; ?>">
				<h5>Задать вопрос в тех. поддержку</h5>
				<hr>

				<form enctype="multipart/form-data" id="formQuestion">
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Тема</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="question_head" name="question_head">
						</div>
						<div class="col-md-4 pt-1" id="errorQuestion_head"></div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Приоритет</label>
						<div class="col-md-6">
							<select class="form-control" id="priority" name="priority">
								<option value="1">Низкий</option>
								<option value="2">Средний</option>
								<option value="3">Высокий</option>
							</select>	
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Вопрос</label>
						<div class="col-md-6">
							<textarea type="text" class="form-control" id="question" name="question" rows="5"></textarea>
						</div>
						<div class="col-md-4" id="errorQuestion"></div>
					</div>
					<!--<div class="form-group row">
						<label class="col-md-2 col-form-label">Файл</label>
						<div class="col-md-4">
							<input type="file" class="form-control border-0 pl-0" id="inputFile" name="inputFile">
						</div>
						<div class="col-md-4 offset-md-2" id="errorQuestionFile"></div>
					</div>-->
					<div class="form-group row">
						<input type="button" class="btn btn-success offset-md-2 col-md-2" value="Отправить" id="sendQuestion" name="sendQuestion">
					</div>
				</form>

				<div class="col-md-3 offset-md-3 mb-2" id="infoQuestion"></div>
			</div>

			<div class="col-md-9 content_myQuestion <?php if($_COOKIE['login'] != 'admin') echo 'hide';?>">
				<?php
					if($_COOKIE['auth'] == 'false' || !isset($_COOKIE['auth']))
					{
						echo '<hr><h5 style="color: red; font-weight: bold;">Авторизуйтесь, чтобы просмотреть свои вопросы</h5>';
					}else{
						/* определенный вопрос */
						if(isset($_GET['question']) && $_GET['question'] != 0)
						{
							$question = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM issues WHERE id ='". $_GET['question'] ."'"));

							echo '<script>$(".content_startQuestion").hide();
							$("#startQuestion").css({"background": "none", "color": "black"});
							$(".content_myQuestion").show();
							$("#myQuestion").css({"background": "#17a2b8", "color": "white"});</script>

							<div class="row">
								<div class="col-md-12 h5">Вопрос #'. $question["id"] .' на тему: <strong>'. $question["title"] .'</strong></div>
							</div>
							<div>Приоритет данного вопроса: '; 
							switch ($question['priority']) {
								case 1:
									echo '<span class="text-success">Низкий.</span>';
									break;
								case 2:
									echo '<span class="text-warning">Средний.</span>';
									break;
								case 3:
									echo '<span class="text-danger">Высокий.</span>';
									break;
							}
							echo '<span class="ml-4">Отправлен '. date_format(date_create($question["date_submit"]), 'd.m.Y') .' в '. date_format(date_create($question["date_submit"]), 'H:i') .'</span></div>
							<div class="font-weight-bold mt-3">Вопрос:</div>
							<div class="mb-5"><textarea disabled style="width: 80%;">'. $question['question'] .'</textarea></div>';
							/* если ответ пустой */
							if($question['reply'] == ''){

								/* если мы админ, то даем ответ */
								if($_COOKIE['login'] == 'admin'){
									echo '<div class="font-weight-bold">Ответ:</div>
									<form method="post">
										<div><textarea style="width: 80%;" name="inputReply"></textarea></div>
										<input type="submit" class="btn btn-success" value="Дать ответ" name="submitReply" id="submitReply">
									</form>';

									if(isset($_POST['submitReply'])){
										mysqli_query($link, "UPDATE issues SET reply = '". $_POST['inputReply'] ."', date_reply = '" .date('d.m.Y H:i'). "' WHERE id = ". $question['id'] ."");
									}
									/* иначе просто смотрим */
								}else{
									echo '<div class="font-weight-bold">Ответ:</div>
									<div><textarea disabled style="width: 80%;">Нет ответа</textarea></div>';
								}
								/* если ответ не пустой */
							}else{
								echo '<div class="font-weight-bold">Ответ дан '. date_format(date_create($question["date_reply"]), 'd.m.Y') .' в '. date_format(date_create($question["date_reply"]), 'H:i') .':</div>
								<div><textarea disabled style="width: 80%;">'. $question['reply'] .'</textarea></div>';
							}
							echo '<div class="my-2"><a href="'.way().'support/" style="font-weight: bold;"><--назад</a></div>';
						}else{


							/* вывод моих вопросов */
							if($_COOKIE['login'] == 'admin'){
								echo '<h5>Вопросы</h5>';
							}else{
								echo '<h5>Мои вопросы</h5>';
							}
							echo '<table class="table table-question">
								<thead>
									<tr style="cursor: default!important">';
										if($_COOKIE['login'] == 'admin') echo '<td class="p-1 bg-light">Пользователь</td>';
										echo '<td class="p-1 bg-light">Тема вопроса</td>
										<td class="p-1 bg-light">Приоритет</td>
										<td class="p-1 bg-light">Дата отправки</td>
										<td class="p-1 bg-light">Ответ</td>
									</tr>
								</thead>
								<tbody>';

							/* вывод вопросов конкретного пользователя и всех для администратора*/
							if($_COOKIE['login'] == 'admin'){
								$query_issues = mysqli_query($link, "SELECT * FROM issues ORDER BY priority DESC");
							}else{
								$user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login LIKE '". $_COOKIE['login'] ."'"));
								$query_issues = mysqli_query($link, "SELECT * FROM issues WHERE id_user = '". $user['id_users'] ."' ORDER BY priority ASC");
							}
							while ($issues = mysqli_fetch_array($query_issues))
							{
								echo '<tr id="'. $issues["id"] .'">';
									if($_COOKIE['login'] == 'admin'){
										$user_question = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = ". $issues['id_user']));
										echo '<td class="p-1">'. $user_question["login"] .'</td>';
									}
									echo '<td class="p-1">'.$issues['title'].'</td>'; 
									switch ($issues['priority']) {
										case 1:
											echo '<td class="p-1 text-success">Низкий';
											break;
										case 2:
											echo '<td class="p-1 text-warning">Средний';
											break;
										case 3:
											echo '<td class="p-1 text-danger">Высокий';
											break;
									}
									echo '</td>
									<td class="p-1">'.$issues['date_submit'].'</td>';
									if($issues['reply'] == ''){
										echo '<td class="p-1">Ответ не дан</td>';
									}else{
										echo '<td class="p-1">Ответ дан</td>';
									}
								echo '</tr>';
							}
							echo '</tbody>
							</table>';
						}
					}
				?>
			</div>
		</div>
	</div>

    <!-- подвал -->
    <!-- ================================================================================================= -->
    <?php include_once '../footer.php'; 

    ?>    
	</div>
<script>
	document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')
</script>	
</body>
</html>