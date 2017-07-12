<?php
	session_start();
	if($_SESSION['ID']){
		$_SESSION['ID']=0;
		header("Location: index.php");
	}
?>