
<?php 	
		//開啟Session
		session_start();
		//清除Session
		//session_destroy();
		$_SESSION["login"] = NULL;
		$_SESSION["login_session"] = false;
		
		header("Location: apply.php");
		exit(); 
		

?>