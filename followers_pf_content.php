<div style="min-height:400px;width: 100%; padding-right: 0px; background-color: #136f63; text-align: center; color: black; border-top: 2px solid black;">
	<div style="padding: 20px;"> 
	<?php

		$class_image = new Image();
		$class_publish = new Publish();
		$class_user = new User(); 

		$followers = $class_publish->get_reacts($user_info['user_id'], "user");

		if(is_array($followers)){

			foreach ($followers as $buddy_follower) {
				// code...
				$buddies_row = $class_user->retrieve_user($buddy_follower['user_id']);
				include("user.php");
			}
			

		}else{

			echo "Sorry, No followers were found";
		}


	?>

	</div>
</div>