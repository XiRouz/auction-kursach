<?php 
	$query = mysqli_query($link, "SELECT title, description, date_submit FROM news ORDER BY date_submit DESC");
    while ($row = mysqli_fetch_array($query)) {
    	switch(date("M", strtotime($row["date_submit"]))){
    		case 'Jan':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Января '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Feb':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Февраля '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Mar':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Марта '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Apr':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Апреля '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'May':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Мая '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Jun':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Июня '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Jul':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Июля '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Aug':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Августа '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Sep':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Сентября '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Oct':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Октября '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Nov':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Ноября '.date("Y", strtotime($row["date_submit"]));
    			break;
    		case 'Dec':
    			$date_submit = date("d", strtotime($row["date_submit"])).' Декабря '.date("Y", strtotime($row["date_submit"]));
    			break;

    	}
	    echo '<hr class="line-between-news">
	    <div class="news">
			<div>
				<a href="#"><strong>'.$row["title"].'</strong></a>,<span class="date_news"> '.$date_submit.'</span>
			</div>
			<div>
				<img src="'.wayDir().'img/news-icon.jpg" width="90" heigth="90" class="img_news">
				<p style="margin: 0;">'.$row["description"].'</p>
			</div>
		</div>';    
    }
?>
