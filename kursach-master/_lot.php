<?php 
	$query1 = mysqli_query($link, "SELECT * FROM lot ORDER BY id_lot DESC LIMIT 6");
    while ($lot = mysqli_fetch_array($query1)) {
    	if(mb_strlen($lot['lot_name'], 'utf8') > 12){
    		$substr_lot_name = mb_substr($lot['lot_name'], 0, 12, 'UTF-8') .'...';
    	}else{
    		$substr_lot_name = $lot['lot_name'];
    	}

    	echo '<div class="lot">
				<div>
					<a href=' .way(). 'lot/index.php?id=' .$lot['id_lot']. '><img src="'.wayDir().'img/img-lot/id-' .$lot["id_lot"]. '.jpg" width="120" height="120"></a>
				</div>
				<div>
					<a href=' .way(). 'lot/index.php?id=' .$lot['id_lot']. '>'.$substr_lot_name.'</a>
				</div>
				<div>';

				//если стартовой цены, то выводим цену покупки
				if(strlen($lot['start_price']) == 0){
					$show_price = $lot['price']. '<img src="'.wayDir().'img/rub.png" width="13" height="13" class="mb-1"></a>';
				}else{
					$bets = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM bets WHERE id_lot = " .$lot['id_lot']. " ORDER BY id_bets DESC LIMIT 1"));
					if(strlen($bets['bet']) != 0){
						if($bets['bet'] == 'buy'){
							$show_price = '<span style="color: red">куплен</span>';
						}else{
							$show_price = $bets['bet']. '<img src="'.wayDir().'img/rub.png" width="13" height="13" class="mb-1"></a>';
						}
					}else{
						$show_price = $lot['start_price']. '<img src="'.wayDir().'img/rub.png" width="13" height="13" class="mb-1"></a>';
					}					
				}

				$query2 = mysqli_query($link, "SELECT * FROM users WHERE id_users = ".$lot['id_users']." ORDER BY id_users DESC");
			    while ($users = mysqli_fetch_array($query2)) {
			    	echo '<strong>'.$show_price.'</strong>, <a href="'. way() .'profile/?id='. $users["id_users"] .'">'. $users["login"];
			    }

		echo '</a>
				</div>
			</div>';
    }	
?>
