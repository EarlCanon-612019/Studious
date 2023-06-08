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
	$Publish = new Publish();
	$ERROR = "";
	if(isset($_GET['id'])){

		
		$row = $Publish->retrieve_single_post($_GET['id']);

		if(!$row){

			$ERROR = "Unfortunately, the post can't be found.";
		}else {

			if($row['user_id'] != $_SESSION['studious_user_id']){

				$ERROR = "Access Denied. Unauthorized Person cannot delete this file!";
			}
		}
	}else{

		$ERROR = "Unfortunately, the post can't be found.";
	}
		
	if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php")){
				$_SESSION['$return_to'] = $_SERVER['HTTP_REFERER'];
	}

	//if something was posted
	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$Publish->edit_post($_POST, $_FILES);

		
			
		header("Location: ".$_SESSION['$return_to']);
		die;
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
			font-size: 11px; 
			float: right; 
			margin: 10px; 
			color:  white; 
			font-family: 'Roboto Slab'; 
			margin-top: 20px; 
			font-weight: bold;
			transition-duration: 0.4s;
			border: 3px solid  #022135;
			padding: 4px;
			border-radius: 8px;
			width: 80px;
			text-align: center;
			background-color:#022135;

		}
		#publish_btn:hover{

			background-color:  #022135;
			color: white;
			border-radius: 8px;
			cursor: pointer;
		}
		#publish_btn:active{
		transform: scale(0.9) perspective(1px);
		transition: ease 0.1s;
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

		</style>

		<title> Edit | StudyHub</title>
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
				 			
				 			<h2 style="font-weight: bolder; margin-top: -5px;">Edit Post</h2>

				 			<form method="post" enctype="multipart/form-data">

				 				
				 				<hr>
				 					<?php 
				 					//shows error if a particular user tries to delete a post not theirs
										if($ERROR != ""){

											echo $ERROR;
										}else{

		
					 						
					 						echo '<textarea name="post" placeholder ="Publish your notes">'.$row['post'].'</textarea>
					 							<input type="file" name="file">';

					 						echo "<input type='hidden' name='post_id' id='publish_btn' value='$row[post_id]'>";
					       					echo "<input type='submit' id='publish_btn' value='Save'>";

					       					if(file_exists($row['image']))
											{
												$class_image = new Image();
												$image_post = $class_image->thumbnail_post($row['image']);

												echo "<br><br><div style='text-align: center;'><img src ='$image_post' style= 'width: 50%' /></div>";
											}
				 						}
				 					 ?>
				 				<hr>
					       		
					       		
					 			<br>
				 			</form>

					 	</div>
					 	
		             </div>
	           </div>
	       </div>
	</body>
</html>