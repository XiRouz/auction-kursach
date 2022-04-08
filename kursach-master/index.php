<?php
	include_once '_logout.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Онлайн аукцион</title>
	<link rel="shortcut icon" href="../img/favicon.jpg" type="image/png">
	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/style.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="/js/script.js"></script>
<body class="container-fluid">
	<!-- информация о регистрации -->
	<!-- <div id="regInfo" class="h3"></div> -->

	<div class="container">
	
	<!-- шапка -->
	<!-- ================================================================================================= -->
    <?php include_once 'header.php'; ?>
	
   	<!-- основной блок -->
   	<!-- ================================================================================================= -->
    <div class="mainblock">
    	<div class="row mx-1">
	    	<!-- левый блок -->
	    	<!-- ================================================================================================= -->
		    <div class="col-md-2 pt-2" id="leftblock">
		    	<!-- категории -->
		    	<?php  include_once '_category.php'; ?>
				<!-- <div class="h6 mt-5" style="min-height: 106px;">Популярные категории</div> -->
		    </div>
		    <!-- правый блок -->
		    <!-- ================================================================================================= -->
		    <div class="col-md-10 row" id="rightblock">
		    	<div class="col-md-12" id="exposed">
			    	<a href="javascript:void(0)" class="header-href"><h3>Недавние лоты</h3></a>
			    	<hr class="line line-exposed">	
			    	
			    	<!-- лот -->
			    	<?php include_once '_lot.php' ?>
			    	<!-- конец лота -->

		    	</div>
				<div class="col-md-6 mt-5" id="news">
					<a href="javascript:void(0)" class="header-href"><h3>Новости</h3></a>
					<hr class="line line-news">

					<!-- новость -->
					<?php include_once '_news.php'; ?>
					<!-- конец новости -->
				</div>
		    	<div class="col-md-6 mt-5" id="reviews">
		    		<a href="javascript:void(0)" class="header-href"><h3>Недавние отзывы</h3></a>
		    		<hr class="line line-reviews">
		    		
		    		<!-- отзыв -->
		    		<div class="comment">
		    			наименование товара, цена, продавец<br>
		    			отзыв, положительный или отрицательный
		    		</div>
		    		<!-- конец отзыва -->

		    	</div>
		    </div>
    	</div>
	</div>

    <!-- подвал -->
    <!-- ================================================================================================= -->
    <?php include_once 'footer.php'; 

    ?>    
	</div>
<script>
	document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')
</script>	
</body>
</html>