<?php session_start(); ?>

<!DOCTYPE html><html  lang="pl">

	<head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
		<link rel="stylesheet" type="text/css" href="css/rej.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Rejestracja</title>
		
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
				}
				else
				{				
					echo'
						<li class="menu">Masz już konto?</li>
						<li class="menu"><a href="login.php"  style="text-decoration:none" id="head_zal" >Zaloguj się</a></li>';
					}
				?>
				</ul>
			</nav>
		</div>		
		<div id="main">
			<div id="rejestracja">

				<table id="rej_tab"><tr><td>
				
					<form method="POST" action="po_rej.php" id="form">
						<fieldset id="rej_field">
							<legend id="rej_leg">Rejestracja:</legend>
							<?php if(isset($_SESSION['user_e-mail']))
									{
										echo '<h2 id="ok">Jesteś już zalogowany/zalogowana</h2><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a>';
									}
									else
									{
									echo'
									<h2>Typ konta: </h2>
									<select required id="rej_typ" name="typ">
										
										<option class="opcja" value="" selected disabled>Wybierz typ konta</option>
										<option class="opcja" value="Egzaminator">Egzaminator</option>
										<option class="opcja" value="Zdający">Zdający</option>
										
									</select>
								
								<br>
								
									<h2>Adres E-Mail: </h2>
									<input type="email" required name="mail" placeholder="E-Mail">
								
								<br>
									<h2>Imię: </h2>
									<input type="text" required name="imie" placeholder="Imię">
								
								<br>
									<h2>Nazwisko: </h2>
									<input type="text" required name="nazwisko" placeholder="Nazwisko">
								
								<br>
									
									<h2>Hasło: <br></h2>
									<div class="haslo">
										<input type="password" required pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$"  
											   name="has" id="has" placeholder="Hasło" 
											   title="Hasło musi zawierać: Min. 8 znaków, 1 cyfrę, 1 dużą literę, 1 małą literę i 1 znak specjalny">
										<i class="fa-solid fa-eye" id="oko" data-eye data-target="has"></i>
									</div>

									<h2>Powtórz hasło: </h2>
									<div class="haslo">
										<input type="password" required pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$" 
											   name="has2" id="has2" placeholder="Hasło" 
											   title="Hasło musi zawierać: Min. 8 znaków, 1 cyfrę, 1 dużą literę i 1 znak specjalny">
										<i class="fa-solid fa-eye" id="oko2" data-eye data-target="has2"></i>
									</div>

									
								
								<br>
								
									<input type="submit" Value="Stwórz konto" id="rej_btn" >
								
								';
								}
								
								?>
						</fieldset>	
					</form>
				</td></tr></table>	
			</div>		
		</div>	
	</div>

	<script  src="js/czy.js"></script>
	<script  src="js/select.js"></script>
	<script  src="js/has.js"></script>	
	</body>
</html>
