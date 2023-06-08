<?php

include("classes/classautoloader.php");

	$login = new Login();
	$user_info = $login->log_check($_SESSION['studious_user_id']);
	

	if(isset($_SERVER['HTTP_REFERER'])){

		$return_to = $_SERVER['HTTP_REFERER'];
	}else{
		$return_to = "profile.php";
	}

	if(isset($_GET['type']) && isset($_GET['id'])){

		if(is_numeric($_GET['id'])){

			$allowed[] = 'post';
			$allowed[] = 'user';
			$allowed[] = 'comment';

			if(in_array($_GET['type'], $allowed)){

				$Publish = new Publish();
				$class_user = new User();
				
				$Publish->react_post($_GET['id'], $_GET['type'], $_SESSION['studious_user_id']);

				if($_GET['type'] == "user"){

					$class_user->follow_buddy($_GET['id'], $_GET['type'], $_SESSION['studious_user_id']);
				}
			}

		}
		
	}

header("Location: ". $return_to);
die;
