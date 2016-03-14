<?php
if (empty($_SESSION['user_id'])) {
	header ("Location: /PAL/sso/login.php");
	exit();
}
if ($already_logged_in == false) {
	header ("Location: /PAL/sso/login.php");
}
?>