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
	

	$Publish = new Publish();
	$row = false;

	$ERROR = "";
	if(isset($_GET['id'])){	

		
		$row = $Publish->retrieve_single_post($_GET['id']);

		
	}else{

		$ERROR = "Unfortunately, no image was found.";
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

			#back_bttn{
				
				color: white;
				text-decoration: none;
			}
		</style>

		<title> Single Post | StudyHub</title>
	</head>

	<body style="font-family: 'Roboto Slab' ; background: #f2efeb">
		<br>
		<?php include("header.php"); ?>

		<!-- Cover top bar-->
		<div style="width: 800px; margin:auto; min-height: 200px;">
		
			<!-- Below Cover Bar-->
			<div style="display: flex;">
				
				  <!-- Posts Area-->
				<div style="min-height:400px; flex: 2.5; padding: 20px; padding-right: 0px; ">
				 
					 <div style="border: solid 2px black; padding: 10px; background-color: #022135">

				 			
				 		
				 		<?php

				 		$user = new User();
				 		$class_image = new Image();

				 			if(is_array($row)){

								echo "<img src='$row[image]' style='width:100%' />";
				 			}

				 		?>
				 		<span style="float: right;">
				 			<a href="profile.php" id="back_bttn"><ion-icon name="arrow-back-outline" style="font-size: 22px; margin-bottom: -5px;"></ion-icon>Back</a>
						</span>
				 		<br style="clear: both;">

					 	</div>
					 	
		             </div>
	           </div>
	       </div>
	       <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
			<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	</body>
</html>