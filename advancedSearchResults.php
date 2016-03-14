<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/gatekeeper.php'); //checks if user is logged on 
	include($_SERVER['DOCUMENT_ROOT'].'/PAL/php/user_session_check.php'); //checks if user is logged on
	if(userAllowedAccess($sso_pdo, "sso_admin")) : 
?>

<html>
	<title>Results</title>		<!-- Name of site page in tab -->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="/PAL/HomePage.css">
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
						Results
					</p>
					
					<?php
						include('search/livesearch.php');
					?>
				</div>
			
				<div class="content">
				
					<?php
						include('search/advance-search-controller.php');
					?>
				</div>
				
			</center>	
			
		</p>
		
	</body>

</html>

	<?php
		$test1 = @mysql_connect("localhost", "ics", "pwd4ics");
	
	if (!$test1) {
	
		echo( "<P>Unable to connect to the " .
			"database server at this time.</P>" );
		exit();
	} 		
		
	?>
	
<?php endif;