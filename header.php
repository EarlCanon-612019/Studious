<!-- Profile top bar-->

<?php
	
	$topbar_image = "images/male1.jpg";
	if(isset($USER)){
		
		if(file_exists($USER['profile_image']))
		{
			$class_image = new Image();
			$topbar_image = $class_image->thumbnail_profile($USER['profile_image']);
		}else{

			if($USER['gender'] == "Female"){

				$topbar_image = "images/female1.jpg";
			}
		}
	}

?>

<div id="profiletop_bar"> 
	<form method="get" action="search.php">
		<div style="width: 800px; margin:auto; font-size: 30px; color: white; ">

			
			<a href="index.php" style="color: white; text-decoration: none; font-family: Bruno Ace SC;">
				<span>
					<img src="HEADERLOGO.png" style="float:left; width: auto; height: 70px; margin-top: -7px; margin-bottom: -70px; margin-left: -70px;">
				</span>
				<span style="font-family: Bruno Ace SC;">Studious</span>

			</a>
			
			
			 &nbsp &nbsp  <input type="text" id="search_bar" name='search_cont' placeholder="Search for Buddies">
			

			 <a href="profile.php">
			<img src="<?php echo $topbar_image ?>" style="width: 40px; float: right; border-radius: 50px; margin-top: 4.5px; border: 1px solid white;">
			</a>

			<a href="logout.php">
				<span id="logout">Sign Out</span>
			<a/>

				<?php
						//checks if the user owns the profile by matching the user-id and only show the setting button on the user and not on other users profile
						if($user_info['user_id'] == $_SESSION['studious_user_id']){
							echo '<a href="profile.php?section=settings&id='.$user_info['user_id'].'"><div style="margin-right: -170px; margin-top: 10px; float: right; font-size: 30px;"><ion-icon name="settings-outline" id="settings_btn2"></ion-icon></div></a>';
						}
					?>

			
		</div>
	</form>
</div>

<style>
	
	#logout{

		font-size: 11px; 
		float: right; 
		margin: 10px; 
		color: white; 
		font-family: 'Roboto Slab'; 
		margin-top: 16px; 
		font-weight: bold;
		transition-duration: 0.4s;
		border: 1px solid white;
		padding: 4px;
		border-radius: 8px;
		width: 50px;
		text-align: center;


	}
	#logout:hover{

		background-color: white;
		color: black;
		border-radius: 8px;
	}
	#settings_btn2{
	color: white;
}


</style>