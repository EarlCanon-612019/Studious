<div id="subjects" style="display: inline-block;">

		<?php 

			$image = "images/male1.jpg";
			if($buddies_row['gender'] == "Female")
			{
				$image = "images/female1.jpg";
			}

			//change all placeholders with the users profile and displays it
			if(file_exists($buddies_row['profile_image']))
			{
				
				$image = $class_image->thumbnail_profile($buddies_row['profile_image']);
			}

		?>
		 <!-- URL query strings-->
		<a href="profile.php?id=<?php echo $buddies_row['user_id']; ?>"> 
			<img id="subjects_img" src="<?php echo $image ?>">

		 	<span id="buddies_name">				  
		 	<?php echo $buddies_row['first_name'] . " " . $buddies_row['last_name'] ?>	  
	     	</span> <br><br><br>
	     	
	     </a>	

	     <a href="profile.php?id=<?php echo $buddies_row['user_id']; ?>"> 
		 	<span id="view_pfp">				  
				View Profile  
	     	</span> <br>
	     	
	     </a>	


</div>												

<style>
	
#buddies_name{
	float:left;
	margin-top: 25px;
	 padding-right: 10px; 
	 color: white; 
	 padding: 5px; 
	 border-radius: 9px;
	 font-size: 16px;
	margin-bottom: -10px;

}
#view_pfp{
	font-size: 13px;
	text-decoration: none;
	float: left;
	color: black;
	border: 2px solid black;
	padding:4px;
	padding-right: 10px ;
	padding-left:10px ;
	border-radius: 15px;
	background-color: white;
	margin-top: -10px;
}
	#view_pfp:hover{
	background-color: black;
	
	padding: 3px;
	border-radius: 6px;
	color: white;
	border: 2px solid ;
	padding:4px;
	padding-right: 10px ;
	padding-left:10px ;
	border-radius: 15px;
}

	#view_pfp:active{
		transform: scale(0.9) perspective(1px);
	}




</style>