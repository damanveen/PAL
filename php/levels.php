<?php
$sql = "SELECT * FROM level";

include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");

foreach ($results as $list) {
		$level_data[] = array ("level_id" => $list['level_id'] ,  "level" => $list['level']);
}
?>