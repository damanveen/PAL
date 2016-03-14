<head>
	<title>SSO Login</title>

	<!-- Load default CSS, then check for specialized one -->
	<link href="/sso/css/login.css" rel="stylesheet" type="text/css">
	<link href="login.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
	if(isset($_GET['t']))
	{
		echo '<form name="login" action="/sso/lib/login_process.php?t='.$_GET['t'].'" method="post">';
	}
	else
	{
		echo '<form name="login" action="/sso/lib/login_process.php?t=/PAL/" method="post">';
	}
?>
		<div id="login-box">
		<?php
		if (isset($_GET['p']))
		{
			echo '<b>Insufficient Privileges</b>';
		}
		if(isset($_GET['failed']))
		{
			echo '<h2>Invalid Credentials</h2><br>';
		}
		else
		{
			echo '<h2>Login</h2>';
		}
		?>
		<br><br>
			<label for="username">Username:</label>
			<div class="login-field">
				<input type="text" name="username" id="username" class="text-input" title="Username" value="" size="30" maxlength="30" autofocus>
			</div>

			<label for="password">Password:</label>
			<div class="login-field">
				<input type="password" name="password" id="password" class="text-input" title="Password" value="" size="30" maxlength="30">
			</div>
			<br>

			<div class="login-options">
				<input type="checkbox" name="remember" id="remember" value="0"> Remember Me
				<!-- <a href="#" style="margin-left:30px;">Forgot password?</a> -->
				<br>
				<br>
			<!--	<input type="checkbox" name="guest" id="guest" value="0"> Login as Guest 
				<br>
				<br>	-->
				<input type="submit" name="login" id="login" class="button" value="LOGIN"/>
			</div>
		</div>
	</form>
</body>
