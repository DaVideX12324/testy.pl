<?php session_start(); ?>

<!DOCTYPE html><html  lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/index.css?v=">
		<link rel="stylesheet" type="text/css" href="css/hamburger_wide.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>TESTY.PL</title>
		
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
						<li class="menu"><h4>Witaj, '.$_SESSION["user_e-mail"].'</h4></a></li>';
						if (isset($_SESSION['user_typ']) && $_SESSION['user_typ'] == "Egzaminator") 
						{
							echo '	
							<li class="menu"><a href="stworz.php" style="text-decoration:none" id="head_stw">Nowy test</a></li>';
						}
						else
						{
							echo'
							<li class="menu"><a href="odpowiadanie.php" style="text-decoration:none" id="head_zal">Rozwiąż test</a></li>';
						}
						echo'
						<li class="menu"><a href="testy.php" style="text-decoration:none" id="head_zal">Testy</a></li>
						<li class="menu"><a href="ustawienia.php" style="text-decoration:none" id="head_zal">Konto</a></li>
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
			<div id="intro">
				<h1>Witamy na TESTY.PL!</h1>
				<p>
					TESTY.PL to platforma stworzona z myślą o nauczycielach, uczniach, pracodawcach i pracownikach. 
					Naszym celem jest ułatwienie tworzenia, rozwiązywania oraz analizowania testów w sposób szybki 
					i przyjazny dla użytkownika.
				</p>
				<p>
					Wykorzystując nasze narzędzia, możesz tworzyć własne testy, udostępniać je innym oraz śledzić 
					wyniki uczestników. Dzięki prostemu interfejsowi i możliwościom analitycznym TESTY.PL staje się 
					nieodzownym narzędziem w edukacji oraz procesach rekrutacyjnych.
				</p>
			</div>

			<?php
			if (isset($_SESSION['user_typ']) && $_SESSION['user_typ'] == "Egzaminator") {
				echo '
				<div id="main3">
					<h1>Panel Egzaminatora</h1>
					<p>
						Jako egzaminator masz dostęp do zaawansowanych narzędzi, które pomogą Ci efektywnie 
						zarządzać procesem testowania. Nasza platforma umożliwia:
					</p>
					<ul>
						<li>
							<strong>Tworzenie testów:</strong> Projektuj testy dostosowane do Twoich potrzeb. 
							Możesz dodawać pytania jednokrotnego lub wielokrotnego wyboru oraz pytania otwarte.
						</li>
						<li>
							<strong>Udostępnianie testów:</strong> Wysyłaj testy swoim uczniom, pracownikom lub uczestnikom 
							szkoleń. Dzięki unikalnym kodom każdy użytkownik może łatwo rozpocząć test.
						</li>
						<li>
							<strong>Analizowanie wyników:</strong> Śledź postępy uczestników, sprawdzaj średnie wyniki oraz 
							identyfikuj trudne pytania dzięki wbudowanym statystykom.
						</li>
					</ul>
					<p>
						Rozpocznij już teraz i ułatw sobie proces nauczania lub rekrutacji!
					</p>
					<ul>
						<li><a href="stworz.php" class="zwykle_a3">Stwórz nowy test</a></li>
						<li><a href="edytuj_testy.php" class="zwykle_a3">Zarządzaj swoimi testami</a></li>
						<li><a href="testy.php" class="zwykle_a3">Przeglądaj wyniki uczestników</a></li>
					</ul>
				</div>
				';
			} elseif (isset($_SESSION['user_typ']) && $_SESSION['user_typ'] == "Zdający") {
				echo '
				<div id="main3">
					<h1>Panel Zdającego</h1>
					<p>
						Jako zdający możesz łatwo uczestniczyć w testach i śledzić swoje postępy. Nasza platforma 
						oferuje Ci:
					</p>
					<ul>
						<li>
							<strong>Rozwiązywanie testów:</strong> Wpisz kod testu, który otrzymałeś od egzaminatora, 
							aby rozpocząć test w dowolnym miejscu i czasie.
						</li>
						<li>
							<strong>Przeglądanie wyników:</strong> Po zakończeniu testu możesz sprawdzić swoje wyniki, 
							zobaczyć, które pytania były trudne i dowiedzieć się, co należy poprawić.
						</li>
						<li>
							<strong>Zarządzanie swoim kontem:</strong> Aktualizuj swoje dane, zmieniaj hasło i 
							monitoruj historię ukończonych testów w jednym miejscu.
						</li>
					</ul>
					<p>
						Powodzenia w osiąganiu jak najlepszych wyników!
					</p>
					<ul>
						<li><a href="odpowiadanie.php" class="zwykle_a3">Rozwiąż test</a></li>
						<li><a href="testy.php" class="zwykle_a3">Sprawdź swoje wyniki</a></li>
						<li><a href="ustawienia.php" class="zwykle_a3">Zarządzaj swoim kontem</a></li>
					</ul>
				</div>
				';
			} else {
				echo '
				<div id="main3">
					<h1>Witamy na TESTY.PL!</h1>
					<p>
						Nie masz jeszcze konta? Zaloguj się lub zarejestruj, aby skorzystać z pełni możliwości 
						naszej platformy. Dzięki TESTY.PL możesz:
					</p>
					<ul>
						<li>Tworzyć i rozwiązywać testy online</li>
						<li>Śledzić postępy swoje lub swoich uczniów</li>
						<li>Analizować wyniki w łatwy i przejrzysty sposób</li>
					</ul>
					<p>
						Dołącz do nas już dziś i korzystaj z intuicyjnych narzędzi, które zmienią sposób, w jaki 
						podchodzisz do testów!
					</p>
					<ul>
						<li><a href="login.php" class="zwykle_a3">Zaloguj się</a></li>
						<li><a href="rejestracja.php" class="zwykle_a3">Stwórz konto</a></li>
					</ul>
				</div>
				';
			}
			?>
		</div>

	</div>
<script  src="js/hamburger.js"></script>
	</body>
</html>
