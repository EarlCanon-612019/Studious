
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

						
						echo "<span style='font-size: 20px; font-weight: bold;'> <ion-icon name='information-circle-outline' id='about_icon'></ion-icon> About Me</span><br>
							<div id='aboutme_bar' style='height: 200px; text-align: center; '>".htmlspecialchars($settings['about'])."</div>
						";


					}
					
					

				?>
		</form>
	</div>
</div>
</body>