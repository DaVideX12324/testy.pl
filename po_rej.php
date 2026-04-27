<?php session_start(); ?>


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
									
									if((isset($_POST['typ']))&&($_POST['typ']!=NULL)&&(isset($_POST['mail']))&&($_POST['mail']!=NULL)&&(isset($_POST['has']))&&($_POST['has']!=NULL))
									{
										$typ=$_POST['typ'];
										$mail=$_POST['mail'];
										$has=$_POST['has'];
										$imie=$_POST['imie'];
										$nazw=$_POST['nazwisko'];
										$hash = hash('SHA512', $has);
										$pol=mysqli_connect("localhost","root","","projekt");
										$zap="insert into `konta`(`e-mail`,`haslo`,`imie`,`nazwisko`,`typ`) values ('$mail','$hash','$imie','$nazw','$typ')";
										$czy="SELECT EXISTS(SELECT * FROM `konta` WHERE `e-mail`='$mail');";
										$czy_que=mysqli_query($pol,$czy);
										$czy_fet=mysqli_fetch_array($czy_que);
										

										if($czy_fet[0]==0)
										{
											mysqli_query($pol,$zap);
											echo '<h2>Pomyślnie utworzono konto</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br>
													<a href="testy.php" style="text-decoration:none" class="zal">Konto</a>';
											$typ_1="SELECT `typ`,`ID` FROM `konta` WHERE `e-mail`='$mail' AND `haslo`='$hash';";
											$typ_2=mysqli_query($pol,$typ_1);
											$typ=mysqli_fetch_array($typ_2);
											$_SESSION['user_e-mail'] = $mail;
											$_SESSION['user_password'] = $hash;
											$_SESSION['user_typ'] = $typ[0];
											$_SESSION['user_id'] = $typ[1];
										}
										else
										{		
											
											echo '<h2>E-Mail jest już zapisany w bazie danych</h2><br><br><a class="zal"  style="text-decoration:none" href="login.php">Zaloguj się</a>';
										}
										
										mysqli_close($pol);
									}
									else
										{	
											echo '	<h2>Nie wypełniono wszystkich pól</h2><a class="zal"  style="text-decoration:none" href="rejestracja.php">Powrót do rejestracji</a><br><br><br>
												<a href="login.php" style="text-decoration:none" class="zal">Zaloguj się</a>';
										}
									
								?>
								
								
						</fieldset>	
					
				</td></tr></table>	
			</div>		
		</div>	
	</div>
	</body>
</html>
