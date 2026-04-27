<?php session_start(); ?>


<!DOCTYPE html><html  lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/rej.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger.css"> 
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Logowanie zakończone</title>
		
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
				
					<form method="POST" action="po_log.php" id="form">
						<fieldset id="rej_field">
							<legend id="rej_leg">Stan:</legend>
									<?php
									if(isset($_POST['mail'])&isset($_POST['has'])){
									$mail=$_POST['mail'];
									$has=$_POST['has'];
									$hash = hash('SHA512', $has);
									$pol=mysqli_connect("localhost","root","","projekt");
									$czy="SELECT EXISTS(SELECT * FROM `konta` WHERE `e-mail`='$mail' AND `haslo`='$hash');";
									$czy_que=mysqli_query($pol,$czy);
									$czy_fet=mysqli_fetch_array($czy_que);
									$typ_1="SELECT `typ`, `ID` FROM `konta` WHERE `e-mail`='$mail' AND `haslo`='$hash';";
									$typ_2=mysqli_query($pol,$typ_1);
									$typ=mysqli_fetch_array($typ_2);
									if($czy_fet[0]==0)
									{
										echo '<h2>E-Mail lub hasło są błędne</h2><a class="zal"  style="text-decoration:none" href="login.php">Zaloguj się ponownie</a><br><br><br>
												<a href="rejestracja.php" style="text-decoration:none" class="zal">Stworz konto</a>';
									}
									else
									{	
										if($typ[0]=="Egzaminator")
										{
											$_SESSION['user_e-mail'] = $mail;
											$_SESSION['user_password'] = $hash;
											$_SESSION['user_typ'] = $typ[0];
											$_SESSION['user_id'] = $typ[1];
											echo '	<h2>Pomyślnie zalogowano</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br><br>
												<a href="testy.php" style="text-decoration:none" class="zal">Zarządzanie testami</a>';
										} 
										else
										{	
										
											$_SESSION['user_e-mail'] = $mail;
											$_SESSION['user_password'] = $hash;
											$_SESSION['user_typ'] = $typ[0];
											$_SESSION['user_id'] = $typ[1];
											echo '	<h2>Pomyślnie zalogowano</h2><br><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br><br>
												<a href="testy.php" style="text-decoration:none" class="zal">Konto</a>';
										}
									}
									
									mysqli_close($pol);
									}
									else
										{	
											echo '	<h2>Nie wypełniono wszystkich pól</h2><a class="zal"  style="text-decoration:none" href="login.php">Powrót do logowania</a><br><br><br>
												<a href="rejestracja.php" style="text-decoration:none" class="zal">Stworz konto</a>';
										}
									
								?>
								
								
						</fieldset>	
					</form>
				</td></tr></table>	
			</div>	
		</div>
	</div>
	</body>
</html>
