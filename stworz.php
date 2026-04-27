
<?php session_start(); 
if(!isset($_SESSION['user_e-mail']))
{
	header('Location: login.php');
}
?>

<!DOCTYPE html><html  lang="pl">
	<head>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger.css?v=3">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Tworzenie testu</title>
		
	</head>

	<body>
	<div id="strona">
		<div id="head">
			<a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
			<nav>
				<div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
				<ul id="menu">				
					<li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj się</a></li>
				</ul>
			</nav>
		</div>
				
		<div id="main">
			<table id="rej_tab"><tr><td>
				<form method="POST" action="stw_pyt.php" id="form">
					<fieldset id="field">
						<legend id="rej_leg">Tworzenie testu:</legend>
						<h2>Nazwa testu: </h2>
						<input type="text" required maxlength="100" name="t_nazwa" placeholder="Nazwa" class="text"
						<?php
							$pol = mysqli_connect('localhost', 'root', '', 'projekt');
							$user_id=$_SESSION['user_id'];

							// Pobranie wszystkich nazw testów użytkownika
							$czy = "SELECT `nazwa` FROM `testy` WHERE `nazwa` LIKE 'Nowy test #%' AND `konta_id` = '$user_id'";
							$czy_que = mysqli_query($pol, $czy);
							$id = "SELECT `ID` from `testy` ORDER BY `ID` DESC LIMIT 1";
							$id_que = mysqli_query($pol, $id);
							$maxID = mysqli_fetch_row($id_que);
							$t_ID = $maxID[0] +1; // Następne ID

							$maxIndex = 0;

							// Szukamy największego indeksu testu
							while ($row = mysqli_fetch_assoc($czy_que)) {
								if (preg_match('/Nowy test #(\d+)/', $row['nazwa'], $matches)) {
									$currentIndex = (int)$matches[1];
									if ($currentIndex > $maxIndex) {
										$maxIndex = $currentIndex;
									}
								}
							}

							// Ustalanie domyślnej nazwy nowego testu
							$newTestName = "Nowy test #" . ($maxIndex + 1);

							// Obsługa wartości w polu 't_nazwa'
							if (isset($_POST['t_nazwa']) && !empty($_POST['t_nazwa'])) {
								// Jeśli nazwa została przesłana w formularzu, ustaw ją jako wartość
								$userProvidedName = htmlspecialchars($_POST['t_nazwa']);
								echo 'value="' . $userProvidedName . '">';
							} else {
								// W przeciwnym razie ustaw domyślną wartość
								echo 'value="' . $newTestName . '">';
							}
								echo '
							
							<br>
								
								<h2>Kategoria: <br></h2>
								<input type="button" Value="Stwórz kategorię" id="btn" class="btn" >
									
									<span id="kat_stw">
									
									</span>
									';
									
									$mail=$_SESSION['user_e-mail'];
									$user_id=$_SESSION['user_id'];
									if(isset($_POST['kat2']))
									{
										if($_POST['kat2']!=null)
										{
											$kat2=$_POST['kat2'];
											$zap="insert into `kategorie`(`nazwa`,`e-mail`) values ('$kat2','$mail')";
											$kat_czy="SELECT EXISTS(SELECT * FROM `kategorie` WHERE `nazwa`='$kat2' and `e-mail`='$mail');";
											$kat_czy_que=mysqli_query($pol,$kat_czy);
											$kat_czy_fet=mysqli_fetch_array($kat_czy_que);
											if($kat_czy_fet[0]==0)
											{
												mysqli_query($pol,$zap);
											}
											else
											{	
												echo '<br><br>Kategoria już istnieje';
											}
										
											mysqli_close($pol);
										}
									}
									else
									{
										$kat2="";
									}
									
									echo'
									<br><br>
									<select id="kat" name="t_kat">
									
									<option value="">Brak kategorii</option>
									';
									
									$pol=mysqli_connect('localhost','root','','projekt');
									$kat="select nazwa from `kategorie` WHERE `e-mail`='$mail'";
									$que=mysqli_query($pol,$kat);
									$id="select id from `kategorie` WHERE `e-mail`='$mail'";
									$queid=mysqli_query($pol,$id);
										
										if($que!=null)
											$fet=mysqli_fetch_array($que);
											$fetid=mysqli_fetch_array($queid);
											
											while($fet)
											{
												if($fet[0]==$kat2)
												{
													echo '<option selected value="'.$fetid[0].'">'.$fet[0].'</option>';
													$fet=mysqli_fetch_array($que);
													$fetid=mysqli_fetch_array($queid);
												}	
												else
												{
													echo '<option value="'.$fetid[0].'">'.$fet[0].'</option>';
													$fet=mysqli_fetch_array($que);
													$fetid=mysqli_fetch_array($queid);
												}	
											}
									
								
									
									mysqli_close($pol);
									echo '
								</select><br>
								<p id="tekst">Wybierz kategorię testu.<br>Dzięki temu zachowasz porządek, gdy liczba testów wzrośnie.</p>
						
							<input type="hidden" name="test_id" value="'.$t_ID.'">
							<br>
								<input type="submit" Value="Dalej" class="btn" >
							
							';
						
							
							?>
					</fieldset>
				</form>
			</td></tr></table>	
		</div>	
	</div>
	<script  src="js/stw_kat.js"></script>
	<script  src="js/hamburger.js"></script>
	<script  src="js/select.js"></script>
	</body>
</html>
