<?php
/*
Purpose: To process all data from the temp tables to its appropiate tables. Basically, it retrieves nessecary data
PROBLEM: ANY TEACHER THAT HAVE DIFFERENT LAST NAME BETWEEN RIDE AND MAMA WILL NOT BE IMPORTED INTO THE PAL DATABASE
*/
include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/database.php'); //connects to sso database
/*Adds non-registered courses into the database*********************/
$sql = "SELECT temp_classes.class_code, temp_classes.course_title FROM temp_classes
		INNER JOIN temp_students ON temp_students.class_code = temp_classes.class_code
		WHERE temp_classes.reporting_teacher != 'NULL'"; 
		//THE SQL RETRIEVES class_code and class_title from temp_classes for classes that have reporting teachers and have students registered in the class
include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php'); 
while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
  $class_codes[] = array('course_code' => $item['class_code'], 'course_name' => $item['course_title']);
}

foreach ($class_codes as $class_code) { 
	$sql = "SELECT course_code, course_name FROM courses 
			WHERE courses.course_code = '$class_code[course_code]'";
	include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php'); 
	echo "<p>$sql</p>";
	$course = $results -> fetch(PDO::FETCH_ASSOC);
	if ($count_affected == 0) {
		$sql = "INSERT INTO courses (course_code, course_name) VALUES ('$class_code[course_code]', '$class_code[course_name]')";
		//echo "<p><h3>$sql</h3></p>";
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php'); 
	}
}
/********************************************************************/

/*Adds a year entree if there is an unknown year entry***************/
$sql = "SELECT school_year, semester FROM temp_classes";
include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php'); 
while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
  $years[] = array('year' => $item['school_year'], 'sem' => $item['semester']);
}
foreach ($years as $year) { 
	$year_start = substr($year['year'], 0, 4);
	$year_end = substr($year['year'], 4, 8);
	$sql = "SELECT year_start, year_end, sem FROM year 
			WHERE  year_start = $year_start AND year_end = $year_end AND sem = $year[sem]";
	include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php'); 
	//echo "<p>$sql</p>";
	if ($count_affected == 0 && $year['sem'] != "NULL") {
		//exit();
		$sql = "INSERT INTO year (year_start, year_end, sem, default) VALUES ('$year_start', '$year_end', '$year[sem]', '0')";
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');
		//echo "<p><h3>$sql</h3></p>";
	}
}
/********************************************************************/


/*Add class to the database********************************************/
$sql = "SELECT school_year, class_code, semester, block, reporting_teacher, course_title FROM temp_classes"; //retrieve class information to import
include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php'); 
while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
	$class_process_import[] = array('year' => $item['school_year'], 'course_code' => $item['class_code'], 'course_name' => $item['course_title'],
									'sem' => $item['semester'], 'block' => $item['block'], 'teacher' => $item['reporting_teacher']);
}
$count_affected = 0; 
foreach ($class_process_import as $import) {
	$year_start = substr($import['year'], 0, 4);
	$year_end = substr($import['year'], 4, 8);
	//$import_name = explode(', ', $import['teacher'], 2);
	list($last_import, $first_import) = explode(', ', $import['teacher'], 2);
	//print_r($import_name);
	if ($import['block'] == 'A') {
		$block = 1;
	}
	else if ($import['block'] == 'B') {
		$block = 2;
	}
	else if ($import['block'] == 'C') {
		$block = 3;
	}
	else if ($import['block'] == 'D') {
		$block = 4;
	}
	//sql is trying to retrieve the staff_no from temp_teachers to link as wcss_sso.users.id
	$sql = "SELECT temp_teachers.staff_no FROM temp_teachers WHERE temp_teachers.legal_first_name LIKE '%$first_import%' AND 
	        temp_teachers.legal_surname LIKE '%$last_import%' AND temp_teachers.class_code = '$import[course_code]'";
	include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');
	echo "<p>$sql</p>"; 
	$staff_no = $results -> fetch(PDO::FETCH_ASSOC);    
	//print_r($staff_no);exit();  
	if ($count_affected != 0) { 
		//SQL below is to find out if the class already currently exists
		$sql = "SELECT class.class_id FROM class
					INNER JOIN courses ON courses.course_id = class.course_id
					INNER JOIN year ON year.year_id = class.year_id
					WHERE class.period = $block AND year_start = $year_start 
					AND courses.course_code = '$import[course_code]' AND year.sem = $import[sem] AND class.teach_id = $staff_no[staff_no]";
		echo "<p><h1>$sql</h1></p>";
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');		
		echo "<h2>$count_affected</h2>";
		if ($count_affected == 0) { 
			$sql = "SELECT year.year_id FROM year WHERE year.year_start = $year_start AND year.year_end = $year_end AND year.sem = $import[sem]";
			include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');		
			$import_year_class = $results -> fetch(PDO::FETCH_ASSOC);
			$sql = "SELECT course_id FROM courses WHERE courses.course_code = '$import[course_code]' AND courses.course_name = '$import[course_name]'";
			include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');
			$import_course_class = $results -> fetch(PDO::FETCH_ASSOC);
			echo "<p>$sql<p>";
			echo "<p><h3>course_id: $import_course_class[course_id]</h3><p>";
			if (!empty($import_course_class['course_id']) && $import_course_class['course_id'] != 0 && $count_affected != 0) { 
				$sql = "INSERT INTO class (teach_id, course_id, year_id, period) 
						VALUES ('$staff_no[staff_no]', '$import_course_class[course_id]', '$import_year_class[year_id]', '$block')";
				echo "<p><h3>$sql</h3></p>";
				include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
			}
		}
	}
	else {//this is just to counter measure the incorrect last name
		$sql = "SELECT temp_teachers.staff_no FROM temp_teachers 
				WHERE temp_teachers.legal_surname LIKE '%$last_import%' AND temp_teachers.class_code = '$import[course_code]'";
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');
		$staff_no = $results -> fetch(PDO::FETCH_ASSOC);    
		if ($count_affected != 0) {
			$sql = "SELECT class.class_id FROM class
					INNER JOIN courses ON courses.course_id = class.course_id
					INNER JOIN year ON year.year_id = class.year_id
					WHERE class.period = $block AND year_start = $year_start 
					AND courses.course_code = '$import[course_code]' AND year.sem = $import[sem] AND class.teach_id = $staff_no[staff_no]";
			echo "<p><br><br><h1>TTEESSSST$sql</h1></p>";
			include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');		
			if ($count_affected == 0) { 
				$sql = "SELECT year_id FROM year WHERE year_start = $year_start AND year_end = $year_end AND sem = $import[sem]";
				include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');		
				$import_year_class = $results -> fetch(PDO::FETCH_ASSOC);
				$sql = "SELECT course_id FROM courses WHERE courses.course_code = '$import[course_code]' AND courses.course_name = '$import[course_name]'";
				include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');
				if (!empty($import_course_class['course_id']) && $import_course_class['course_id'] != 0 && $count_affected != 0) { 
					$import_course_class = $results -> fetch(PDO::FETCH_ASSOC);
					$sql = "INSERT INTO class (teach_id, course_id, year_id, period) 
							VALUES ('$staff_no[staff_no]', '$import_course_class[course_id]', '$import_year_class[year_id]', '$block')";
					echo "<p><h3>$sql</h3></p>";
					include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
				}
			}
		}
	}
	$count_affected = 0;
}
/*************************************************************************/
/*ADD STUDENT TO THE DATABASE AND REGISTER EACH STUDENT A PROGRESS REPORT CARD WITH DEFAULT VALUES*********************/

//ADD STUDENT INTO STUDENT LIST
$sql = "SELECT * FROM temp_students";
include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
	$students[] = array('oen' => $item['oen_number'], 'first' => $item['first_name'], 'last' => $item['last_name'], 'course_code' => $item['class_code'], 
						'year' => $item['school_year']);
}
foreach ($students as $student_import) {
	$count_affected = 1;
	$sql = "SELECT students.student_id FROM students INNER JOIN student_info ON students.student_id = student_info.student_id
			WHERE students.first = '$student_import[first]' AND students.last = '$student_import[last]' AND student_info.stud_num = $student_import[oen]";
	//echo "<p><b>$sql</b></p>";
	include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
	if ($count_affected == 0) {
		$sql = "SELECT MAX(student_id) FROM students";
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
		$stud_id_temp = $results-> fetch(PDO::FETCH_ASSOC); 
		$stud_id = $stud_id_temp['MAX(student_id)'] + 1;
		$sql = "INSERT INTO students (student_id, first, last) VALUES ($stud_id,'$student_import[first]', '$student_import[last]');";
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-non_query-sql.php');
		echo "<p><b>$sql</b></p>";
		$sql = "INSERT INTO student_info (student_id, stud_num) VALUES ($stud_id, '$student_import[oen]') ";
		echo "<p>$sql</p>"; 
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-non_query-sql.php');
	}
}
/**********************************************************************************************************************/
$stud_id = NULL;
/*REGISTER STUDENT INTO CLASSES****************************************************************************************/
$sql = "SELECT * FROM temp_students";
include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
			   $student_class_import[] = array('year' => $item['school_year'], 'first' => $item['first_name'], 'last' => $item['last_name'], 
			   'oen' => $item['oen_number'], 'course_code' => $item['class_code']);
}
/*
If you place the max progress_id and Scomment_id here and in the loop to increment, then the code would be more efficient
But currently the import is still in developing stages. Therefore, data can be messed up.
*/

foreach ($student_class_import as $student) { 
	$year_start = substr($student['year'], 0, 4);
	$sql = "SELECT student_progress.progress_id FROM student_progress INNER JOIN students ON students.student_id = student_progress.student_id
			INNER JOIN class ON class.class_id = student_progress.class_id INNER JOIN courses ON courses.course_id = class.course_id 
			INNER JOIN year ON class.year_id = year.year_id INNER JOIN student_info ON students.student_id = student_info.student_id
			WHERE student_info.stud_num = '$student[oen]' AND students.last = '$student[last]' AND year.year_start = $year_start 
			AND courses.course_code = '$student[course_code]'";
			include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
	echo "<p>$sql</p>";
	if ($count_affected == 0) {
		$sql = "SELECT students.student_id FROM students INNER JOIN student_info ON student_info.student_id = students.student_id
				WHERE student_info.stud_num = $student[oen]";
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
		$stud_id = $results -> fetch(PDO::FETCH_ASSOC);
		$sql = "SELECT class.class_id, year.year_id, year.sem FROM class 
				INNER JOIN year ON year.year_id = class.year_id INNER JOIN courses ON courses.course_id = class.course_id
				WHERE courses.course_code = '$student[course_code]' AND year.year_start = $year_start";
		echo "<p>$sql</p>";
		include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
		if ($count_affected != 0) {
			$year_info = $results -> fetch(PDO::FETCH_ASSOC);
			$sql = "SELECT MAX(progress_id) FROM student_progress";
			include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
			$progress_id_temp = $results -> fetch(PDO::FETCH_ASSOC);
			$progress_id = $progress_id_temp['MAX(progress_id)'] + 1;
			$sql = "INSERT INTO student_progress (class_id, student_id, progress_id, grade, year_id, sem) 
					VALUES ($year_info[class_id], $stud_id[student_id], $progress_id, '',$year_info[year_id], $year_info[sem])";
			include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
			echo "<p><h1>$sql</h1></p>";
			$sql = "SELECT MAX(Scomment_id) FROM progress_report";
			include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
			$Scomment_id_temp = $results -> fetch(PDO::FETCH_ASSOC);
			$Scomment_id = $Scomment_id_temp['MAX(Scomment_id)'] + 1; 
			$sql = "INSERT INTO progress_report (progress_id, level_id, interview_request	, Scomment_id) VALUES ($progress_id, 1, 0, $Scomment_id)";
			include ($_SERVER['DOCUMENT_ROOT'].'/PAL/php/pal-sql.php');	
			echo "<p><b>$sql</b></p>";
		}
	}
}
/**********************************************************************************************************************/
?>