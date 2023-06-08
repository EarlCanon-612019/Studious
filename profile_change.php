<?php

session_start();

	include("classes/connect.php");
	include("classes/login.php");
	include("classes/user.php");
	include("classes/post.php");
	include("classes/image.php");

	$login = new Login();
	$user_info = $login->log_check($_SESSION['studious_user_id']);


		//for publishing content
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			
			if(isset($_FILES['pro_file']['name']) && $_FILES['pro_file']['name'] !="")
			{

				if($_FILES['pro_file']['type'] == "image/jpeg")
				{
					// allowed size 3MB
					$allowed_size = (1024 * 1024) * 7;
					
					if($_FILES['pro_file']['size'] < $allowed_size)
					{
						//everything is good
						$new_folder = "uploads/" . $user_info['user_id'] . "/";

						//create folder for users
						if(!file_exists($new_folder))
						{
							//7777 file permission means that everyone regardless of who is accessing the system has access to read, write, and execute
							mkdir($new_folder, 0777, true);
						}

						$image = new Image();

						$filename = $new_folder . $image->create_filename(15) . ".jpg";
						move_uploaded_file($_FILES['pro_file']['tmp_name'], $filename);

							$change = "profile";

							//check whether the input is for cover image or profile image
							if(isset($_GET['change']))
							{
								$change = $_GET['change'];
							}
												
						if($change == "cover")
							{
								if(file_exists($user_info['cover_image']))
								{
									unlink($user_info['cover_image']);
								}
								$image->image_resize($filename, $filename, 1500, 1500);
							}else
							{
								if(file_exists($user_info['profile_image']))
								{
									unlink($user_info['profile_image']);
								}
								$image->image_resize($filename, $filename, 1500, 1500);
							}
												
						if(file_exists($filename))
						{
							$user_id = $user_info['user_id'];
							

							if($change == "cover")
							{
								
								$query = "update users set cover_image = '$filename' where user_id = '$user_id' limit 1";
								$_POST['user_cover_img'] = 1;

							}else
							{
								
								$query = "update users set profile_image = '$filename' where user_id = '$user_id' limit 1";
								$_POST['user_profile_img'] = 1;
							}
						
							$DB = new connect_database();
							$DB->save_1($query);

						
							//create a post when changing profile
							$post = new Publish();

							$post->publish_post($user_id, $_POST, $filename);

							header("Location: profile.php");
							die;
						}

					}else
					{
						echo "<div style=' text-align: center; font-size: 12px; color: red; background-color: white; font-size: 14px; font-weight: bold; word-spacing: 5px; font-family: 'Roboto Slab'>";
						echo "<br>The Following errors occured:<br><br>";
						echo "Only 3MB or lower image size are allowed!";
						echo "</div>";
					}
				}else
				{
					echo "<div style=' text-align: center; font-size: 12px; color: red; background-color: white; font-size: 14px; font-weight: bold; word-spacing: 5px; font-family: 'Roboto Slab'>";
					echo "<br>The Following errors occured:<br><br>";
					echo "Only jpeg type images are allowed!";
					echo "</div>";
				}

				
			}else
			{

				echo "<div style=' text-align: center; font-size: 12px; color: red; background-color: white; font-size: 14px; font-weight: bold; word-spacing: 5px; font-family: 'Roboto Slab'>";
				echo "<br>The Following errors occured:<br><br>";
				echo "Image not found/ valid";
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

	

			#publish_btn{

			font-size: 11px; 
			float: right; 
			margin: 10px; 
			color:  white; 
			font-family: 'Roboto Slab'; 
			margin-top: -10px; 
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

			background-color:  #136f63;
			color: white;
			border-radius: 8px;
			cursor: pointer;

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

		<title> Change Profile | Studious</title>
	</head>

	<body style="font-family: 'Roboto Slab' ; background: linear-gradient(to right, #f1f2b5, #135058);">
		<br>
		<?php include("header.php"); ?>

		<!-- Cover top bar-->
		<div style="width: 800px; margin:auto; min-height: 200px;">
		
			<!-- Below Cover Bar-->
			<div style="display: flex;">

				

				  <!-- Posts Area-->
				<div style="min-height:400px; flex: 2.5; padding: 20px; padding-right: 0px;">
				 	
				 	<form method="post" enctype="multipart/form-data">
						 <div style="border: solid #aaa; padding: 10px; background-color: white">
					 			
					 			<input type="file" name="pro_file"><br>
					 			<input type="submit" name="publish" id="publish_btn" value="Change">
					 			<br>
					 			<div style="text-align: center;">
					 				<br>
								<?php  
									
								//check whether the input is for cover image or profile image
								if(isset($_GET['change']) && $_GET['change'] == "cover")
								{
									$change = "cover";
									echo "<img src='$user_info[cover_image]'style='max-width: 500px;'>";
								}else
								{
									echo "<img src='$user_info[profile_image]'style='max-width: 500px;'>";
								}

					 			
					 			?>
					 			</div>
						 </div>
					 </form>

		             </div>
	           </div>
	       </div>
	</body>
</html>