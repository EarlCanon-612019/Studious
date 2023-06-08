<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<div id="publish_content">
	<div>

		<?php 
			//checks whether they are male or female and place the appropriate profile placeholder depending on what gender they put in the sign up page
			$image = "images/male1.jpg";
			if($user_row['gender'] == "Female")
			{
				$image = "images/female1.jpg";
			}
			//change all placeholders with the users profile and displays it
			if(file_exists($user_row['profile_image']))
			{
				
				$image = $class_image->thumbnail_profile($user_row['profile_image']);
			}

		?>
		<img src="<?php echo $image ?>" style="width: 70px; margin-right: 6px;border-radius: 50%; border: solid 3px  #022135;">
	</div>
	<div style= " width: 100%">
		<div style="font-weight: bolder; color: black;"> 
				<?php 

				echo "<a href='profile.php?id=$row[user_id]'style='text-decoration: none; color: #022135'> ";
				//shows a message beside the name whenever the user changed their profile image
					echo htmlspecialchars($user_row['first_name']) . " " . htmlspecialchars($user_row['last_name']); 
				echo "</a>";
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

	<br><br>
	<?php
		$reacts = "";

		$reacts = ($row['reacts'] > 0) ? "(" .$row['reacts']. ")" : "" ;
		
	?>

	<a href="react.php?type=post&id=<?php echo $row['post_id'] ?>"style="text-decoration: none; font-weight: bold; color: royalblue;"> React <?php echo $reacts ?></a> <span style="font-weight: bolder; color: blue;"> • </span>

	<?php

	$comments = "";

	if($row['comments'] > 0){

		$comments = " (" . $row['comments'] . ")";
	}

	?>

	 <a href="single_post.php?id=<?php echo $row['post_id'] ?>" style="text-decoration: none; font-weight: bold; color: royalblue;">
	 Comment<?php echo $comments ?>
	</a> |




	<span style="color: #999">
		
		<?php 

		$time = new Time();
		//access a function directly inside a class without instantiating a class
		echo $time->retrieve_time($row['date']);
		?>

	</span>

	<?php

		if($row['photo_image']){

			echo "<a href='img_full_view.php?id=$row[post_id]' id='img_view'>";
			echo " | Expand Image ";
			echo "</a>";
		}
	?>

	<span style="color: #999; float: right">
		
		<?php

			$Publish = new Publish();

			if($Publish->my_personal_post($row['post_id'],$_SESSION['studious_user_id'])){

				echo "
				<a href='edit.php?id=$row[post_id]'>
					<ion-icon name='create-outline' style='font-size: 20px; color: royalblue;'></ion-icon> 
				</a>
				
				<!--shows the id of every post so that the website can identify which to delete-->

				<a href='delete.php?id=$row[post_id]'>
					<ion-icon name='trash' style='font-size: 20px; color: royalblue; text-decoration: none'></ion-icon>
				</a>";
			}

		?>
	</span>
	
	<?php
			$own_react = false;

			if(isset($_SESSION['studious_user_id'])){

				$DB = new connect_database();
				
				$sql = "select reacts from reacts where type='post' && content_id = '$row[post_id]' limit 1";
				$result = $DB->read_1($sql);
				if(is_array($result)){

					$reacts = json_decode($result[0]['reacts'], true);

					$user_ids = array_column($reacts, "user_id");

					if(in_array($_SESSION['studious_user_id'], $user_ids)){
					 $own_react = true;
					}
				}
		    }
			if($row['reacts'] > 0){

				echo "</br>";
				echo "<a href='show_react.php?type=post&id=$row[post_id]' style='text-decoration:none; color: black;'>";


				//shows the appropriate message whether 1 person reacted to the post or more. Also identifies if you also reacted along with other users
				if($row['reacts'] == 1){

					if($own_react){
						echo "<div style='text-align: left;'>You reacted to this post </div>";
				    }else{

						echo "<div style='text-align: left;'> 1 buddy reacted to this post </div>";
				    }
				}else{

					if($own_react){

						$text = "buddies";
						if($row['reacts'] - 1 == 1){

							$text = "buddy";
						}  
						echo "<div style='text-align: left;'> You and " . ($row['reacts'] - 1) . "  $text reacted to this post </div>";
					}else{
						echo "<div style='text-align: left;'>" . $row['reacts'] . " buddies reacted to this post </div>";
					}
				
			    }

			   echo "</a>";
				
			}
	?>

		</div>
								 			
	</div>

	<style>
		
		#img_view{
			text-decoration: none; 
			color: #022135;
		}

		#img_view:hover{
			color: blue;


		}

		#profile_link{

			text_decoration:none;
			color: black;
		}
	</style>