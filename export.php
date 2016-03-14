<?php
include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/gatekeeper.php'); //checks if user is logged on 
include($_SERVER['DOCUMENT_ROOT'].'/PAL/php/user_session_check.php'); //checks if user is logged on
if(userAllowedAccess($sso_pdo, "sso_admin")) :
?>
<html>
	<title>Export/Import</title>		<!-- Name of site page in tab -->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="HomePage.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="/PAL/javascript/optionsTab.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/PAL/javascript/popup.js"></script>
		
		
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
					
						Export/Import Data
						<div id="exportPrint">
						<form action="/PAL/php/pdf/report_card_maker.php">
						<button id = "printAll" type = "submit"></button>
						</form>
						</div>
						
					</p>
				
				</div>
			
				<div class="content">
				
					<div id="importInformation">
					
						<div id="importTitle">
						
							Import
						
						</div>
					
						<div  id="import">
						
							<p><h3>RULES:</h3></p>
							<p>1. There must be 3 files uploaded to avoid data confliction</p>
							<p>2. All files must be a csv files</p>
							<p>3. Each file must be 1mb or smaller to meet the file restriciton for various reasons</p>
							<p>4. Each csv file must have 2 or more set of data</p>
							<form enctype="multipart/form-data" action="/PAL/php/file/uploader.php" method="POST">
								<input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <!-- can store 1mb files -->
								Teacher Information: <input name="file_teacher" type="file" /><a onmouseover="nhpup.popup('legal_first_name,legal_surname,staff_no,class_code,school_year,school_name', {width:500});">more info</a><br />
								Class Information: &nbsp &nbsp <input name="file_class" type="file" /><a onmouseover="nhpup.popup('school_year,class_code,room_no,class_full_name,school_name,semester,term,block, reporting_teacher,teacher_gender,course_code,course_title,course_grade', {width:560});">more info</a><br />
								Student Information: <input name="file_student" type="file" /><a onmouseover="nhpup.popup('West Carleton SS,school_year,studentNo,first_name,last_name,oen_number,end_date,class_code', {width:600});">more info</a><br />
								<input type="submit" value="Import" />
							</form>
							
						</div>
					
					</div>
					
					<div id ="exportInformation">
						
						
					
						<div id="exportTitle">	
						
							Export
							
						</div>
						
						<div id="export">
							<?php include $_SERVER['DOCUMENT_ROOT'] . "/PAL/php/file/export/export_csv_files.php"; ?>
							<a id="export" href = "/PAL/php/file/export/wcss_pal-tables.php">wcss_pal-tables</a><br>
							
						</div>
						
					</div>
					
				</div>
			
			</center>
			
		</p>
		
	</body>

</html>

<?php endif;