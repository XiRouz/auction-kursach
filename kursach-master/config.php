<?php 
	$host='localhost';
    $user='root';
    $pass='1234'; 
    $db_name='kursach';
		
    $link=mysqli_connect($host,$user,$pass);
    mysqli_select_db($link,$db_name);
    	
    function way()
	{
		$dir = explode('/', $_SERVER['PHP_SELF'], -1);

		if($dir[2] == ''){
			return '/';
		}else{
			return '/'.$dir[2].'/';
		}		
	};

	function wayDir()
	{
		$explode = explode('/', $_SERVER['PHP_SELF'], -1);

		if($explode[1] != ''){

			return '../';
		}else{
			return '';
		}
	};
?>