
	Teacher:
	<select class="mobileProgress" name='teacher_id'>
		<option value='0'>
			All
		</option>
		<?php
			$i = 0;
			$sso_sql = "SELECT * FROM users WHERE usergroups LIKE '%teacher%' ORDER BY last_name ";
				include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/sso-sql.php");
				 
				 while ($item = $results_sso -> fetch(PDO::FETCH_ASSOC)) {
					$teacher_list[] = array ('id' => $item['id'], 'first_name' => $item['first_name'], 'last_name' => $item['last_name']);
				 } //retrieves all available teachers in the database

			foreach ($teacher_list as $item) {
				echo "	
						<option value = '" . $item['id'] . "'>
							" . $item['first_name'] . " " . $item['last_name'] . "
						</option>
							
					";			
				$i++;
				
				}
		?>
	</select>
