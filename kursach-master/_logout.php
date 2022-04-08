<?php 
	if(isset($_POST['logout'])){	
		setcookie('auth', null, -1, '/');
		setcookie('login', null, -1, '/');
		print '<script> window.location.href="../index.php" </script>';
	};		
?>