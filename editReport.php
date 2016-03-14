<?php
	include($_SERVER['DOCUMENT_ROOT'].'/sso/lib/gatekeeper.php'); //checks if user is logged on 
	include($_SERVER['DOCUMENT_ROOT'].'/PAL/php/user_session_check.php'); //checks if user is logged on
	if(userAllowedAccess($sso_pdo, "sso_admin")) :
?>

<html>
	<title>Edit Report</title>		<!-- Name of site page in tab -->
	
	<head>		<!-- Calling all javascript, jquery and css files in the head-->
		<meta name="viewport" content="width=device-width, initial-scale=0.4, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="HomePage.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="/PAL/javascript/optionsTab.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
	
		<?php include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/javascript/color.php"); ?>
			
		<script>
			$(document).ready(function(){
				$("#add").hide();
				$("#add_button").click(function(){
					$("#add").toggle();
				});
			});
		</script>
	
	</head>

	<body>
	
		<p> 	
			
			<?php 
				
				include('includes/toolbar.php');
				include('includes/optionsTab.php');
				
			?>
			
			<center>
			
				<div class="subtitle">
				
					<p class="subtitle_title">
					
						Edit Report
					
					</p>
				
				</div>
			
				<div class="content">
				
					<div id="headerInformation">
					
						<div id="headerTitle">	
						
							Header Information
							
						</div>
						
						<div id="header">
						
							<form action="/PAL/php/header.php" method = 'POST'>
								
								Title:	<input class="mobileProgress" type="text" name="title" placeholder="Progress Report Card"><br>
								School:	<input class="mobileProgress"  type="text" name="schoolName" placeholder="School Name"><br>	
								Street Address:	<input class="mobileProgress"  type="text" name="streetAddress" placeholder="123 example road"><br>	
								Address: <input class="mobileProgress"  type="text" name="location" placeholder="Dunrobin, Ontario, Canada"><br>	
								Postal Code:	<input class="mobileProgress"  type="text" name="postalCode" placeholder="1A2 B3C"><br>								
								<input class="mobileProgress"  type="submit" value="Submit">
								
							</form>
							
						</div>
						
						<table id="headerExample">	
						
							<td>						
								<?php							
									$sql = "SELECT * FROM header";
									include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
									 
									 while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
										$header[] = $item['content'];
										echo $item['content'];
										echo"<br>";											
									 }									
								?>							
							</td>
							
						</table>
						
					</div>	
				
					<div id="footerInformation">
					
						<div id="footerTitle">
						
							Footer Information
							
						</div>
						
						<div id="footer">
							
							<?php
								$sql = "SELECT * FROM footer";
								include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
								 
								 while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
									$footer[] = $item['content'];										
								 }									
							?>
							
							<form action="/PAL/php/footer.php" method="POST">
							
								Message:<br><textarea class="mobileProgress" id="fMess" name = 'message' rows="6" cols="40" ><?php echo $footer[0] ?></textarea>
								<br></br>
								Footer:<br><textarea class="mobileProgress" id="fMess" name = 'footer' rows="6" cols="40" ><?php echo $footer[1] ?></textarea>		
								<br></br>
								<input class="mobileProgress" type="submit" value="Submit">
								
							</form>
							
							
						</div>
							
						
						
						<table id="footerExample">	
						
							<td>						
								<?php							
									echo $footer[0] . "<br>";
									echo $footer[1] . "<br>"; 								
								?>							
							</td>
							
						</table>
						
					</div>
				
					
					<div id="editComments">
				
						<div id="editCommentsTitle">
					
							Edit Comments
							
						</div>
						
						<div id="comments">

							<?php						
								$sql = "SELECT * FROM comments";
								include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
								 
								 while ($item = $results -> fetch(PDO::FETCH_ASSOC)) {
									$comments[] = array('comment_id' => $item['comment_id'], 'comment' => $item['comment']);										
								 }									
							?>
							
							<form action="/PAL/php/editComments.php" method="POST">
							
								<?php
									$count = 0; //tells the amount of comments there are currently are in the database 
									foreach($comments as $item){
										//echo "<input name='comment[]' value='$item[comment]'>";
										echo "<input class ='mobileProgress' id='commentWidth' name='comment[]' placeholder ='$item[comment]'>";
										echo "<input type = 'hidden' name = 'update_id[]' value = '$item[comment_id]'>";
										echo "</input>";
								?>
								
								<a href = "/PAL/php/delete_comment.php?delete=<?php echo $item['comment_id']; ?>"><button class ='mobileProgress' type = 'button'>X</button></a>
								
								<?php 
									echo "<br></br>";
									$count++;}
								?>
								
								<button type = 'button' class ='mobileProgress' id = 'add_button'>Add Button</button><br>
								<p><input id = 'add' class ='mobileProgress' name = 'new_comment' placeholder = 'New Comment'></p>
								
								<?php
									$sql = "SELECT MAX(comment_id) FROM comments;";
									include ($_SERVER['DOCUMENT_ROOT'] . "/PAL/php/pal-sql.php");
									$count = $results->fetch(PDO::FETCH_ASSOC);
									//print_r($count);
								?>
								
								<input type = 'hidden' name = 'count' value = '<?php echo $count['MAX(comment_id)']; ?>'></input>
								<input class ='mobileProgress' type="submit" value="Submit">
								
							</form>
													
						</div>
					
					</div>
				
				</div>
			
			</center>
			
		</p>
		
	</body>

</html>

<?php endif;