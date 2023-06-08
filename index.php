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

				header("Location: index.php");
				die;
			}else
			{

				echo "<div style=' text-align: center; font-size: 12px; color: red; background-color: white; font-size: 14px; font-weight: bold; word-spacing: 5px; font-family: 'Roboto Slab'>";
				echo "<br>The Following errors occured<br>";
				echo $result;
				echo "</div>";
			}
	
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
			     background-color: #022135;
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
				border: solid 5px #022135;

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

		</style>

		<title> Feed | StudyHub</title>
	</head>

	<body style="font-family: 'Roboto Slab' ; background: linear-gradient(to right, #f1f2b5, #135058);">
		<br>
		<?php include("header.php"); ?>

		<!-- Cover top bar-->
		<div style="width: 1500px; margin:auto; min-height: 200px;">
		
			<!-- Below Cover Bar-->
			<div style="display: flex;">

				  <!-- Subject Area-->
				<div style="min-height: 400px; flex:1;">

					<div id="subject_bar">
					<?php

	     				$image = "images/male1.jpg";
	     				if($user_info['gender'] == "Female")
	     				{
	     					$image = "images/female1.jpg";
	     				}
	     				if(file_exists($user_info['profile_image']))
	     				{
	     					$image = $class_image->thumbnail_profile($user_info['profile_image']);
	     				}
     			    ?>
					<img src="<?php echo $image ?>" id="profile_img"></br>

							<a href ="profile.php" style = "text-decoration: none; font-family: Roboto Slab; color: black;">
								<?php echo $user_info['first_name'] . "<br> " .  $user_info['last_name']; ?>
								<a/>
					</div>
				</div>

				  <!-- Posts Area-->
				<div style="min-height:400px; flex: 2.5; padding: 20px; padding-right: 0px;">
				 
					 <div style="border: solid 2px white; padding: 10px; background-color: white">
				 			
				 				<form method="post" enctype="multipart/form-data">

					 			<textarea name="post" placeholder ="Publish your notes"></textarea>
					 			<input type="file" name="file">
					 			<input type="submit" name="publish" id="publish_btn" value="Publish">
					 			<br>

				 			</form>
					 	</div>
					 	<!--Posts-->
						 <div id="publish_bar">
						 		
						 	 <?php
						 	 			$post = new Publish();
										$id_log = $user_info['user_id'];

										$retrieve = $post->retrieve_post($id_log);

						 	 			$DB = new connect_database();
						 	 			$class_user = new User();
						 	 			$class_image = new Image();

						 	 			$followers = $class_user->get_following($_SESSION['studious_user_id'], "user");

						 	 			$id_followers = false;
						 	 			if(is_array($followers)) {

						 	 				$id_followers = array_column($followers, "user_id");
						 	 				//implode gets an array and gets all the values in the array and connects them together to make a string
						 	 				$id_followers = implode("','", $id_followers);


						 	 			}


									
						 	 			if($id_followers){
						 	 				$mypersonalid = $_SESSION['studious_user_id'];
						 	 				$sql = "select * from posts where parent = 0 and user_id = '$mypersonalid' || user_id in('" .$id_followers. "') order by id desc limit 25";
						 	 				$retrieve = $DB->read_1($sql);
						 	 			}



							 		 	if(isset($retrieve) && $retrieve)
							 		 	{

							 		 		foreach ($retrieve as $row) {
							 		 			// code...
							 		 			$user = new User();
							 		 			$user_row = $user->retrieve_user($row['user_id']);

							 		 			include("post.php");
							 		 		}
							 		 	}
							 		 							 		 								 		 						 		 	
							 		 ?>						 	

						    </div>
		             </div>
	           </div>
	       </div>
	</body>
</html>