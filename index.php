<?php
include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/gatekeeper.php'); //checks if user is logged on 
include($_SERVER['DOCUMENT_ROOT'].'/PAL/php/user_session_check.php'); //checks if user is logged on
if(userAllowedAccess($sso_pdo, "teacher") OR userAllowedAccess($sso_pdo, "sso_admin")) :
?>
<html>
	<title>HomePage</title>		<!-- Name of site page in tab -->
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
				
					<p id="homeTitle" class="subtitle_title">
					
						HomePage
					
					</p>
				
				</div>
			
				<div class="content">
				
					<p id="home">
					
						<?php
													
								$sql = "SELECT * FROM homePage";
								include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
								 
								 while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
									$homePage[] = array('title' =>$item['title'], 'content' => $item['content']);	

								 }					
								
						?>
						
						<div class="messageTitle1">
							<?php
								echo $homePage[0]['title'];
							?>
							<div id="message">
								<?php
								echo $homePage[0]['content'];
							?>
							</div>
						</div>
						
						<div class="messageTitle2">
							<?php
								echo $homePage[1]['title'];
							?>
							<div id="message">
								<?php
								echo $homePage[1]['content'];
							?>
							</div>
						</div>
					
					</p>
				
				</div>
			
			</center>
			
		</p>
		
	</body>

</html>

<?php

endif;

?>