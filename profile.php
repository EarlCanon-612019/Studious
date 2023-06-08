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
			
			if(isset($_POST['first_name'])){

				$class_settings = new Settings();
				$class_settings->saving_settings($_POST, $_SESSION['studious_user_id']);

			}else{

				$post = new Publish();
				$id_log = $_SESSION['studious_user_id'];
				$result = $post->publish_post($id_log, $_POST, $_FILES);

				if($result == "")
				{

					header("Location: profile.php");
					die;
				}else
				{

					echo "<div style=' text-align: center; font-size: 12px; color: red; background-color: white; font-size: 14px; font-weight: bold; word-spacing: 5px; font-family: 'Roboto Slab'>";
					echo "<br>The Following errors occured<br>";
					echo $result;
					echo "</div>";
		    	}

			}
				
	
		}

		//collection of posts
		$post = new Publish();
		$id_log = $user_info['user_id'];

		$retrieve = $post->retrieve_post($id_log);

		//collect study buddies
		$user = new User();
		
		$buddies = $user->retrieve_buddies($id_log);

		$class_image = new Image();

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
			    background: ;
			    font-family: 'Oleo Script';
			    background-color: #022135;
 

			}

			#search_bar{
				width: 400px;
				height: 20px;
				border-radius: 8px;
				border: none;
				padding: 4px;
				font-size: 14px;
				background-image: url(search.png);
				background-repeat: no-repeat;
				background-position: right;
				background-size: 16px;
				padding-right: 8px;

			}

			#text_bar{
				width: 100%;
				height: 20px;
				border-radius: 5px;
				border: 2px solid black;
				padding: 4px;
				font-size: 14px;
				border: solid thin grey;
				margin: 10px;
				float:left;

				

			}

			#aboutme_bar{
				width: 100%;
				height: 20px;
				border-radius: 5px;
				border: none;
				padding: 4px;
				font-size: 19px;
				border: solid thin grey;
				margin: 10px;
				float:left;
				border: 2px black solid;
				background-color: #022135;
				color: white;

			}

			#profile_img {
				width: 150px;
				border-radius: 150px;
				margin-top: -150px;
				border: solid 5px #022135;

			}

			#menu_btns{

				width: 100px;
				display: inline-block;
				margin: 2px;
				color: black;
				transition: 0.2s;
				cursor: pointer;
				padding-bottom: 9px;




			}
			#menu_btns:hover{
				transform: scale(1.2) perspective(4px);
				-webkit-background-clip: text;
				-webkit-text-fill-color: solid;
				font-weight: bold;


			}

		
			#subjects_img{

				width: 70px;
				float: left;
				margin: 8px;				
				border-radius: 50%;
				border: 3px solid #022135;
				margin-top: 23px;

			}

			#subjects{
				clear: both ;		
				width: 100%;
				 


			}

			#subject_bar{
				
				background: #136f63; 
				min-height: 500px;
				margin-top: 20px;
				color: white;
				padding: 8px;
				font-weight: bold;
				border: 1px solid #aaa;

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

			background-color:  #136f63;
			color: white;
			border-radius: 8px;
			cursor: pointer;

		}

		#publish_btn:active{
		transform: scale(0.9) perspective(1px);
		transition: ease 0.1s;
		}
			#about_icon{

				font-size: 30px;
				margin-bottom: -7px;

			}
			#settings_btn{
				font-size: 30px;
				margin-bottom: -7px;
				padding-right: 6px;
			}

			#follow_btn{

				background: forestgreen;
				border: 1px solid black;
				padding: 3px;
				margin-right: 5px;
				font-size: 11px;
				border-radius: 5px;	
				color: white;
				min-width: 100px;
				cursor: pointer;
			
			    float: right;
				font-family: Roboto Slab;
				height: 30px;
				position: relative;

			}

			#follow_btn:hover{

			background: seagreen;
			color: white;
	}


			#publish_bar{
				margin-top: 20px;
				background-color: white;
				padding: 10px;
				border: 1px solid #aaa;


			}

			#publish_content{

				padding: 4px;
				font-size:14px;
				display: flex;
				margin-bottom: 6px;
				
				

			}

			#post{

				padding: 4px;
				font-size:14px;
				display: flex;
				margin-bottom: 6px;

			}

			#change_profile{

				border: 1px solid black;
				border-radius: 5px;
				padding: 3px;
				padding-right: ;
				text-align: center;
				color: black;
				margin-left: -200px;
				margin-bottom: -70px;
				margin-right: 5px;

				


			}
			#change_profile:hover {
				background-color: black;
				color: white;
				transition-duration: 0.4s;
				
			}


				#change_cover{

				border: 1px solid black;
				border-radius: 5px;
				padding: 3px;
				margin-right: -195px;
				color: black;
				text-align: center;
				margin-top: -40px;
				

			}
			#change_cover:hover {
				background-color: black;
				color: white;
				transition-duration: 0.4s;


				

			}
			#buttons_pfp{
				
			
		
			   justify-content: center;
			   align-items: center;
			   margin-top: 10px;
			  
			}
			


		</style>

		<title> Profile | StudyHub</title>
	</head>

	<body style="font-family: 'Roboto Slab' ; background: #F2EFEB">


		<br>

		<?php include("header.php"); ?>

		<!-- Cover top bar-->
		<div style="width: 900px; margin:auto; height: 100vh;">

			<div style="background-color: white; text-align: center; border: 1px solid #aaa;">

					<?php

     					$image = "images/coverimage_placeholder.jpg";
     					if(file_exists($user_info['cover_image']))
     					{
     						$image = $class_image->thumbnail_cover($user_info['cover_image']);
     					}
     				?>

				<img src="<?php echo $image ?>" style="width: 100%">

				

				<span style="font-size: 10px; text-decoration: none;">
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
				</span>

				<div id="buttons_pfp">
					<img src="<?php echo $image ?>" id="profile_img"></br>
					
						<a href= "profile_change.php?change=profile" style= "font-size: 11px; text-decoration: none; font-weight: bold;" id="change_profile">Change Profile </a>•
						<a href= "profile_change.php?change=cover" style= "font-size: 11px; text-decoration: none; font-weight: bold;" id="change_cover">Change Cover </a>		

				</div>
	           <!-- depending on the user input, their name will be displayed accordingly to the profile page-->
				<div style="font-size: 20px; font-weight: bold; padding-top: 5px;"> 

					<a href="profile.php?id=<?php echo $user_info['user_id']?>" style="text-decoration: none; color: black;"> 
						<?php echo $user_info['first_name'] . " " . $user_info['last_name'] ?>
					</a>
					
				
				</div>
				<br>

					<?php

							$myreacts = "";
							if($user_info['reacts'] > 0){

							$myreacts = "•" . " " .$user_info['reacts'] . " Followers";
						}

						?>
					<a href="react.php?type=user&id=<?php echo $user_info['user_id']?>"> 
						<input type="button" name="publish" id="follow_btn" value="Follow <?php echo $myreacts ?>">
					</a> 
					
				<br>

				

				<a href="index.php"><div id="menu_btns">Feed </div></a>

				<a href="profile.php?section=about&id=<?php echo $user_info['user_id'] ?>"><div id="menu_btns">About</div></a>

				<a href="profile.php?section=photos&id=<?php echo $user_info['user_id'] ?>"><div id="menu_btns">Photos</div></a>

				<a href="profile.php?section=following&id=<?php echo $user_info['user_id'] ?>"><div id="menu_btns">Buddies</div></a>
				<a href="profile.php?section=followers&id=<?php echo $user_info['user_id'] ?>"><div id="menu_btns">Followers</div></a>

				<?php
					//checks if the user owns the profile by matching the user-id and only show the setting button on the user and not on other users profile
					if($user_info['user_id'] == $_SESSION['studious_user_id']){
						echo '<a href="profile.php?section=settings&id='.$user_info['user_id'].'"><div id="menu_btns" style="margin-right: -60px;">Settings</div></a>';
					}
				?>
				   
			</div>

			<!-- Below Cover Bar-->
			
			<?php

				$section = "default";
				if(isset($_GET['section'])){

					$section = $_GET['section'];
				}

				if($section == "default"){

					include("default_pf_content.php");

				}elseif($section == "following"){

					include("buddies_pf_content.php");

				}elseif($section == "followers"){

					include("followers_pf_content.php");
 				
				}elseif($section == "about"){

					include("about_pf_content.php");

				}elseif($section == "settings"){

					include("settings_pf_content.php");

				}elseif($section == "photos"){

					include("photos_pf_content.php");
 				}
			?>
	       </div>
	</body>
</html>