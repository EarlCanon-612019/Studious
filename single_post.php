<?php
	
	include("classes/classautoloader.php");

	$login = new Login();
	$user_info = $login->log_check($_SESSION['studious_user_id']);

	$USER = $user_info;

	//white listing - avoid hackers from typing unwanted inputs on the url because we are telling the system to only accept very specific values
	if(isset($_GET['id']) && is_numeric($_GET['id'])){

		$profile = new Profile();
		$profile_info = $profile->retrieve_profile($_GET['id']);

		if(is_array($profile_info))
		{
			$user_info = $profile_info[0];			
		}

	}
	
	//for publishing content
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			
				$post = new Publish();
				$id_log = $_SESSION['studious_user_id'];
				$result = $post->publish_post($id_log, $_POST, $_FILES);

				if($result == "")
				{

					header("Location: single_post.php?id=$_GET[id]");
					die;
				}else
				{

					echo "<div style=' text-align: center; font-size: 12px; color: red; background-color: white; font-size: 14px; font-weight: bold; word-spacing: 5px; font-family: 'Roboto Slab'>";
					echo "<br>The Following errors occured<br>";
					echo $result;
					echo "</div>";
		    	}

			
				
	
		}

	$Publish = new Publish();
	$row = false;

	$ERROR = "";
	if(isset($_GET['id'])){	

		
		$row = $Publish->retrieve_single_post($_GET['id']);

		
	}else{

		$ERROR = "Unfortunately, no post was found.";
	}

?>

<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<style type="text/css">
			@import url('https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&family=Oleo+Script&family=Roboto+Slab:wght@300&display=swap');
			
			#profiletop_bar{
				height: 50px;
			    background: #022135;
			    font-family: 'Oleo Script';


			}

			#search_bar{
				width: 400px;
				height: 20px;
				border-radius: 5px;
				border: none;
				padding: 4px;
				font-size: 14px;
				background-image: url(search.png);
				background-repeat: no-repeat;
				background-position: right;
				background-size: 16px;

			}

			#profile_img {
				width: 150px;
				border-radius: 150px;
				border: solid 3px white;

			}
			#menu_btns{

				width: 100px;
				display: inline-block;
				margin: 2px;
			}

			#subjects{
				clear: both;

			}

			#subject_bar{
				
				//background: linear-gradient(to right, #ee9ca7, #ffdde1); 
				min-height: 400px;
				margin-top: 20px;
				color: black;
				padding: 8px;
				font-weight: bold;
				text-align: center;
				font-size: 20px;
				color: black;
				font-weight: bolder;

			}

			#subjects_img{

				width: 75px;
				float: left;
				margin: 8px;
				

			}

			textarea{

				width:100%;
				border: none;
				font-family: 'Roboto Slab';
				font-size: 14px;
				height: 60px;

			}

			#publish_btn{

				float: right;
				background: linear-gradient(to right, #b24592, #f15f79);
				border: none;
				padding: 4px;
				font-size: 14px;
				border-radius: 5px;
				width: 60px;
				color: white;
			}

			#publish_bar{
				margin-top: 20px;
				background-color: white;
				padding: 10px;

			}

			#publish_content{

				padding: 4px;
				font-size:14px;
				display: flex;
				margin-bottom: 6px;

			}

			#cmmnt_form{
				
				padding-bottom: 10px;
				padding-top: 15px;
				border-bottom: 1px solid #aaa;
				border-top: 1px solid #aaa;
			}

		</style>

		<title> Single Post | StudyHub</title>
	</head>

	<body style="font-family: 'Roboto Slab' ; background: linear-gradient(to right, #f1f2b5, #135058);">
		<br>
		<?php include("header.php"); ?>

		<!-- Cover top bar-->
		<div style="width: 800px; margin:auto; min-height: 200px;">
		
			<!-- Below Cover Bar-->
			<div style="display: flex;">
				
				  <!-- Posts Area-->
				<div style="min-height:400px; flex: 2.5; padding: 20px; padding-right: 0px; ">
				 
					 <div style="border: solid 2px white; padding: 10px; background-color: white">
				 			
				 			<h2 style="font-weight: bolder; margin-top: -5px;">Comment </h2>

				 		<?php

				 		$user = new User();
				 		$class_image = new Image();

				 			if(is_array($row)){

								$user_row = $user->retrieve_user($row['user_id']);
				 				include("post.php");
				 			}

				 		?>

				 		<br style="clear: both;">

				 		<div style="border: solid 2px white; padding: 10px; background-color: white; border-top: #aaa;">
				 			
				 			<form method="post" enctype="multipart/form-data" id="cmmnt_form">

					 			<textarea name="post" placeholder ="Type your comment here..."></textarea>
					 			<input type="hidden" name="parent" value="<?php echo $row['post_id']?>">
					 			<input type="file" name="file">
					 			<input type="submit" name="publish" id="publish_btn" value="Publish">
					 			<br>			 																			

				 			</form>
					 	</div>
					 	

					 		<?php 

					 			$comments = $Publish->retrieve_comments($row['post_id']);

					 			if(is_array($comments)){

					 				foreach ($comments as $comment) {
					 					// code...
					 					$user_row = $user->retrieve_user($comment['user_id']);
					 					include("comment.php");
					 				}
					 			}
					 		?>
					 	</div>
					 	
		             </div>
	           </div>
	       </div>
	</body>
</html>