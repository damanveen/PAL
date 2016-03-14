
	Comments:
	<select class="mobileProgress" name = 'comment_id' required>
		<option value='0'>
			All
		</option>
		<?php
			$i = 0;
			include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/comments.php"); //retrieves all available comments in the database

			foreach ($comment_list as $item) {
				echo "	
						<option value = '" . $item['comment_id'] . "'>"
							 . $item['comment'] . 
						"</option>";			
				$i++;
				
				}
		?>
	</select>
