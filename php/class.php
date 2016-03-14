<?php
//Purpose: Displays all the classes that the teacher teaches

$id = $_SESSION['user_id']; //user id retrieved from a session variable

include($_SERVER["DOCUMENT_ROOT"]."/PAL/php/check-teacher_class.php"); //checks if teacher has any registered classes for the default time

if ($class_teacher_valid == 1) {
	$sql= "SELECT wcss_pal.courses.course_code, wcss_pal.class.course_id, wcss_pal.class.class_id,wcss_sso.users.first_name, wcss_sso.users.last_name
	      FROM wcss_pal.class INNER JOIN wcss_sso.users ON wcss_pal.class.teach_id = wcss_sso.users.id
	      INNER JOIN wcss_pal.courses ON wcss_pal.courses.course_id = wcss_pal.class.course_id
	      INNER JOIN wcss_pal.year ON wcss_pal.year.year_id = wcss_pal.class.year_id
	      WHERE wcss_pal.class.teach_id = $id AND wcss_pal.year.default = 1 ORDER BY wcss_pal.class.period";

	include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/database.php'); //connects to sso database
	include($_SERVER["DOCUMENT_ROOT"]."/PAL/php/pal-sql.php"); //runs sql query and connection to PAL Db
	foreach ($results as $item) {
		$info[] = array('first_name' => $item['first_name'], 'last_name' => $item['last_name'], 'class' => $item['course_code'], 'class_id' => $item['class_id']);
	}
}

?>