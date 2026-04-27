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
		<title>Rejestracja ukończona</title>
		

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
									if((isset($_POST['zmiana_mail']))&&($_POST['zmiana_mail'])!=NULL)
									{	
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
											$zap="update `konta` SET `e-mail`='".$mail."' where `e-mail`='$e_mail'";

											$czy2="SELECT EXISTS(SELECT * FROM `konta` WHERE `e-mail`='$mail');";
											$czy2_que=mysqli_query($pol,$czy2);
											$czy2_fet=mysqli_fetch_array($czy2_que);

											if($czy2_fet[0]==0)
											{
												mysqli_query($pol,$zap);
												echo '<h2>Pomyślnie zmieniono adres e-mail</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br>';
												session_destroy(); 
											}
											else
											{		
												
												echo '<h2>E-Mail jest już zapisany w bazie danych</h2><br><br><a class="zal"  style="text-decoration:none" href="login.php">Zaloguj się</a>';
											}
											
											mysqli_close($pol);
										}
										else
										{
											echo '<h2>Hasło jest błędne</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br>
														<a href="testy.php" style="text-decoration:none" class="zal">Konto</a>';
										}		
									}
									if(isset($_POST['zmiana_has']))
									{	
										$pol=mysqli_connect('localhost','root','','projekt');
										$e_mail=$_SESSION["user_e-mail"];
										$has=$_POST['aktualne_has'];
										$md5=md5($has);

										$czy="SELECT `haslo` FROM `konta` WHERE `e-mail`='$e_mail';";
										$czy_que=mysqli_query($pol,$czy);
										$czy_fet=mysqli_fetch_array($czy_que);

										if($md5==$czy_fet[0])
										{

											$n_has=$_POST['zmiana_has'];
											
											$n_md5=md5($n_has);

											$pol=mysqli_connect("localhost","root","","projekt");
											$zap="update `konta` SET  `haslo`='$n_md5' where `e-mail`='$e_mail'";
											mysqli_query($pol,$zap);

												echo '<h2>Pomyślnie zmieniono hasło</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br>';
												session_destroy(); 
											
											mysqli_close($pol);
										}
										else
										{
											echo '<h2>Hasło jest błędne</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br>
														<a href="testy.php" style="text-decoration:none" class="zal">Konto</a>';
										}
									}

								?>
								
								
						</fieldset>	
					
				</td></tr></table>	
			</div>		
		</div>	
	</div>

<script  src="js/hamburger.js"></script>	
</body>
</html>
