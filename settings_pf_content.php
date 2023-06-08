
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<body>
<div style="min-height:400px;width: 100%; padding-right: 0px; background-color: white; text-align: center;">
	<div style="padding: 20px;max-width: 500px; display: inline-block; "> 
		<form method="post" enctype="multipart/form-data">

				<?php

					$class_settings = new Settings();

					$settings = $class_settings->retrieve_settings($_SESSION['studious_user_id']);

					if(is_array($settings)){

						echo "<h1 style='font-size: 20px; border-bottom: 1px solid #aaa; width: 500px; padding-bottom: 15px;'><ion-icon name='settings-outline' id='settings_btn'></ion-icon>Change Information</h1>";
						
						echo "<br>";
						echo "<span style='float: left;'>First Name</span>
						<input type='text' id='text_bar' name='first_name' value='".htmlspecialchars($settings['first_name'])."' placeholder='First Name'/>";
					
						echo "<span style='float: left;'>Last Name</span>
						<input type='text' id='text_bar' name='last_name' value='".htmlspecialchars($settings['last_name'])."' placeholder='Last Name' />";

						echo "<span style='float: left;'>Gender</span>
						<select id='text_bar' name='email' style='height:30px;'>


							<option>".htmlspecialchars($settings['gender'])."</option>
							<option>Male</option>
							<option>Female</option>

						</select>";
					

						echo "<span style='float: left;'>Email</span>
						<input type='text' id='text_bar' name='email' value='".htmlspecialchars($settings['email'])."' placeholder='Email' />";

						echo "<span style='float: left;'>Change Password</span>
						<input type='password' id='text_bar' name='password' placeholder='Password' value='".htmlspecialchars($settings['password'])."'/>";

						echo "<span style='float: left;'>Confirm Password</span>
						<input type='password' id='text_bar' name='password2' placeholder='Password' value='".htmlspecialchars($settings['password'])."'/>";

						echo "<span style='float:left;'>About Me:</span>
							<textarea id='text_bar' name='about' style='height: 200px;'>".htmlspecialchars($settings['about'])."</textarea>
						";
						echo '<input type="submit" id="publish_btn" value="Save">';


					}
					
					

				?>
		</form>

		
	</div>
</div>
</body>