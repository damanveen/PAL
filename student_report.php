<?php
include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/gatekeeper.php'); //checks if user is logged on 
include($_SERVER['DOCUMENT_ROOT'].'/PAL/php/user_session_check.php'); //checks if user is logged on

$stud_id = $_GET['stud_id'];
$class_id = $_GET['class'];

include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/student_valid.php"); //prevents other teachers from editing student's report card
include ($_SERVER["DOCUMENT_ROOT"] . "/PAL/php/report_info.php"); //gathers all revelant student information about their progress report card


if(userAllowedAccess($sso_pdo, "teacher") OR userAllowedAccess($sso_pdo, "sso_admin")) :

?>
<!DOCTYPE html>

<html>
	<title>Student Info</title>		<!-- Name of site page in tab -->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="/PAL/HomePage.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="/PAL/javascript/optionsTab.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
		
		
		<?php include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/javascript/color.php"); ?>
	
		<script>		/*This script limits the number of checkboxes that can be clicked*/
			function checkboxlimit(checkgroup, limit){
				for (var i=0; i<checkgroup.length; i++){
					checkgroup[i].onclick=function(){
					var checkedcount=0
					for (var i=0; i<checkgroup.length; i++)
						checkedcount+=(checkgroup[i].checked)? 1 : 0
					if (checkedcount>limit){
						alert("You can check a maximum of "+limit+" boxes.")
						this.checked=false
						}
					}
				}
			}

		</script>
		<style>		<?php // style for the in browser pdf preview ?>
		
		</style>
	</head>

	<body> 
	
		<p> 	
			
			<?php //This displays the menu 
				
				include($_SERVER['DOCUMENT_ROOT'] . "/PAL/includes/toolbar.php");
				include($_SERVER['DOCUMENT_ROOT'] . "/PAL/includes/optionsTab.php");
				
			?>
			
			<center>
			
				<div class="subtitle">
					<div id ="bfButton">
					<?php
					
					include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/class_student_list.php");
							if ($students[0] != $stud_id) { 
								for ($aa = 0; $aa < $count_affected; $aa++) {
									if ($students[$aa] == $stud_id) {
										$next_student = $aa - 1;
										$aa = 999;
									}
								}
								echo "<div id = 'bButton'><a href = 'student_report.php?stud_id=$students[$next_student]&class=$class_id'>Back</a></div>";
							}
					
					if ($students[$count_affected-1] != $stud_id) { 
								for ($aa = 0; $aa < $count_affected; $aa++) {
									if ($students[$aa] == $stud_id) {
										$next_student = $aa + 1;
										$aa = 999;
									}
								}
								echo "<div id= 'fButton'><a href = 'student_report.php?stud_id=$students[$next_student]&class=$class_id'>Next</a></div>";
							}
							
					?>
					</div>
					
					
					
						<h3 class="subtitle_title" Id="progTitle">
						<?php
							

							if ($report_valid == 1) {
								echo "<div id='classLink'><b><a href = 'http://dev.emmell.org/PAL/class_students.php?class_id=$class_id&class=$info[course_code]'>" . $info['course_code']  . "</a></b><div id='name'>" . " - " . $info['last'] . ", " . $info['first'];
								echo "</div></div>";
							 }
							 
						 ?>
						 </h3>
					
					<form name ="print" action="/PAL/php/pdf/student_pdf_report_card.php" method = "GET">
						<input type = "hidden" name = 'stud_id' value = '<?php echo $stud_id?>'>
						<button type="submit" class="progUp" id="printButton"></button>
					</form>
					
				</div>
				
				<div id = "incase">
								
				<div class="content" id = "s_list" style="text-align: left;">
				<?php
					include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/class_students_info.php"); //retrieves teacher's students in a specific class
					foreach ($results as $item) {
						if ($item['level_id'] != 1) {						
							echo "<a class='s_list' href = 'student_report.php?stud_id=$item[student_id]&class=$class_id'>" . $item['last'] . ", " . $item['first'] . "&nbsp;&nbsp;&#10004;</a><br/>";		//adds check mark if student progress is complete
						}
						else {
							echo "<a class='s_list' href = 'student_report.php?stud_id=$item[student_id]&class=$class_id'>" . $item['last'] . ", " . $item['first'] . "</a><br/>";
						}
					}
				?>
			</ul>	
				</div>
				
				<div class="content" id ="p_list">
				
					<p id="home">
													
								<?php
									if ($report_valid == 1) { 
										?>
										
										<div id="sPic">
										<?php
										/*Student Picture***********************************************************/
								        $sql = "SELECT stud_num FROM student_info WHERE student_id = $stud_id";
								        include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");  
								        $picture = $results -> fetch(PDO::FETCH_ASSOC);
								        $picture['stud_num'] .= ".jpg";
								        $picture_location = "/PAL/images/studentPics/" . $picture['stud_num'];  
								        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $picture_location) != 0) {
								          echo "<img src = '" . $picture_location . "'>";
								        }
								        else { 
								          echo "<img src = '" . '/PAL/images/studentPics/Blank.jpg' . "'>";
								        }
								        /***************************************************************************/
										?>
										
										</div>
										
									<?php
									
										
						
									}
									if ($student_valid == 1) { 
										include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/levels.php"); 
										echo "<form name='comment' id='ProgressForm' action = 'php/progress_update.php' method = 'POST'> 
											  <b class='mobileProgress'>Progress:</b> <select class='mobileProgress' name = 'level'>";
							
										foreach ($level_data as $level) {
											if ($info['level'] == $level['level']) {
												echo "<option  value = '$level[level_id]' selected>$level[level]</option>";
											}
											else { 
												echo "<option  value = '$level[level_id]'>$level[level]</option>";
											}
										}
										echo "</select>
											  <p class='mobileProgress'><b>PROGRESS COMMENT</b></p>";
										
										include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/checkbox_comments.php"); //retrieves all available comments in the database
									}
					  
								?>
								
					    	<input type = 'hidden' name = 'Scomment_id' value = '<?php echo $info['Scomment_id']; ?>'>
					    	<input type = 'hidden' name = 'progress_id' value = '<?php echo $info['progress_id']; ?>'>
					    	<input type = 'hidden' name = 'student_id' value = '<?php echo $stud_id; ?>'>
					    	<input type = 'hidden' name = 'class_id' value = '<?php echo $class_id; ?>'>

					    	<br><div class='mobileProgress' id = "parent_teacher_interview">
							
					    		Parent Teacher Interview:<br>	
								<?php 
									$interview_request_no = "<label id ='yes_no' for ='yes_no'><input style='width:25px; height:25px;' id = 'yes_no' type='radio' name='interview' value='0' required";
									$interview_request_yes = "<label id ='yes_no' for ='no_yes'><input style='width:25px; height:25px;' id = 'no_yes' type='radio' name='interview' value='1' required";
					    			if ($info['interview_request'] == 0) {
					    				$interview_request_no .= " checked";
					    			}
					    			$interview_request_no .= ">No</label><br>";
					    			if ($info['interview_request'] == 1) {
					    				$interview_request_yes .= " checked";
					    			}
					    			$interview_request_yes .= ">Yes</label><br>";
					    			echo $interview_request_yes . $interview_request_no;
					    		?>
					    	</div>
					    	<input  class='mobileProgress' id="progSub" type = 'submit' value = 'submit'>
					    </form>
						
						
						
						<script>
							checkboxlimit(document.forms.comment['comment_id[]'], 5);		//checks to make sure teachers can choose a max of 5 comments
							
						
						</script>
					
					</p>
				
				</div>
			</div>
			</center>
			
		</p>
	</body>

</html>


<?php

endif;

?>
