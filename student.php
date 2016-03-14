<?php
include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/gatekeeper.php'); //checks if user is logged on 
include($_SERVER['DOCUMENT_ROOT'].'/PAL/php/user_session_check.php'); //checks if user is logged on
if(userAllowedAccess($sso_pdo, "teacher") OR userAllowedAccess($sso_pdo, "sso_admin")) :
?>
<html>
	<title>Student Info</title>		<!-- Name of site page in tab -->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="HomePage.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="/PAL/javascript/optionsTab.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
		
		<?php include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/javascript/color.php"); ?>
		<style>
			iframe {
				width: 70%;
				height: 100%;
				border:none;
			}
		</style>
	
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
					
						<?php 
							$sql = "SELECT first, last FROM students WHERE student_id = $_GET[stud_id]";							
							include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
							$info = $results -> fetch(PDO::FETCH_ASSOC);
							echo $info['last'] . ", " . $info['first']; ?>
					
					</p>
					<form name ="print" action="/PAL/php/pdf/student_pdf_report_card.php" method = "GET">
						<input type = "hidden" name = 'stud_id' value = '<?php echo $_GET['stud_id']; ?>'>
						<button type="submit" class="studProg" id="printButton"></button>
					</form>
				
				
				</div>
			
				<div class="content">
				
					<p id="home">
					<?php
					$stud_id = $_GET['stud_id'];
					if (empty($stud_id)) {
						echo "ERROR: STUDENT DOES NOT EXIST";
						exit();
						}
					else {
						$stud_id = $_GET['stud_id']; //student id retrieved from query link
						include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/student_report_cards.php"); //fetches a student class id for all of their classes
						if ($class_valid == 1) {?>
							<iframe src = "http://dev.emmell.org/PAL/php/pdf/student_pdf_report_card.php?stud_id=<?php echo $_GET['stud_id']; ?>" scrolling="auto"></iframe>
						<?php 
						}
						else {
							echo "STUDENT IS NOT REGISTERED IN ANY CLASSES";
						}
					?>
					
					</p>
				
				</div>
				
			</center>
			
		</p>
		
	</body>

</html>
<?php
}
?>

<?php

endif;

?>