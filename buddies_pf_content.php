<div style="min-height:400px;width: 100%; padding-right: 0px; background-color: white; text-align: center;">
	<div style="padding: 20px;"> 
	<?php

		$class_image = new Image();
		$class_publish = new Publish();
		$class_user = new User(); 


		$following = $class_user->get_following($user_info['user_id'], "user");

		if(is_array($following)){

			foreach ($following as $buddy_follower) {
				// code...
				$buddies_row = $class_user->retrieve_user($buddy_follower['user_id']);
				include("user.php");
			}
			

		}else{

			echo "This user is not your buddy :(";
		}


	?>

	</div>
</div>