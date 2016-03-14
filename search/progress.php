
	Progress:
	<select class="mobileProgress" name='level_id'>
		<option value='0'>
			All
		</option>
		<?php
			$i = 0;
			$sql = "SELECT * FROM level";
				include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
				 
				 while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
					$progress_list[] = array ('level_id' => $item['level_id'], 'level' => $item['level']);
				 } //retrieves all available progress options in the database

			foreach ($progress_list as $item) {
				echo "	
						<option value = '" . $item['level_id'] . "'>
							" . $item['level'] . "
						</option>
							
					";			
				$i++;
				
				}
		?>
	</select>
