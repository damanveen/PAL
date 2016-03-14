<?php
$first = $_POST['f_name'];
$last = $_POST['l_name'];
$grade = $_POST['grade'];
$comment = $_POST['comment_id'];
$course = $_POST['course_id'];
$teacher = $_POST['teacher_id'];
$level = $_POST['level_id'];

//echo "<br>" . $first . "<br>" . $last . "<br>" . $grade . "<br>" . $course . "<br>" . $teacher . "<br>" . $level;
/*function bubblesort ($x, $y, $z) {
    $sorted = 0;
    $temp;
    while (!$sorted) {
        $sorted = 1;
        for ($i = 0; $i < $x - 1; $i++) {

        }
    }
}*/


if ($grade == 0) {
	$grade = null;
}
if ($comment == 0) {
	$comment = null;
}
if ($teacher == 0) {
	$teacher = null;
}
if ($level == 0) {
	$level = null;
}
if ($course == 0) {
	$course = null;
}

$sql = "SELECT * FROM students WHERE first LIKE '%$first%' AND last LIKE '%$last%' ORDER BY last";
include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
//echo "<p>SQL-1: $sql</p>";
/*
$sql = "SELECT students.student_id, students.first, students.last, class.class_id, courses.course_code FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
        INNER JOIN class ON student_progress.class_id = class.class_id INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id
        INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id INNER JOIN courses on courses.course_id = class.course_id
        WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade LIKE '%$grade%' 
        AND student_comments.comment_id LIKE '%$comment%' AND progress_report.level_id LIKE '%$level%' AND class.course_id LIKE '%$course%' 
        AND class.teach_id LIKE '%$teacher%'";

include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");*/


/*if ($count_affected == 0) { 
        $sql = "SELECT * FROM students WHERE first LIKE '%$first%' AND last LIKE '%$last%'";
        include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
        die();
        if ($count_affected == 0) {
            $sql = "SELECT * FROM students WHERE students.first LIKE '%$first%' AND last LIKE '%$last%'";  
            include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");  
        }
}*/

/*if ($count_affected != 0) {
    $sql = "SELECT students.student_id, students.first, students.last FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
        INNER JOIN class ON student_progress.class_id = class.class_id INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id
        INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id 
        WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade LIKE '%$grade%' 
        AND student_comments.comment_id LIKE '%$comment%' AND progress_report.level_id LIKE '%$level%' AND student_progress.class_id LIKE '%$course%' 
        AND class.teach_id LIKE '%$teacher%'";
    echo "<p>SQL-2: $sql</p>";
	include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
    if ($count_affected == 0) {
    	echo "NO RESULTS FOUND";
    }    
	foreach ($results as $item) {       
   	   echo "<div id='student_names'><a class='S_names' href = 'student.php?stud_id=$item[student_id]'>" . $item['first'] .' '. $item['last'] . "</a></div>";
    }
}
else {
        echo "NO RESULTS FOUND";
}*/
if ($count_affected != 0) {
	if (!empty($grade)) {
		if (!empty($teacher) && !empty($course) && !empty($comment) && !empty($level)) { //grade, teacher, course, comment, and level are specified
			$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
					INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
					INNER JOIN class ON class.class_id = student_progress.class_id 
					INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id 
					WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
					AND class.teach_id = $teacher AND student_progress.class_id = $course AND progress_report.level_id = $level
					AND student_comments.comment_id = $comment ORDER BY students.last";
		}
		else if (!empty($teacher) && !empty($course) && !empty($comment) && empty($level)) { //grade, teacher, course, comment are specified
			$sql - "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
					INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
					INNER JOIN class ON class.class_id = student_progress.class_id 
					INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id 
					WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
					AND class.teach_id = $teacher AND student_progress.class_id = $course AND student_comments.comment_id = $comment ORDER BY students.last";
		}
		else if (!empty($teacher) && !empty($course) && !empty($level) && empty($comment)) { //grade, teacher, course, and level are specified
			$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
					INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
					INNER JOIN class ON class.class_id = student_progress.class_id 
					WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
					AND class.teach_id = $teacher AND student_progress.class_id = $course AND progress_report.level_id = $level ORDER BY students.last";
		}
		else if (!empty($course)) {
			if (!empty($comment) && !empty($level) && empty($teacher)) { //grade, course, comment, and level are specified
				$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
						INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id
						INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id 
						WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
						AND student_progress.class_id = $course AND progress_report.level_id = $level AND student_comments.comment_id = $comment ORDER BY students.last";
			}
			else if (!empty($teacher) && empty($level) && empty($comment)) { //grade, course, and teacher are specified
				$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
						INNER JOIN class ON class.class_id = student_progress.class_id 
						WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
						AND class.teach_id = $teacher AND student_progress.class_id = $course ORDER BY students.last";
			}
			else if (!empty($level) && empty($teacher) && empty($comment)) { //grade, course, and level are specified
				$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
						INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
						WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
						AND progress_report.level_id = $level AND student_progress.class_id = $course ORDER BY students.last";
			} 
			else if (!empty($comment) && empty($teacher) && empty($level)) { //grade, course, comment are specified
				$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
						INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
						INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id 
						WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
						AND student_comments.comment_id = $comment AND student_progress.class_id = $course ORDER BY students.last";
			}		
			else { //only grade and course is specified
				$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
						WHERE student_progress.class_id = $course AND student_progress.grade = $grade ORDER BY students.last";
			}		
		}	
		else if (!empty($teacher)) { 
			if (!empty($level)) { //grade, teacher, and level are specified
				$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
						INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
						INNER JOIN class ON class.class_id = student_progress.class_id 
						WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
						AND progress_report.level_id = $level AND class.teach_id = $teacher ORDER BY students.last";
			}
			else if (!empty($comment)) { //grade, teacher, and comment are specified
				$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
						INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
						INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
						INNER JOIN class ON class.class_id = student_progress.class_id  
						WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
						AND student_comments.comment_id = $comment AND class.teach_id = $teacher ORDER BY students.last";
			}
			else { //grade, teacher are specified
				$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
						INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
						INNER JOIN class ON class.class_id = student_progress.class_id 
						WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
						AND class.teach_id = $teacher ORDER BY students.last";
			}
		}
		else if (!empty($comment) && !empty($level)) { //grade, comment, and level are specified
			$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
					INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
					INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id 
					WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
					AND student_comments.comment_id = $comment AND progress_report.level_id = $level ORDER BY students.last";
		}
		else if (!empty($level) && empty($teacher) && empty($course) && empty($course)) { //grade and level are specified
			$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
					INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
					WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
					AND progress_report.level_id = $level ORDER BY students.last";
		}
		else if (!empty($comment) && empty($level) && empty($course)) { //only grade and comment are specified
			$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
					INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
					INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
					WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.grade = $grade 
					AND student_comments.comment_id = $comment ORDER BY students.last";
		}
		else { //only grade and 
			$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
					WHERE student_progress.grade = $grade ORDER BY students.last";
		}
	}

    if (empty($grade) && !empty($teacher)) {
        if (!empty($course) && !empty($comment) && empty($level)) { //teacher, course, and comment are specified
            $sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
                    INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
                    INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
                    INNER JOIN class ON class.class_id = student_progress.class_id
                    WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND class.teach_id = $teacher
                    AND student_comments.comment_id = $comment AND student_progress.class_id = $course ORDER BY students.last";
        }
        else if (!empty($level) && !empty($course) && empty($comment)) { //teacher, course, level are specified
            $sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
                    INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
                    INNER JOIN class ON class.class_id = student_progress.class_id
                    WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND class.teach_id = $teacher
                    AND student_progress.class_id = $course AND progress_report.level_id = $level ORDER BY students.last";
        }
        else if (!empty($level) && !empty($comment) && empty($course)) { //teacher, level, and comment are sepcified
        	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
                    INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id
                    INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id 
                    INNER JOIN class ON class.class_id = student_progress.class_id
                    WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND class.teach_id = $teacher
                    AND student_comments.comment_id = $comment AND progress_report.level_id = $level ORDER BY students.last";
        }
        else if (!empty($course) && empty($level) && empty($comment)) { //teacher and course are specified
        	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
                    INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
                    INNER JOIN class ON class.class_id = student_progress.class_id
                    WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND class.teach_id = $teacher AND student_progress.class_id = $course
                    ORDER BY students.last";
        }
        else if (!empty($comment) && empty($level) && empty($course)) { //teacher and comment are specified
        	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
                    INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
                    INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
                    INNER JOIN class ON class.class_id = student_progress.class_id
                    WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND class.teach_id = $teacher
                    AND student_comments.comment_id = $comment ORDER BY students.last";
        }
        else if (!empty($level) && empty($comment) && empty($course)) { //teacher and level are specified
        	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
                    INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
                    INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
                    INNER JOIN class ON class.class_id = student_progress.class_id
                    WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND class.teach_id = $teacher
                    AND progress_report.level_id = $level ORDER BY students.last";
        }
        else if (empty($course) && empty($comment) && empty($level)) { //only teacher is specified
        	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
                    INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
                    INNER JOIN class ON class.class_id = student_progress.class_id
                    WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND class.teach_id = $teacher ORDER BY students.last";
        }
    }
    else if (!empty($course)) {
    	if (!empty($comment) && !empty($level) && empty($teacher) && empty($grade)) { //course, level, and comment are specified
	    	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
	                INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
	                INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
	                WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.class_id = $course
	                AND student_comments.comment_id = $comment AND progress_report.level_id = $level ORDER BY students.last";
        }
        else if (!empty($comment) && empty($level) && empty($teacher) && empty($grade)) { //course and comment are specified
	    	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
	                INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
	                INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
	                WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.class_id = $course
	                AND student_comments.comment_id = $comment ORDER BY students.last";
	    }
	    else if (!empty($level) && empty($comment) && empty($teacher) && empty($grade)) { //course and level are specified
	    	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
	                INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
	                WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.class_id = $course
	                AND progress_report.level_id = $level ORDER BY students.last";
        }
        else if (empty($level) && empty($comment) && empty($teacher) && empty($grade)) { //only course is specified
        	$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
	                INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
	                WHERE students.first LIKE '%$first%' AND students.last LIKE '%$last%' AND student_progress.class_id = $course ORDER BY students.last";
        }
    }
    else if (!empty($comment) && !empty($level) && empty($teacher) && empty($grade)) { //comment and level are specified
    		$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
	                INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
	                INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
	                WHERE student_comments.comment_id = $comment AND progress_report.level_id = $level ORDER BY students.last";
    }
    else if (!empty($level) && empty($comment) && empty($teacher) && empty($grade)) { //only level is specified
    		$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
	                INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
	                WHERE progress_report.level_id = $level ORDER BY students.last";

    }
    else if (!empty($comment) && empty($grade) && empty($level) && empty($teacher) && empty($course)) {
    		$sql = "SELECT students.first, students.last, students.student_id FROM students INNER JOIN student_progress ON students.student_id = student_progress.student_id
	                INNER JOIN progress_report ON progress_report.progress_id = student_progress.progress_id 
	                INNER JOIN student_comments ON student_comments.Scomment_id = progress_report.Scomment_id
	                WHERE student_comments.comment_id = $comment ORDER BY students.last";
	}

   //echo "<p>$sql</p>";
    include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
    


        if ($count_affected == 0) {
            echo "NO RESULTS FOUND";
        }
    


    foreach ($results as $item) {       
       echo "<div id='student_names'><a class='S_names' href = 'student.php?stud_id=$item[student_id]'>" . $item['last'] .', '. $item['first'] . "</a></div>";
    }
}
else {
    echo "NO RESULTS FOUND";
}
?>
