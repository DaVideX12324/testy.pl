	   <?php session_start(); 
if(!isset($_SESSION['user_e-mail']))
{
	header('Location: login.php');
}
?>


<!DOCTYPE html><html  lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/rej.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger.css"> 
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Usuwanie konta</title>
		

	</head>

	<body>
	<div id="strona">
		<div id="head">
			<a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
			<nav>
			</nav>
		</div>	
		<div id="main">
			<div id="rejestracja">
				<table id="rej_tab"><tr><td>
					<fieldset id="rej_field">
						<legend id="rej_leg">Stan:</legend>
						
							<?php
								$pol=mysqli_connect('localhost','root','','projekt');
								$e_mail=$_SESSION["user_e-mail"];
								$has=$_POST['aktualne_has'];
								$md5=md5($has);

								$czy="SELECT `haslo` FROM `konta` WHERE `e-mail`='$e_mail';";
								$czy_que=mysqli_query($pol,$czy);
								$czy_fet=mysqli_fetch_array($czy_que);

								if($md5==$czy_fet[0])
								{
									$mail=$_POST['zmiana_mail'];
									$e_mail=$_SESSION["user_e-mail"];
										
									$pol=mysqli_connect("localhost","root","","projekt");
									$zap="delete from `konta` where `e-mail`='$e_mail'";

										mysqli_query($pol,$zap);
										echo '<h2>Pomyślnie usunięto konto</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br>';
										session_destroy(); 
									
									mysqli_close($pol);
								}
								else
								{
									echo '<h2>Hasło jest błędne</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br>
											<a href="testy.php" style="text-decoration:none" class="zal">Konto</a>';
								}		
								?>
						</fieldset>	
					
				</td></tr></table>	
			</div>		
		</div>	
	</div>
	</body>
</html>
