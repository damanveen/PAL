<?php
	include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/gatekeeper.php');
	include($_SERVER['DOCUMENT_ROOT'].'/PAL/php/user_session_check.php'); //checks if user is logged on
	if(userAllowedAccess($sso_pdo, "teacher") OR userAllowedAccess($sso_pdo, "sso_admin")) :
?>

<html>

	<title>My Classes</title>		<!-- Name of site page in tab -->
	
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="HomePage.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="/PAL/javascript/optionsTab.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
		
		
		<?php include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/javascript/color.php"); ?>
		
	</head>

	<body>
		
		<p> 	
			
			<?php 
				
				include('includes/toolbar.php');
				include('includes/optionsTab.php');
				
			?>
			
			<center>
			
				<div class="subtitle">
				
					<p class="subtitle_title">
		
						My Classes
					
					</p>
				
					
				
				</div>
				
				<div class="content">
		
					<p id="allClasses">
						
						
						<?php include($_SERVER["DOCUMENT_ROOT"]."/PAL/php/class.php"); 
								
							if ($class_teacher_valid == 1) { 
								foreach ($info as $item) {
									echo "<div id='class_names'><a class='S_names' href = 'class_students.php?class_id=$item[class_id]&class=$item[class]'>$item[class]</a></div>";
								}
							}
							else {
								echo "Teacher has no registered class";
							}
						?>
					
					</p>
				
				</div>
			
			</center>
			
		</p>
		
	</body>

</html>

<?php

endif;
?>