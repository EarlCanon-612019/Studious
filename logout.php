<?php

session_start();

if(isset($_SESSION['studious_user_id']))
{
	$_SESSION['studious_user_id'] = NULL;
	unset($_SESSION['studious_user_id']);

}

header("Location: login.php");
die;
