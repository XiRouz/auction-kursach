<div class="container-fluid">
	<div class="row">
		<div class="col-md-2 p-0">

			<h5 class="mt-3 ml-2">Покупки</h5>	
			<div class="list-group list-group-bets">
				<a href="index.php?nav=lots&activebets" class="list-group-item list-group-item-action dontborderradius" id="activebets">Активные ставки</a>
				<a href="index.php?nav=lots&winbets" class="list-group-item list-group-item-action" id="winbets">Выигранные ставки</a>
				<a href="index.php?nav=lots&losebets" class="list-group-item list-group-item-action dontborderradius" id="losebets">Не выигранные ставки</a>
			</div>

			<h5 class="mt-3 ml-2">Продажи</h5>
			<div class="list-group list-group-lots">
				<a href="index.php?nav=lots&activelots" class="list-group-item list-group-item-action dontborderradius" id="activelots">Активные лоты</a>
				<a href="index.php?nav=lots&soldlots" class="list-group-item list-group-item-action" id="soldlots">Проданные лоты</a>
				<a href="index.php?nav=lots&unsoldlots" class="list-group-item list-group-item-action dontborderradius" id="unsoldlots">Непроданные лоты</a>
			</div>							
		</div>
		<div class="col-md-10 py-2">
			<?php 
				/* выделение айтемов в меню */
				if(isset($_GET['winbets'])) echo '<script>$(".list-group-bets #winbets").addClass("bg-info text-white");</script>';
				if(isset($_GET['losebets'])) echo '<script>$(".list-group-bets #losebets").addClass("bg-info text-white");</script>';
				if(isset($_GET['activebets'])) echo '<script>$(".list-group-bets #activebets").addClass("bg-info text-white");</script>';
				if(isset($_GET['activelots'])) echo '<script>$(".list-group-lots #activelots").addClass("bg-info text-white");</script>';
				if(isset($_GET['unsoldlots'])) echo '<script>$(".list-group-lots #unsoldlots").addClass("bg-info text-white");</script>';
				if(isset($_GET['soldlots'])) echo '<script>$(".list-group-lots #soldlots").addClass("bg-info text-white");</script>';



				/* выигранные ставки */
				if(isset($_GET['winbets']))
				{
					echo '<h2 class="mt-2">Выигранные ставки</h2>
							<div class="winbets_header row">
								<div class="col-md-6">Наименование лота</div>
								<div class="col-md-2">Выставил лот</div>
								<div class="col-md-2">Ставка</div>
								<div class="col-md-2">Дата ставки</div>
							</div>';

					$query_win_bets = mysqli_query($link, "SELECT * FROM bets WHERE id_user = (SELECT id_users FROM users WHERE login = '". $_COOKIE['login'] ."')");
					while ($win_bets = mysqli_fetch_array($query_win_bets)){
						$lot = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM lot WHERE id_lot = '". $win_bets['id_lot'] ."'"));
						$user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = '". $lot['id_users'] ."'"));
						if($win_bets['bet'] == 'buy'){
							echo '<div class="border p-1 winbet" id="'. $lot["id_lot"] .'">
								<div class="row">
									<div class="col-md-6 winbet_lotname" style="left: 10px" id="'. $lot["id_lot"] .'">
										'.$lot["lot_name"].'
									</div>
									<div class="col-md-2 winbet_user" id="' .$user["id_users"]. '">
										'. $user["login"] .'
									</div>
									<div class="col-md-2">
										Куплен
									</div>
									<div class="col-md-2">
										'.$win_bets['date_bet'].'
									</div>
								</div>
							</div>';
						}else{
							if(date('Y-m-d') >= date_format(date_create($lot['date_end']), 'Y-m-d')){
								if(date('Y-m-d') == date_format(date_create($lot['date_end']), 'Y-m-d')){
									if(date('H:i') > date_format(date_create($lot['date_end']), 'H:i')){
										echo '<div class="border p-1 winbet" id="'. $lot["id_lot"] .'">
											<div class="row">
												<div class="col-md-6 winbet_lotname" style="left: 10px" id="'. $lot["id_lot"] .'">
													'.$lot["lot_name"].'
												</div>
												<div class="col-md-2 winbet_user" id="' .$user["id_users"]. '">
													'. $user["login"] .'
												</div>
												<div class="col-md-2">
													'. $win_bets["bet"] .'
												</div>
												<div class="col-md-2">
													'.$win_bets['date_bet'].'
												</div>
											</div>
										</div>';
									}
								}else{
									echo '<div class="border p-1 winbet" id="'. $lot["id_lot"] .'">
										<div class="row">
											<div class="col-md-6 winbet_lotname" style="left: 10px" id="'. $lot["id_lot"] .'">
												'.$lot["lot_name"].'
											</div>
											<div class="col-md-2 winbet_user" id="' .$user["id_users"]. '">
												'. $user["login"] .'
											</div>
											<div class="col-md-2">
												'. $win_bets["bet"] .'
											</div>
											<div class="col-md-2">
												'.$win_bets['date_bet'].'
											</div>
										</div>
									</div>';
								}
							}
						}
					}
				}



				/* не выигранные ставки */
				if(isset($_GET['losebets']))
				{
					echo '<h2 class="mt-2">Выигранные ставки</h2>
							<div class="winbets_header row">
								<div class="col-md-6">Наименование лота</div>
								<div class="col-md-2">Выставил лот</div>
								<div class="col-md-2">Ставка</div>
								<div class="col-md-2">Дата ставки</div>
							</div>';

					$query_lose_bets = mysqli_query($link, "SELECT * FROM bets WHERE id_user = (SELECT id_users FROM users WHERE login = '". $_COOKIE['login'] ."') AND bet <> 'buy'");
					while ($lose_bets = mysqli_fetch_array($query_lose_bets)){
						$lot = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM lot WHERE id_lot = '". $lose_bets['id_lot'] ."'"));
						$user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = '". $lot['id_users'] ."'"));
						if(date('Y-m-d') >= date_format(date_create($lot['date_end']), 'Y-m-d')){
							if(date('Y-m-d') == date_format(date_create($lot['date_end']), 'Y-m-d')){
								if(date('H:i') > date_format(date_create($lot['date_end']), 'H:i')){

									echo '<div class="border p-1 winbet" id="'. $lot["id_lot"] .'">
										<div class="row">
											<div class="col-md-6 winbet_lotname" style="left: 10px" id="'. $lot["id_lot"] .'">
												'.$lot["lot_name"].'
											</div>
											<div class="col-md-2 winbet_user" id="' .$user["id_users"]. '">
												'. $user["login"] .'
											</div>
											<div class="col-md-2">
												'. $lose_bets["bet"] .'
											</div>
											<div class="col-md-2">
												'.$lose_bets['date_bet'].'
											</div>
										</div>
									</div>';
								}
							}else{
								echo '<div class="border p-1 winbet" id="'. $lot["id_lot"] .'">
									<div class="row">
										<div class="col-md-6 winbet_lotname" style="left: 10px" id="'. $lot["id_lot"] .'">
											'.$lot["lot_name"].'
										</div>
										<div class="col-md-2 winbet_user" id="' .$user["id_users"]. '">
											'. $user["login"] .'
										</div>
										<div class="col-md-2">
											'. $lose_bets["bet"] .'
										</div>
										<div class="col-md-2">
											'.$lose_bets['date_bet'].'
										</div>
									</div>
								</div>';
							}
						}
					}
				}



				/* активные ставки */
				if(isset($_GET['activebets']))
				{
					echo '<h2 class="mt-2">Активные ставки</h2>
							<div class="activebets_header row">
								<div class="col-6">Наименование лота</div>
								<div class="col-2">Ставка</div>
								<div class="col-2">Дата ставки</div>
								<div class="col-2">Дата окончания</div>
							</div>';

					$query_active_bets = mysqli_query($link, "SELECT * FROM bets WHERE id_user = (SELECT id_users FROM users WHERE login = '" .$_COOKIE['login']. "') AND bet <> 'buy'");
					while ($active_bets = mysqli_fetch_array($query_active_bets))
					{
						$lot = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM lot WHERE id_lot = ". $active_bets['id_lot']));
						if(date('Y-m-d') <= date_format(date_create($lot['date_end']), 'Y-m-d'))
						{
							if(date('Y-m-d') == date_format(date_create($lot['date_end']), 'Y-m-d'))
							{
								if(date('H:i') < date_format(date_create($lot['date_end']), 'H:i'))
								{
									echo '<div class="border p-1 activebet" id="'. $lot["id_lot"] .'">
										<div class="row">
											<div class="col-md-6">
												'.$lot["lot_name"].'
											</div>
											<div class="col-md-2">
												'.$active_bets["bet"].'
											</div>
											<div class="col-md-2">
												'.$active_bets['date_bet'].'
											</div>
											<div class="col-md-2">
												'.$lot["date_end"].'
											</div>
										</div>
									</div>';
								}
							}else{
								echo '<div class="border p-1 activebet" id="'. $lot["id_lot"] .'">
									<div class="row">
										<div class="col-md-6">
											'.$lot["lot_name"].'
										</div>
										<div class="col-md-2">
											'.$active_bets["bet"].'
										</div>
										<div class="col-md-2">
											'.$active_bets['date_bet'].'
										</div>
										<div class="col-md-2">
											'.$lot["date_end"].'
										</div>
									</div>
								</div>';
							}

						}
						
					}
				}



				/* активные лоты */
				if(isset($_GET['activelots']))
				{
					echo '<h2 class="mt-2">Активные лоты</h2>
							<div class="activelots_header row">
								<div class="col-6">Наименование лота</div>
								<div class="col-3">Дата окончания</div>
								<div class="col-3">Кол-во ставок</div>
							</div>';
					$query_active_lots = mysqli_query($link, "SELECT * FROM lot WHERE id_users = (SELECT id_users FROM users WHERE login = '". $_COOKIE['login']. "')");
					while($active_lots = mysqli_fetch_array($query_active_lots))
					{
						$lastbet = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM bets WHERE id_lot = ". $active_lots['id_lot'] ." ORDER BY id_bets DESC"));
						if(date('Y-m-d') <= date_format(date_create($active_lots['date_end']), 'Y-m-d'))
						{
							$count_bets = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(id_bets) FROM bets WHERE id_lot = '".$active_lots["id_lot"]."'"));
							if(date('Y-m-d') == date_format(date_create($active_lots['date_end']), 'Y-m-d'))
							{
								if(date('H:i') < date_format(date_create($active_lots['date_end']), 'H:i'))
								{
									if($lastbet['bet'] != 'buy')
									{
										echo '<div class="border p-1 activelot" id="'. $active_lots["id_lot"] .'">
											<div class="row">
												<div class="col-md-6">
													'.$active_lots["lot_name"].'
												</div>
												<div class="col-md-3">
													'.$active_lots["date_end"].'
												</div>
												<div class="col-md-3">
													'.$count_bets[0].'
												</div>
											</div>
										</div>';
									}
								}
							}else{
								if($lastbet['bet'] != 'buy')
								{
									echo '<div class="border p-1 activelot" id="'. $active_lots["id_lot"] .'">
										<div class="row">
											<div class="col-md-6">
												'.$active_lots["lot_name"].'
											</div>
											<div class="col-md-3">
												'.$active_lots["date_end"].'
											</div>
											<div class="col-md-3">
												'.$count_bets[0].'
											</div>
										</div>
									</div>';
								}
							}
						}
						
					}
				}



				/* непроданные лоты */
				if(isset($_GET['unsoldlots']))
				{
					echo '<h2 class="mt-2">Непроданные лоты</h2>
							<div class="activelots_header row">
								<div class="col-9">Наименование лота</div>
								<div class="col-3">Дата окончания торгов</div>
							</div>';
					$query_unsold_lots = mysqli_query($link, "SELECT * FROM lot WHERE id_users = (SELECT id_users FROM users WHERE login = '". $_COOKIE["login"] ."')");
					while ($unsold_lots = mysqli_fetch_array($query_unsold_lots)) 
					{
						$count_bets_for_unsold_lots = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(id_bets) FROM bets WHERE id_lot = '".$unsold_lots["id_lot"]."'"));
						if($count_bets_for_unsold_lots[0] == 0)
						{
							if(date('Y-m-d') >= date_format(date_create($unsold_lots['date_end']), 'Y-m-d')) 
							{
								$username = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = (SELECT id_user FROM bets WHERE id_lot = ". $unsold_lots['id_lot'] ." ORDER BY id_bets DESC)"));
								if(date('Y-m-d') == date_format(date_create($unsold_lots['date_end']), 'Y-m-d'))
								{	
									if(date('H:i') > date_format(date_create($unsold_lots['date_end']), 'H:i'))
									{
										echo '<div class="border p-1 unsoldlot" id="'. $unsold_lots["id_lot"] .'">
											<div class="row">
												<div class="col-md-9" style="left: 10px" id="'. $unsold_lots["id_lot"] .'">
													'.$unsold_lots["lot_name"].'
												</div>
												<div class="col-md-3">
													'.$unsold_lots["date_end"].'
												</div>
											</div>
										</div>';
									}
								}else{
									echo '<div class="border p-1 unsoldlot" id="'. $unsold_lots["id_lot"] .'">
										<div class="row">
											<div class="col-md-9" style="left: 10px" id="'. $unsold_lots["id_lot"] .'">
												'.$unsold_lots["lot_name"].'
											</div>
											<div class="col-md-3">
												'.$unsold_lots["date_end"].'
											</div>
										</div>
									</div>';
								}
							}
						}
					}
				}



				/* проданные лоты */
				if(isset($_GET['soldlots']))
				{
					echo '<h2 class="mt-2">Проданные лоты</h2>
							<div class="activelots_header row">
								<div class="col-6">Наименование лота</div>
								<div class="col-3">Дата окончания</div>
								<div class="col-3">Победитель</div>
							</div>';
					$query_sold_lots = mysqli_query($link, "SELECT * FROM lot WHERE id_users = (SELECT id_users FROM users WHERE login = '". $_COOKIE["login"] ."')");
					
					while ($sold_lots = mysqli_fetch_array($query_sold_lots)) 
					{
						$count_bets_for_sold_lots = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(id_bets) FROM bets WHERE id_lot = '".$sold_lots["id_lot"]."'"));
						if($count_bets_for_sold_lots[0] != 0)
						{
							
							$lastbet = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM bets WHERE id_lot = ". $sold_lots['id_lot'] ." ORDER BY id_bets DESC"));
							
							
							if($lastbet['bet'] == 'buy' || date('Y-m-d') > date_format(date_create($sold_lots['date_end']), 'Y-m-d')) 
							{
								$username = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id_users = (SELECT id_user FROM bets WHERE id_lot = ". $sold_lots['id_lot'] ." AND bet = 'buy' ORDER BY id_bets DESC)"));
								echo '<div class="border p-1 soldlot">
									<div class="row">
										<div class="col-md-6 soldlot_name" style="left: 10px" id="'. $sold_lots["id_lot"] .'">
											'.$sold_lots["lot_name"].'
										</div>
										<div class="col-md-3">
											'.$sold_lots["date_end"].'
										</div>
										<div class="col-md-3 soldlot_user" style="right: 10px;" id="'. $username["id_users"] .'">
											'.$username['login'].'
										</div>
									</div>
								</div>';
							}
						}
					}
				}
			?>
		</div>
	</div>
</div>