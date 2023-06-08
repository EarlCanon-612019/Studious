<div id="publish_content">
	<div>

		<?php 
			//checks whether they are male or female and place the appropriate profile placeholder depending on what gender they put in the sign up page
			$image = "images/male1.jpg";
			if($user_row['gender'] == "Female")
			{
				$image = "images/female1.jpg";
			}

			$class_image = new Image();
			//change all placeholders with the users profile and displays it
			if(file_exists($user_row['profile_image']))
			{
				
				$image = $class_image->thumbnail_profile($user_row['profile_image']);
			}

		?>
		<img src="<?php echo $image ?>" style="width: 70px; margin-right: 6px;border-radius: 50%; border: solid 2px #f15f79;">
	</div>
	<div style= " width: 100%">
		<div style="font-weight: bolder; color: black;"> 
				<?php 
				//shows a message beside the name whenever the user changed their profile image
					echo htmlspecialchars($user_row['first_name']) . " " . htmlspecialchars($user_row['last_name']); 
				
				    //user gender is set depending on the user input
					if($row['user_profile_img'])
					{
						$user_pronoun = "his";
						if($user_row['gender'] == "Female")
						{
							$user_pronoun = "her";
						}
						echo "<span style=' font-size: 11px; color: #aaa; margin-left: 7px;'> updated $user_pronoun profile image </span>";
					}

				//shows a message beside teh naem whenever the user changed their cover image
					if($row['user_cover_img'])
					{
						$user_pronoun = "his";
						if($user_row['gender'] == "Female")
						{
							$user_pronoun = "her";
						}
						echo "<span style=' font-size: 11px; color: #aaa; margin-left: 7px;'> updated $user_pronoun cover image </span>";
					}

					
         		?>
			</div>

			<?php
			//treats posts as normal text and not special characters to avoid script hacking
			 	echo htmlspecialchars($row['post'])
			 ?>
			<br><br>

			<?php 

			if(file_exists($row['image']))
			{
				$image_post = $class_image->thumbnail_post($row['image']);

				echo "<img src ='$image_post' style= 'width: 60%' />";
			}
			
			?>

		</div>
								 			
	</div>