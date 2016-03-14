
	Course:
	<select class="mobileProgress" name = "course_id">
		<option value='0'>
			All
		</option>
		<?php
			$i = 0;
			$sql = "SELECT class.class_id, courses.course_code FROM class INNER JOIN courses ON courses.course_id = class.course_id";
				include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
				 
				 while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
					$course_list[] = array ('course_id' => $item['class_id'], 'course_code' => $item['course_code']);
				 } //retrieves all available courses in the database

			foreach ($course_list as $item) {
				echo "	
						<option value = '" . $item['course_id'] . "'>
							" . $item['course_code'] . "
						</option>
							
					";			
				$i++;
				
				}
		?>
	</select>
