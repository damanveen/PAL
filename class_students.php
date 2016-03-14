<?php

	include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/gatekeeper.php'); //checks if user is logged on 
	include($_SERVER['DOCUMENT_ROOT'].'/PAL/php/user_session_check.php'); //checks if user is logged on

	$class_id = htmlspecialchars($_GET['class_id']); //htmlspecialchars prevents script injection
	$class = htmlspecialchars($_GET['class']); //htmlspecialchars prevents script injection
	if (empty($class_id) OR empty($class)) {
		header ('Location: http://dev.emmell.org/PAL/allClasses.php');
	}
	include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/teacher-security.php"); //prevents other teachers to have access to other teacher's classes
	if(userAllowedAccess($sso_pdo, "teacher") OR userAllowedAccess($sso_pdo, "sso_admin")) :
?>

<html>
	
	<title>My Classes</title>		<!-- Name of site page in tab -->

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href= "HomePage.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="/PAL/javascript/optionsTab.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
		
		
		<?php include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/javascript/color.php"); ?>
	
	</head>

	<body>
		
		<p> 	
			
			<?php 
				
				include($_SERVER['DOCUMENT_ROOT'] . "/PAL/includes/toolbar.php");
				include($_SERVER['DOCUMENT_ROOT'] . "/PAL/includes/optionsTab.php");
				
			?>
			
			<center>
			
				<div class="subtitle">
				
					<p id="sClass" class="subtitle_title">
		
						<?php echo $class; ?>
					
					</p>
					
					<form name ="print" action="/PAL/php/pdf/print_class_pdf.php" method = "POST">
						<input type = "hidden" name = 'class_id' value = '<?php echo $class_id?>'>
						<button type="submit" class = "mobile" id="printButton"></button>
					</form>
					
				
				</div>
				
				<div class="content">
		
					<p id="allClasses">
						
						<div id="S_title"><b> STUDENTS</b></div>
							<?php
								if ($teacher_security_valid == 1) {

									include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/class_students_info.php"); //retrieves teacher's students in a specific class
									foreach ($results as $item) {
									if ($item['level_id'] != 1) {
										echo "<div id='student_names'><a class='S_names' href = 'student_report.php?stud_id=$item[student_id]&class=$class_id'>&#10004;" . $item['last'] . ", " . $item['first'] . "</a></div>";
									}
									else{
										echo "<div id='student_names'><a class='S_names' href = 'student_report.php?stud_id=$item[student_id]&class=$class_id'>" . $item['last'] . ", " . $item['first'] . "</a></div>";
									}
								}
								}
								else {
									echo "You do not have permission to edit students in this class";
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