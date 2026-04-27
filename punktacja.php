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
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Tworzenie pytań</title>
</head>
		
	</head>

	<body>	
		
	<div id="strona">
	
		<div id="head">

		<?php

		if (!isset($_SESSION['user_id'])) {
			header('Location: wylogowano.php');
			exit;
		}

		$pol = mysqli_connect('localhost', 'root', '', 'projekt');
		if (!$pol) {
			die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
		}

		$user_id = $_SESSION['user_id'];

		// Odczytaj ID testu z POST
		if (isset($_POST['test_id']) && is_numeric($_POST['test_id'])) {
			$t_ID = (int)$_POST['test_id'];
		} else {
			die("Brak ID testu!");
		}	

		// Odczytaj inne dane z POST
		$t_nazwa = $_POST['t_nazwa'] ?? '';
		$t_kat = $_POST['t_kat'] ?? 0;

		// Wstaw dane testu do bazy danych, jeśli jeszcze go nie ma
		$naz = "SELECT `ID` FROM `testy` WHERE `ID` = '$t_ID'";
		$naz_que = mysqli_query($pol, $naz);
		$naz_fet = mysqli_fetch_row($naz_que);

		if (!$naz_fet) {
			$dod = "INSERT INTO `testy`(`ID`, `nazwa`, `kategorie_id`, `konta_id`) 
					VALUES ('$t_ID', '$t_nazwa', '$t_kat', '$user_id')";
			$dod_que = mysqli_query($pol, $dod);

			if (!$dod_que) {
				die("Błąd wstawiania testu: " . mysqli_error($pol));
			}
		}

		mysqli_close($pol);
		?>

		<?php
		if((isset($_POST['p_tresc']))&&($_POST['p_tresc']!=NULL))
		{
			$pol=mysqli_connect('localhost','root','','projekt');
			$p_tresc=$_POST['p_tresc'];
			if((isset($_POST['numer']))&&($_POST['numer']!=NULL))
			{
				$numer=$_POST['numer'];
			}	
			else
			{
				$numer=1;
			}
			$user_id=$_SESSION['user_id'];
			
			$czy="SELECT `ID` FROM `pytania`";
			$czy_que=mysqli_query($pol, $czy);
			$czy_fet=mysqli_fetch_row($czy_que);
			$p_ID=$czy_fet[0];
			
			$czy="SELECT `ID` FROM `pytania`";
			$czy_que=mysqli_query($pol, $czy);
			$czy_fet=mysqli_fetch_row($czy_que);
				
			$naz="SELECT `zawartosc` FROM `pytania` WHERE `testy_id`='$t_ID'";
			$naz_que=mysqli_query($pol, $naz);
			$naz_fet=mysqli_fetch_row($naz_que);
			if(!$naz_fet)
			{
				$istn="false";
			}
			while($naz_fet)
			{
				if($naz_fet[0]!=$p_tresc)
				{
					$naz_fet=mysqli_fetch_row($naz_que);
					$istn="false";
				}
				else
				{
					$istn="true";
					break;
				}
			}
							
			if($istn=="false")
			{
				if (!$czy_fet || is_null($czy_fet[0]) || $czy_fet[0] == 0) 
				{
					$dod = "INSERT INTO `pytania`(`ID`,`testy_id`,`zawartosc`,`numer`) VALUES ('$p_ID','$t_ID','$p_tresc','$numer');";
					$dod_que = mysqli_query($pol, $dod);
				}	
				else
				{
					if($czy_fet[0]==$p_ID)
					{
						while($czy_fet)
						{
							$p_ID++;
							$czy_fet=mysqli_fetch_row($czy_que);	
						}	
						$dod="INSERT INTO `pytania`(`ID`,`testy_id`,`zawartosc`,`numer`) VALUES ('$p_ID','$t_ID','$p_tresc','$numer');";
						$dod_que=mysqli_query($pol,$dod);
						$GLOBALS['pyt_ID']=$p_ID;		
											
					}
				}
			}
			mysqli_close($pol);
		}
			?>
			<?php 
				$j=1;	
				$o_ID=1;
				while(isset($_POST['jest_'.$j]))
				{
					if(isset($GLOBALS['pyt_ID']))
					$p_ID=$GLOBALS['pyt_ID'];
				
					$o_tresc=$_POST['jest_'.$j];
					$numer=1;
					$user_id=$_SESSION['user_id'];
					$pol=mysqli_connect('localhost','root','','projekt');

					$czy3="SELECT `ID` FROM `odpowiedzi`";
					$czy3_que=mysqli_query($pol, $czy3);
					$czy3_fet=mysqli_fetch_row($czy3_que);
					
					
					$czy4="SELECT `numer` FROM `odpowiedzi` WHERE `pytania_id`='$p_ID'";
					$czy4_que=mysqli_query($pol, $czy4);
					$czy4_fet=mysqli_fetch_row($czy4_que);

					if($czy3_fet==0)
					{
						$dod="INSERT INTO `odpowiedzi`(`ID`,`pytania_id`,`zawartosc`,`numer`) VALUES ('$o_ID','$p_ID','$o_tresc','$numer');";
						$dod_que=mysqli_query($pol,$dod);
					
					if(isset($_POST['popr_odp'])) 
						{
							$check=$_POST['popr_odp'];  
							foreach ($check as $check2)
							{
								$dod="UPDATE odpowiedzi SET punkty='1' where `ID`='$o_ID' and `pytania_id`='$p_ID' and `numer`='$check2';";
								$dod_que=mysqli_query($pol,$dod);		
							}
						}		
					}
					else
					{	asd:
						if($czy3_fet[0]==$o_ID)
						{
							while($czy3_fet)
							{
								$o_ID++;
								$czy3_fet=mysqli_fetch_row($czy3_que);	
							}	
							
							if($czy4_fet==null)
							{
								$dod="INSERT INTO `odpowiedzi`(`ID`,`pytania_id`,`zawartosc`,`numer`) VALUES ('$o_ID','$p_ID','$o_tresc','$numer');";
								$dod_que=mysqli_query($pol,$dod);	
								
								if(isset($_POST['popr_odp'])) 
								{
									$check=$_POST['popr_odp'];  
									foreach ($check as $check2)
									{
										$dod="UPDATE odpowiedzi SET punkty='1' where `ID`='$o_ID' and `pytania_id`='$p_ID' and `numer`='$check2';";
										$dod_que=mysqli_query($pol,$dod);		
									}
								}
							}
							else
							if($czy4_fet[0]==$numer)
							{
								while($czy4_fet)
								{
									$numer++;
									$czy4_fet=mysqli_fetch_row($czy4_que);
								}
								$dod="INSERT INTO `odpowiedzi`(`ID`,`pytania_id`,`zawartosc`,`numer`) VALUES ('$o_ID','$p_ID','$o_tresc','$numer');";
								$dod_que=mysqli_query($pol,$dod);	
								
								if(isset($_POST['popr_odp'])) 
								{
									$check=$_POST['popr_odp'];  
									foreach ($check as $check2)
									{
										$dod="UPDATE odpowiedzi SET punkty='1' where `ID`='$o_ID' and `pytania_id`='$p_ID' and `numer`='$check2';";
										$dod_que=mysqli_query($pol,$dod);		
									}
								}				
							}
							else
							{
								$dod="INSERT INTO `odpowiedzi`(`ID`,`pytania_id`,`zawartosc`,`numer`) VALUES ('$o_ID','$p_ID','$o_tresc','$numer');";
								$dod_que=mysqli_query($pol,$dod);
								
								if(isset($_POST['popr_odp'])) 
								{
									$check=$_POST['popr_odp'];  
									foreach ($check as $check2)
									{
										$dod="UPDATE odpowiedzi SET punkty='1' where `ID`='$o_ID' and `pytania_id`='$p_ID' and `numer`='$check2';";
										$dod_que=mysqli_query($pol,$dod);		
									}
								}													
							}
						}	
						else
						{ 
							$czy3_fet=mysqli_fetch_row($czy3_que);	
							goto asd;
						}	
					}
					$j++;
					mysqli_close($pol);
				}
			?>
			<a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
			<nav>
			</nav>
		</div>
				
		<div id="main">
		

	
				<table id="rej_tab"><tr><td>
				
					<form method="POST" action="koniec.php" id="form">
						<legend id="rej_leg">Kryteria oceniania</legend>
						<br><br>
							<a id="asdf" style="text-decoration:none" class="zwykle_a2">Próg na zaliczenie<!--&nbsp;&nbsp;&nbsp;--><input hidden type="checkbox" id="btn" style="pointer-events: none;"></a>
						<br><br>
						<span id="min_oc"></span>
						<br><br>
							<!--<a id="asdf2" hidden style="text-decoration:none" class="zwykle_a2">Oceń szczegółowo na podstawie przedziałów punktowych lub procentowych&nbsp;&nbsp;&nbsp;<input type="checkbox" id="btn2" style="pointer-events: none;" onclick="clickUpdates3()"></a>-->
						<br><br>
						<span id="prog_oc"></span>
						<span id="progi_ocen"></span>
						<input class="text" hidden type="number" name="test_id" value="<?php 
						$t_ID = $_POST['test_id']; echo $t_ID;?>">
						<button class="btn2">Zakończ tworzenie</button>
								
					</form>
			
				</td></tr></table>	
		</div>	
	</div>
	</div>
	<script  src="js/przycisk.js"></script>	
	<script  src="js/hamburger.js"></script>
</body>
</html>
