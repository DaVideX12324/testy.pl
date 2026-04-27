<?php session_start(); ?>

<!DOCTYPE html><html  lang="pl">

	<head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 		
		<link rel="stylesheet" type="text/css" href="css/rej.css">		
		<link rel="stylesheet" type="text/css" href="css/hamburger.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Logowanie</title>
		
	</head>

	<body>
	<div id="strona">
		<div id="head">
			<a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
			<nav>
					<?php 
					if(isset($_SESSION['user_e-mail']))
						{
						}	
						else
						{				
						echo'	
						<div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
						<ul id="menu">
							<li class="menu"><h4>Nie masz jeszcze konta?</h4></li>
							<li class="menu"><a href="rejestracja.php"  style="text-decoration:none" id="head_stw">Stwórz konto</a></li>
						</ul>';
						}
					?>
					
			</nav>
		</div>				
				
		<div id="main">
			<div id="rejestracja">
				<table id="rej_tab"><tr><td>
				
					<form method="POST" action="po_log.php" id="form">
						<fieldset id="rej_field">
						<?php if(isset($_SESSION['user_e-mail']))
									{
										echo '<legend id="rej_leg">Login:</legend>
										<h2 id="ok">Jesteś już zalogowany/zalogowana</h2><br><input type=button class="zal" value="Powrót do strony głównej" onclick=location.href='.'"index.php"'.'>';
									}
									else
									{
									echo'
										<legend id="rej_leg">Login:</legend>

											<h2>Adres E-Mail: </h2>
											<input required type="email" name="mail" placeholder="E-Mail">
												
											<br>
													
											<h2>Hasło: </h2>
											<div class="haslo">
													
												<input required minlength="8"  type="password"  name="has" id="has" placeholder="Hasło">
														
												<i class="fa-solid fa-eye" data-eye data-target="has" id="oko"></i>
														
											</div>
											<br>
												
											<input type="submit" Value="Zaloguj się" id="rej_btn" >
								
									';
									}
								?>
						</fieldset>	
					</form>
				</td></tr></table>	
			</div>	
		</div>
	</div>
	<script  src="js/has.js"></script>
	<script  src="js/hamburger.js"></script>
	</body>
</html>
