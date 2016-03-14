<?php
include($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/connect.php");

if($_POST) {
	$q=$_POST['search']; //recieves information from livesearch.php from user input live
	$sql = "SELECT student_id,first,last FROM students WHERE first like '%$q%' OR last like '%$q%' ORDER BY student_id LIMIT 5";
	include($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php"); //executes SQL command query
	while ($row = $results -> fetch(PDO::FETCH_ASSOC)) { //fetches a row from $results
		$f_name = $row['first'];
		$l_name = $row['last'];
		$stud_id = $row['student_id'];
?>
<a class="S_names" href = "student.php?stud_id=<?php echo $stud_id ?>">
	<div class = "show" >

		<?php echo $f_name; ?><?php echo " " . $l_name;?><br/>
	</div>
	</a>
<?php
	}
}
?>