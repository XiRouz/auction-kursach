<?php 
	include_once '../_logout.php';
	include_once '../config.php';

	if(!isset($_GET['id']) || $_GET['id'] == 0){ $isset_id = false; }else{ $isset_id = true; }
	if(!isset($_GET['search']) || !isset($_GET['category'])){ $isset_search = false; }else{ $isset_search = true; }
	if($isset_id && $isset_search){ print '<script type="text/javascript"> window.location.href = "../index.php" </script>'; }

	/* запросы бд при просмотре лота */
	if($isset_id && !$isset_search){
		$lot = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM lot WHERE id_lot = ".$_GET['id']));
		$cat_subcat = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM subcategory, category WHERE id_subcategory = ".$lot['id_subcategory']));
		$cat = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM category WHERE id_category = (SELECT id_category FROM subcategory WHERE id_subcategory = ". $lot['id_subcategory'] .")"));
		$users = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = ".$lot['id_users']));
		$bets = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM bets WHERE id_lot = " .$lot['id_lot']. " ORDER BY id_bets DESC LIMIT 1"));
		$query_all_bets = mysqli_query($link, "SELECT * FROM bets WHERE id_lot = " .$lot['id_lot']);
		$query_all_comments = mysqli_query($link, "SELECT * FROM comments WHERE id_lot = " .$lot['id_lot']);

		$date_start = date_format(date_create($lot['date_start']), 'd.m.Y');
		$time_start = date_format(date_create($lot['date_start']), 'H:i');
		$date_end = date_format(date_create($lot['date_end']), 'd.m.Y');
		$time_end = date_format(date_create($lot['date_end']), 'H:i');

		$count_lot = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(id_lot) FROM lot WHERE id_users = '" .$lot['id_users']. "'"));
		$count_bets = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(id_bets) FROM bets WHERE id_lot = " .$lot['id_lot']));
		$count_comments = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(id_comments) FROM comments WHERE id_lot = " .$lot['id_lot']));
	}

	/* запросы бд при поиске */
	if(!$isset_id && $isset_search)
	{
		if(isset($_GET['subcat']))
		{
			$query_lot = mysqli_query($link, "SELECT * FROM lot WHERE id_subcategory ='" .$_GET['subcat']. "' AND lot_name LIKE '%" .$_GET['search']. "%' ORDER BY id_lot DESC");
		}else{
			if($_GET['category'] != 0)
			{
				$query_lot = mysqli_query($link, "SELECT * FROM lot WHERE id_subcategory IN (SELECT id_subcategory FROM subcategory WHERE id_category = ". $_GET['category'] .") AND lot_name LIKE '%" .$_GET['search']. "%' ORDER BY id_lot DESC");
			}else{
				if(isset($_GET['user']) && $_GET['user'] != 0)
				{
					$query_lot = mysqli_query($link, "SELECT * FROM lot WHERE lot_name LIKE '%" .$_GET['search']. "%' AND id_users = ".$_GET['user']." ORDER BY id_lot DESC");
				}else{
					$query_lot = mysqli_query($link, "SELECT * FROM lot WHERE lot_name LIKE '%" .$_GET['search']. "%' ORDER BY id_lot DESC");
				}
			}
		}
		$category_search = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM category WHERE id_category = " .$_GET['category']));

		if(isset($_GET['subcat'])) $subcat = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM subcategory WHERE id_subcategory = " .$_GET['subcat']));
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<?php 
		if(isset($_GET['search'])){
			if($category_search['category'] != ''){
				echo '<title>' .$category_search['category']. '</title>';
			}else{
				echo '<title>Все категории</title>';
			}
		}else{
			echo '<title>' .$lot['lot_name']. '</title>';
		}
	?>
	<link rel="shortcut icon" href="../img/favicon.jpg" type="image/png">
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
	    
	    <div id="lot-mainblock" class="pb-5">
    	<?php 
		
		/*
		* просмотр лота
		*/
		if($isset_id && !$isset_search){
			echo   '<div class="row mx-1">
    				<div class="leftblock col-md-4 p-0 border">
			    		<img src="'.wayDir().'img/img-lot/id-' .$lot["id_lot"]. '.jpg" class="img-fluid p-4" style="width: 100%;">
			    	</div>
			    	<div class="rightblock col-md-8">
			    		<strong class="h3 ml-2">' .$lot['lot_name']. '</strong>
			    		<hr class="line line-exposed mb-0 mt-2">
			    		<p class="small ml-2">' .$cat['category']. ' / ' .$cat_subcat['subcategory']. '</p>
			    		<div class="lot-description p-2">
			    			<div class="lot-desc-header d-flex border-bottom">
								<div class="font-weight-bold">Описание лота №' .$lot['id_lot']. '</div>
								<div class="ml-auto small text-info">Дата выставления: ' .$date_start. ' в ' .$time_start. '  /  Дата окончания торгов: ' .$date_end. ' в ' .$time_end. '</div>
			    			</div>
			    			<div>' .$lot['decription']. '</div>
			    		</div>

			    		<div class="characteristics p-2 pt-5">
							<div><strong>Местонахождение:</strong> ' .$lot['location']. '</div>
							<div class="py-2"><strong>Доставка:</strong> ' .$lot['delivery']. '								
			    		</div>

			    		<div class="user pt-5">
			    			<div>
			    				<strong>Выставил лот:</strong> <a href="'. way() .'profile/?id='. $users["id_users"] .'">' .$users['login']. '</a><span class="ifyou"></span>
			    			</div>  
							<div class="ml-2 small">
								Зарегистрирован: ' .$users['date_registration']. '
							</div> 
							<div class="ml-2 small">
								Последнее посещение: ' .$users['last_enter']. '
							</div> 
							<div class="ml-2">
								<a href="../lot/index.php?search=&category=0&user='. $users["id_users"] .'">Все лоты продавца [' .$count_lot[0]. ']</a>
							</div>
							<div class="ml-2">
								<a href="'. way() .'cabinet/index.php?nav=msg&id='. $users['id_users'] .'">Написать сообщение <img src="' .wayDir(). 'img/message.png" width="15" height="15" style="padding-bottom: 1px;"></a>
							</div>
			    		</div>

			    		<!-- форма ставки -->
			    		<form class="mt-5 mx-1" id="formBet">
							<div class="row mt-2">
								<div class="col-md-6 hide-bet-form" style="margin-top: 4px;">';

									if($count_bets[0] != 0){
										echo '<span class="h4 font-weight-bold">Последняя ставка: ' .$bets['bet'];
										$prb = 1;
									}else{
										echo '<span class="h4 font-weight-bold">Начальная цена: ' .$lot['start_price'];
										$prb = 0;
									}												

								echo '</span><img src="' .wayDir(). 'img/rub.png" width="18" height="18" class="ml-1 mb-2">
								</div>
								<div class="col-lg-3 mb-2 hide-bet-form">
									<input type="text" class="form-control" id="inputBet" name="inputBet" placeholder="Укажите цену">
									<input type="hidden" name="id_lotH" value="' .$lot["id_lot"]. '">
									<input type="hidden" name="start_priceH" value="' .$lot["start_price"]. '">
									<input type="hidden" name="last_betH" value="' .$bets["bet"]. '">
									<input type="hidden" name="priceH" value="' .$lot['price']. '">
									<input type="hidden" name="priceOrBet" id="priceOrBet" value="' .$prb. '">
								</div>
								<div class="col-lg-3 hide-bet-form">
									<input type="button" class="btn btn-success" value="Сделать ставку" id="placeBet" name="placeBet">
								</div>
							</div>
							<div class="row mt-2 hide-buy-form">
								<div class="col-lg-6">
									<span class="h4 font-weight-bold">Цена выкупа: ' .$lot['price']. '</span><img src="' .wayDir(). 'img/rub.png" width="18" height="18" class="ml-1 mb-2">
								</div>
								<div class="col-lg-3 offset-lg-3">
									<input type="button" class="btn btn-success" value="Выкупить лот" id="buyLot" name="buyLot" style="padding-right: 18px; padding-left: 18px;">
								</div>
							</div>';

							/* если нету цены выкупа, скрываем ее */
							if($lot['price'] == 0 || $lot['price'] == ''){
								echo '<script>$(".hide-buy-form").addClass("hide");</script>';
							}

					        /* если нет ставки, скрываем ее */
					        if($lot['start_price'] == 0 || $lot['start_price'] == ''){
					        	echo '<script>$(".hide-bet-form").addClass("hide");</script>';
					        }

					        /* если лот наш, то нельзя купить-поставить */
					        if($users['login'] == $_COOKIE['login']){
					        	echo '<script>$("#inputBet").addClass("hide"); $("#placeBet").addClass("hide"); $("#buyLot").addClass("hide"); $(".ifyou").html("(Вы)");</script>';
					        }

					        /* если лот выкупили, то пишем */
					        if($bets['bet'] == 'buy'){
					        	echo '<script>$(".hide-bet-form, .hide-buy-form").addClass("hide"); $("#formBet").css({"background":"#FF9090"});</script>'; 

					        	$buy_login = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = " .$bets['id_user']));
					        	echo 'Данный лот был куплен пользователем <strong>' .$buy_login["login"].'</strong> по цене <strong>' .$lot["price"]. '</strong><img src="' .wayDir(). 'img/rub.png" width="13" height="13" class="mb-1"> в <strong>'. $bets['date_bet']. '</strong>';
					        }else{
					        	/* если у лота истекла дата торгов */		
						        if(date('Y-m-d') >= date_format(date_create($date_end), 'Y-m-d'))
						        {
						        	if(date('Y-m-d') == date_format(date_create($date_end), 'Y-m-d'))
									{
										if(date('H:i') > date_format(date_create($time_end), 'H:i'))
										{
											echo '<script>$(".hide-bet-form, .hide-buy-form").addClass("hide"); $("#formBet").css({"background":"#FF9090"});</script>'; 
								        	if($bets['bet'] != '')
								        	{
								        		$user_win_name = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users =". $bets['id_user']));
								        		echo 'Торги на данный лот были окончены <strong>'. $date_end .'</strong> в <strong>'. $time_end .'</strong>, а победителем стал <strong><a href="javascript:void(0)">'. $user_win_name['login'] .'</a></strong>';
								        	}else{
								        		echo 'Торги на данный лот были окончены <strong>'. $date_end .'</strong> в <strong>'. $time_end .'</strong>';
								        	}
										}
									}
						        }
					        }




					  echo '<div id="betInfo" class="d-flex justify-content-center font-weight-bold h3"></div>
						</form>
			    	</div>
			    </div>
			    <div class="comments-bets container-fluid mt-5"> 
				    <div class="nav nav-tabs">
			    		<a id="nav-bets" class="nav item nav-link active" href="javascript:void(0)">Ставки(' .$count_bets[0]. ')</a>
			    		<a id="nav-comments" class="nav item nav-link" href="javascript:void(0)">Комментарии(' .$count_comments[0]. ')</a>	
			    	</div>
		    		<div class="bets-content border-bottom border-left border-right p-2">';

		    		if($count_bets[0] != 0){
		    			echo '<table class="table mt-3" style="width: 800px;">
		    			  <thead>
		    				<tr>
							  <td scope="col" style="border: 0px !important; padding-bottom: 3px;">Никнейм</td>
							  <td scope="col" style="border: 0px !important; padding-bottom: 3px;">Ставка</td>
							  <td scope="col" style="border: 0px !important; padding-bottom: 3px;">Время</td>
		    				</tr>
		    			  </thead>';

		    				while ($all_bets = mysqli_fetch_array($query_all_bets)) {
		    					$login_bet = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = " .$all_bets['id_user']));

		    					/* вывод если лот купили */
		    					if($all_bets["bet"] == 'buy'){
		    						$show_bet = 'Выкуплен';
		    					}else{
		    						$show_bet = $all_bets["bet"]. '<img src="' .wayDir(). 'img/rub.png" width="13" height="13" class="mb-1">';
		    					}

		    					echo '<tr>
		    					        <td>' .$login_bet['login']. '</td>
		    					        <td><strong>' .$show_bet. ' </strong></td>
		    					        <td>' .$all_bets["date_bet"]. '</td>
		    					      </tr>';
		    				}

		          echo '</table>';
		    		}else{
		    			echo '<p class="h5 font-weight-bold m-3">На этот лот еще не кто не поставил</p>';
		    		}
		      echo '</div>
		      		<div class="comment-content border-bottom border-left border-right p-2 hide">';

		      		/* комментарии */
		      		if($count_comments[0] != 0){
		      			while ($all_comments = mysqli_fetch_array($query_all_comments)) {
		    					$login_comments = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = " .$all_comments['id_users']));
		    					$last_comment = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM comments WHERE id_lot = " .$lot['id_lot']. " ORDER BY id_comments DESC LIMIT 1"));

				      			if($last_comment['id_comments'] != $all_comments['id_comments']){
				      				echo '<div class="comment p-3 mb-2 border-bottom">
										<div class="comment-header"><strong>' .$login_comments["login"]. '</strong> оставил комментарий в <small class="text-info">' .$all_comments["date_dispatch"]. '</small></div>
										<div class="comment-comment">' .$all_comments['comment']. '</div>
				      				  </div>';
				      			}else{
				      				echo '<div class="comment p-3 mb-2">
										<div class="comment-header"><strong>' .$login_comments["login"]. '</strong> оставил комментарий в <small class="text-info">' .$all_comments["date_dispatch"]. '</small></div>
										<div class="comment-comment">' .$all_comments['comment']. '</div>
				      				  </div>';
				      			}
		    			}
		    		}else{
		    			echo '<p class="h5 font-weight-bold m-3">У данного лота отсутствуют комментарии</p>';
		    		}

		    		/* можно оставить комментарий, если авторизованы */
		    		if($users['login'] == $_COOKIE['login']){}else{
		    			echo '<form class="mt-5 mx-3 mb-3" id="formComment">
								<div class="form-group">
									<label class="ml-2">Оставьте свой комментарий:</label>
									<textarea class="form-control" rows="4" name="inputComment" id="inputComment" placeholder="Комментарий..."></textarea>
									<input type="hidden" name="id_lotCom" value="' .$lot["id_lot"]. '">
								</div>
									<input type="button" class="btn btn-primary" value="Отправить" name="addComment" id="addComment">	
									<div id="infoComment" class="h4 font-weight-bold mt-3"></div>
							  </form>';
		    		}

		      echo '</div>
	      	    </div>';
		}






		/* 
		* поиск
		*/
		if(!$isset_id && $isset_search){
			
	  echo '<div class="row mx-1">
		  		<!-- левый блок -->
				<div class="col-md-2 pt-2" id="leftblock">';
		    		include_once wayDir(). '_category.php';
		  echo '</div>

			    <!-- правый блок -->
			    <div class="col-md-10" id="rightblock">
			    	<div class="h4">';

			    	if($category_search["category"] != ''){
			    		echo $category_search["category"];
			    	}else{
			    		if($_GET['user'])
			    		{
			    			$username = mysqli_fetch_array(mysqli_query($link, "SELECT login FROM users WHERE id_users = ". $_GET['user']));
			    			echo 'Все лоты пользователя: <a href="javascript:void(0)">'. $username[0] .'</a>';
			    		}
			    	}

					if(isset($_GET['subcat']) && $_GET['subcat'] != 0){
						echo ' / ' .$subcat['subcategory'];
					}

			  echo '<span class="font-weight-bold count-lot"></span></div>
					<hr class="line mt-0">';

					/* цикл с перебором лотов в поиске */
					$count_lot = 0;
			    	while($lot = mysqli_fetch_array($query_lot)){
			    		$count_lot++;
			    		$users = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = ".$lot['id_users']));
			    		$count_bets = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(id_bets) FROM bets WHERE id_lot = " .$lot['id_lot']));
			    		$bets = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM bets WHERE id_lot = " .$lot['id_lot']. " ORDER BY id_bets DESC LIMIT 1"));
			    		$date_end = date_format(date_create($lot['date_end']), 'Y-m-d');
						$time_end = date_format(date_create($lot['date_end']), 'H:i');
			      echo '<div class="lot-search border-bottom mb-3 pb-5">
							<div class="d-flex flex-row">
								<div class="col pt-1">
									<a href=' .way(). 'lot/index.php?id=' .$lot['id_lot']. '><img src="'.wayDir().'img/img-lot/id-' .$lot["id_lot"]. '.jpg" width="120" height="120"></a>
								</div>
								<div class="col-11 row">
									<div class="col-lg-8">
										<div class="h5 font-weight-bold m-0">' .$lot["lot_name"]. '</div>
										<div class="small">' .$lot["location"]. '</div>
										<div class="mt-4"><a href="'. way() .'profile/?id='. $users["id_users"] .'">' .$users["login"]. '</a></div>
									</div>
									<div class="col-lg-4 info-lot-search-'. $lot["id_lot"] .'">';

										/* информация о выкупе лота, окончании ставок, начальной цене и цене выкупа */
										if($count_bets[0] != 0){
											echo '<div class="font-weight-bold" style="color: gray;">';
											
											if($bets['bet'] == 'buy')
											{
												echo '<span style="color:red;">Куплен по цене: ' .$lot["price"]. '</span><img src="' .wayDir(). 'img/rub.png" width="13" height="13" class="mb-1">';
												$buy = true;
											}else{
												echo 'Последняя ставка: '. $bets['bet'] .'<img src="' .wayDir(). 'img/rub.png" width="13" height="13" class="mb-1">';
												$buy = false;
											}
											echo '</div>';
										}else{
											if($lot['start_price'] != ''){
												echo '<div class="font-weight-bold" style="color: gray;">Начальная цена: ' .$lot['start_price']. '<img src="' .wayDir(). 'img/rub.png" width="13" height="13" class="mb-1"></div>';
											}
										}

										/* если лот не куплен то вывод цены выкупа */
								  		if($buy != true)
								  		{
								  			if($lot['price'] != '')
								  			{
								  				echo '<div class="font-weight-bold" style="color: gray;">Цена выкупа: ' .$lot['price']. '<img src="' .wayDir(). 'img/rub.png" width="13" height="13" class="mb-1"></div>';
								  			}
								  		}

								  		/* если дата окончания */
								  		if(date('Y-m-d') >= date_format(date_create($date_end), 'Y-m-d') && $bets['bet'] != 'buy')
								        {
								        	if(date('Y-m-d') == date_format(date_create($date_end), 'Y-m-d'))
											{
												if(date('H:i') > date_format(date_create($time_end), 'H:i'))
												{
													echo '<script>$(".info-lot-search-'. $lot["id_lot"] .'").html("Торги окончены").css({"font-weight":"bold", "color":"red"});</script>';
												}
											}
										}
								  		

							   echo '</div>
								</div>
							</div>
								
			    		</div>';
			    	}
			    	echo '<script>$(".count-lot").html(" (' .$count_lot. ')")</script>';
		  echo '</div>
			</div>';
		}
		    


    	?>
		</div>
	    <?php include_once '../footer.php'; ?>
	</div>
<script>
	document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')
</script>
</body>
</html>