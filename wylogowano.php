<?php session_start(); ?>
<!DOCTYPE html><html  lang="pl">

	<head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
		<link rel="stylesheet" type="text/css" href="css/rej.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger.css"> 
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Wylogowano</title>
		
	</head>

	<body>
	<div id="strona">
		<div id="head">
			<a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
			<nav>
			</nav>
		</div>		
		<div id="main">
		<table id="rej_tab"><tr><td>
			<fieldset id="rej_field">
				<legend id="rej_leg">Stan:</legend>
					<?php
						session_destroy(); 
						echo '<h2 id="ok">Pomyślnie wylogowano</h2><br><a class="zal"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a>';
					?>
								
								
			</fieldset>	
		</td></tr></table>	
		</div>	
	</div>
	</body>
</html>
