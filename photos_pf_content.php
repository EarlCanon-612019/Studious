<div style="min-height:400px;width: 100%; padding-right: 0px; background-color: white; text-align: center; border: ;">
	<div style="padding: 20px;"> 
	<?php

		$DB = 	new connect_database();
		$sql = "select image, post_id from posts where photo_image = 1 && user_id = $user_info[user_id] order by id desc limit 30";
		$images = $DB->read_1($sql);

		$class_image = new Image();


		if(is_array($images)){

			foreach ($images as $row_image) {
				// code...

				echo "<a href ='single_post.php?id=$row_image[post_id]' id='photos_sec'>";
				echo "<img src='" . $class_image->thumbnail_post($row_image['image']) . "' style='width:150px; border-radius: 5px;' />";
				echo "</a>";
			}
			

		}else{

			echo "Sorry, No images were found";

		}

	?>


	</div>
</div>

<style>
		
		#photos_sec{

			display: inline-flex;
			padding: -4px;
			border: 1px solid #ddd;
			margin: 8px;
			border-radius: 5px;
	
		}

		#photos_sec:hover{

				transform: scale(1.1) perspective(2px);
				overflow: hidden;
				background-color: #ddd;
				box-shadow: 0 3px 10px rgb(0 0 0 / 0.5);
				
			

			

		}


</style>