<?php session_start(); 
if(!isset($_SESSION['user_e-mail']))
{
	header('Location: login.php');
}
?>


<!DOCTYPE html><html  lang="pl">
	<head>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico"><meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Ustawienia konta</title>
		
	</head>

	<body>
	<div id="strona">
<div id="head">
			<a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
			<nav>
				<div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
				<ul id="menu">
				<?php 
				if(isset($_SESSION['user_e-mail']))
				{
					echo '	
						<li class="menu"><h4>Witaj, '.$_SESSION["user_e-mail"].'</h4></a></li>
						<li class="menu"><a href="testy.php" style="text-decoration:none" id="head_zal_1">Twoje testy</a></li>
						<li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj się</a></li>
						';
				}
				else
				{				
					echo'				
						<li class="menu"><h4>Zaloguj się i zacznij swój pierwszy test online</h4></li>
						<li class="menu"><a href="login.php" style="text-decoration:none" id="head_zal" >Zaloguj się</a></li>
						<li class="menu"><a href="rejestracja.php" style="text-decoration:none" id="head_stw">Stwórz konto</a></li>
						';
				}
				?>
				</ul>
			</nav>
		</div>
		<div id="main">
	<br> <br> 
				<table id="rej_tab"><tr><td>
				
				<form action="gotowe.php" method="POST" id="form">
					<h2>Zmiana adresu e-mail</h2>	
					<input class="text" type="e-mail" name="zmiana_mail" placeholder="Nowy adres e-mail">

					<br><br><br>
					<h2> Zmiana hasła</h2>	
					<input class="text" type="password" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$" title="Hasło musi zawierać: Min. 8 znaków, 1 cyfrę, 1 dużą literę i 1 znak specjalny" name="zmiana_has" placeholder="Nowe hasło">

					<br><br><br>
					<h2> Usunięcie konta</h2>	
					<input class="btn" type="submit" name="usun_konto" Value="Usuń konto" formaction="usun_konto.php">

					<br><br><br>
					<h2> Potwierdź hasło</h2>	
					<input class="text" required type="password" name="aktualne_has" placeholder="Aktualne hasło">

					<br><br><br>
					<input class="btn" type="submit" name="usun_konto" Value="Zatwierdź" >

					
				</form>

				</td></tr></table>
	<br> <br> 
		</div>	
	</div>

<script  src="js/hamburger.js"></script>	
</body>
</html>
