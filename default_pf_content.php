<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<body>
<div style="display: flex;">

				  <!-- Subject Area-->
				<div style="min-height: 400px; flex:1;">

					<div id="subject_bar"><ion-icon name="people-outline" style="margin-bottom: -4px; font-size: 19px; padding-right: 5px;"></ion-icon>

							 Study Buddies<br> 

						 <?php


						 		 	if($buddies)
						 		 	{

						 		 		foreach ($buddies as $buddies_row) {
						 		 			// code...
						 		 		
						 		 			include("user.php");
						 		 		}
						 		 	}
						 		 							 		 								 		 						 		 	
						 		 ?>
					</div>
				</div>

				  <!-- Posts Area-->
				<div style="min-height:400px; flex: 2.5; padding: 20px; padding-right: 0px;">
				 
					 <div style="border: solid 2px white; padding: 10px; background-color: white; border: 1px solid #aaa">
				 			
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


						 		 	if($retrieve)
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
	       </body>