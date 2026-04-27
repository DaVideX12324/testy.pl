<?php session_start(); 
if(!isset($_SESSION['user_e-mail']))
{
	header('Location: login.php');
}
?>



<!DOCTYPE html><html  lang="pl">
	<head>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" href="css/rej.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Odpowiadanie</title>
		<script src="https://cdn.tiny.cloud/1/77jo6yetk68x0utw871r3155b8ofes1savfwit2imp9yo2rc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
		
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

		<?php 
			if(isset($_POST['id_testu']))
			{
				$mail=$_SESSION['user_e-mail'];
				$user_id=$_SESSION['user_id'];
				$pol=mysqli_connect('localhost','root','','projekt');
				$numer=1;
				asdfg:
				$czy="SELECT `ID`,`numer` FROM `pytania` WHERE `testy_id`='".$_POST['id_testu']."' and `numer`='$numer'";
				$czy_que=mysqli_query($pol,$czy);
				$czy_fet=mysqli_fetch_row($czy_que);
				if($czy_fet!=0)
				{
					$czy2="SELECT `pytanie_id` FROM `odpowiadanie` WHERE `zdajacy_id`='".$_SESSION['user_id']."' and pytanie_id = '".$czy_fet[0]."'";
					$czy2_que=mysqli_query($pol,$czy2);
					$czy2_fet=mysqli_fetch_row($czy2_que);
						
					if($czy2_fet==0)
					{
						$czy6="SELECT `zawartosc`,`ID` FROM `pytania` where `testy_id`='".$_POST['id_testu']."' and `numer`='$numer'";
						$czy6_que=mysqli_query($pol, $czy6);
						$czy6_fet=mysqli_fetch_row($czy6_que);
										
						$ile=0;
											
						$czy3="SELECT `zawartosc`,`punkty`,`ID` FROM `odpowiedzi` where `Pytania_id`='".$czy6_fet[1]."'";
						$czy3_que=mysqli_query($pol, $czy3);
						$czy3_fet=mysqli_fetch_row($czy3_que);
						$i=1;
						while($czy3_fet)
						{	
							$ile=$ile+$czy3_fet[1];
							$typ="radio";
							if($ile>1)
							{
								$typ="checkbox";
							}
							$czy3_fet=mysqli_fetch_row($czy3_que);
						}
						$czy4="SELECT `zawartosc`,`punkty`,`ID` FROM `odpowiedzi` where `Pytania_id`='".$czy6_fet[1]."'";
						$czy4_que=mysqli_query($pol, $czy4);
						$czy4_fet=mysqli_fetch_row($czy4_que);
						while($czy4_fet)
						{	
							$czy4_fet=mysqli_fetch_row($czy4_que);						
						}
						if(isset($_POST['odp'])) 
						{							
							$i=1;
							$check=$_POST['odp']; 
							foreach ($check as $check2)
							{
								$dod="insert into odpowiadanie(`odpowiedz_id`,`testy_id`,`pytanie_id`,`zdajacy_ID`) values ('$check2','".$_POST['id_testu']."','".$czy6_fet[1]."','$user_id');";
								$dod_que=mysqli_query($pol,$dod);
							}	
						}
					}
					else
					{
						$numer++;
						goto asdfg;
					}
				}
				mysqli_close($pol);
			}
		?>
		<table id="rej_tab"><tr><td>
		<form method="POST" action="odpowiadanie.php" id="form">
		<?php 
			
							
			$pol=mysqli_connect('localhost','root','','projekt');
			if(!isset($_POST['id_testu']))
			{
				echo'
				<p>Wprowadź ID testu: </p>
				<input type="number" required maxlength="100" min="1" name="id_testu" placeholder="ID testu:" class="text" <br>
				'; 
				echo '
				<br><button class="btn2">Dalej</button>
				';
			}
			else
			{	
				$t_ID=$_POST['id_testu'];
				echo'
				<input type="text" hidden required name="id_testu" value="'.$t_ID.'"></div>';
					$pol=mysqli_connect('localhost','root','','projekt');
										
					$numer=1;
					 asd:
					$czy="SELECT `ID`,`numer` FROM `pytania` WHERE `testy_id`=$t_ID and `numer`='$numer'";
					$czy_que=mysqli_query($pol,$czy);
					$czy_fet=mysqli_fetch_row($czy_que);
					if($czy_fet!=0)
					{	
						$czy2="SELECT `pytanie_id` FROM `odpowiadanie` WHERE `zdajacy_id`='".$_SESSION['user_id']."' and pytanie_id = '".$czy_fet[0]."'";
						$czy2_que=mysqli_query($pol,$czy2);
						$czy2_fet=mysqli_fetch_row($czy2_que);
											
						if($czy2_fet==0)
						{
							echo '
							<h1>Pytanie #'.$numer.'</h1>
							';
								
							$czy6="SELECT `zawartosc`,`ID` FROM `pytania` where `testy_id`='$t_ID' and `numer`='$numer'";
							$czy6_que=mysqli_query($pol, $czy6);
							$czy6_fet=mysqli_fetch_row($czy6_que);
											
							echo '
							<h2>'.$czy6_fet[0].'</h2>
							';
							$ile=0;
												
							$czy3="SELECT `zawartosc`,`punkty`,`ID` FROM `odpowiedzi` where `Pytania_id`='".$czy6_fet[1]."'";
							$czy3_que=mysqli_query($pol, $czy3);
							$czy3_fet=mysqli_fetch_row($czy3_que);
							$i=1;
							while($czy3_fet)
							{	
								$ile=$ile+$czy3_fet[1];
								$typ="radio";
								if($ile>1)
								{
									$typ="checkbox";
								}
									$czy3_fet=mysqli_fetch_row($czy3_que);
														
							}
							$czy4="SELECT `zawartosc`,`punkty`,`ID` FROM `odpowiedzi` where `Pytania_id`='".$czy6_fet[1]."'";
							$czy4_que=mysqli_query($pol, $czy4);
							$czy4_fet=mysqli_fetch_row($czy4_que);
							while ($czy4_fet) {
								echo '
								<label style="display: block; cursor: pointer;">
									<input type="'.$typ.'" name="odp[]" value="'.$czy4_fet[2].'">
									<fieldset class="rej_field">
										'.$czy4_fet[0].'
									</fieldset>
								</label>
								';
								$czy4_fet = mysqli_fetch_row($czy4_que);
							}
							
							echo '
							<br><button class="btn2">Dalej</button>
							';
																		
						}
						else
						{
							$numer++;
							goto asd;
						}
					}
					else
					{
						echo '
						<fieldset id="rej_field">
						<legend id="rej_leg">Stan:</legend>
						<h2>Ukończono test<br><br></h2></fieldset>
						';
											
						echo '
						<fieldset id="rej_field">
						<legend id="rej_leg">Wynik:</legend>
						<h2>
						';
											
												
						$pol=mysqli_connect('localhost','root','','projekt');
											
						$procent=0;
						$ok=0;
						$asd="SELECT `pytanie_id`,`odpowiedz_id` from odpowiadanie WHERE `zdajacy_id`='".$_SESSION['user_id']."' and `testy_id` = '".$t_ID."'";
						$asd_que=mysqli_query($pol, $asd);
						$asd_fet=mysqli_fetch_row($asd_que);
						while($asd_fet)
						{	
							$asd2="SELECT `id`,`punkty` from odpowiedzi WHERE `pytania_id` = '".$asd_fet[0]."' and `punkty`=1";
							$asd2_que=mysqli_query($pol, $asd2);
							$asd2_fet=mysqli_fetch_row($asd2_que);
							while($asd2_fet)
							{
								if($asd_fet[1]==$asd2_fet[0])
								{
									$ok=$ok+1;
								}
													
								$asd2_fet=mysqli_fetch_row($asd2_que);	
							}
							$procent++;
							$asd_fet=mysqli_fetch_row($asd_que);
						}
											
						echo $ok.' Punkty <br>' ;
						$ile=ceil(($ok/$procent)*100);
						echo $ile.' %';
													
						$asd4="SELECT `min_%`,`min_pkt`,`ocena`,`ocena_opis`,`pkt_na_ocene`,`%_na_ocene` from ocena WHERE `testy_ID` = '".$t_ID."'";
						$asd4_que=mysqli_query($pol, $asd4);
						$asd4_fet=mysqli_fetch_row($asd4_que);
						if($asd4_fet[0]!=0)
						{	
							if($ile>=$asd4_fet[0])
							{
								$zdane=1;
							}
							else
							{
								$zdane=0;
							}
							if($zdane)
							{
								echo '<br>Test zaliczony!';
												
								$b="SELECT `testy_id`,`zdajacy_ID` from wynik WHERE `testy_id` = '$t_ID' and `zdajacy_ID`='".$_SESSION['user_id']."'";
								$b_que=mysqli_query($pol, $b);
								$b_fet=mysqli_fetch_row($b_que);
								if($b_fet==0)
								{
									$a="insert into wynik(`testy_id`,`zdajacy_ID`,`wynik_pkt`,`wynik_%`,`zdane`) values ('$t_ID','".$_SESSION['user_id']."','$ok','$ile','$zdane');";
									$a_que=mysqli_query($pol, $a);
								}
							}
							else
							{
								echo '<br>Test niezaliczony.';
											
								$b="SELECT `testy_id`,`zdajacy_ID` from wynik WHERE `testy_id` = '$t_ID' and `zdajacy_ID`='".$_SESSION['user_id']."'";
								$b_que=mysqli_query($pol, $b);
								$b_fet=mysqli_fetch_row($b_que);
								if($b_fet==0)
								{
									$a="insert into wynik(`testy_id`,`zdajacy_ID`,`wynik_pkt`,`wynik_%`,`zdane`) values ('$t_ID','".$_SESSION['user_id']."','$ok','$ile','$zdane');";
									$a_que=mysqli_query($pol, $a);
								}
							}
						}
						else	
						{	
							if($ok==$asd4_fet[1])
							{
								$zdane=1;
							}
							else
							{
								$zdane=0;
							}
												
							if($zdane)
							{
								echo '<br>Test zaliczony!';
										
								$b="SELECT `testy_id`,`zdajacy_ID` from wynik WHERE `testy_id` = '$t_ID' and `zdajacy_ID`='".$_SESSION['user_id']."'";
								$b_que=mysqli_query($pol, $b);
								$b_fet=mysqli_fetch_row($b_que);
								if($b_fet==0)
								{
									$a="insert into wynik(`testy_id`,`zdajacy_ID`,`wynik_pkt`,`wynik_%`,`zdane`) values ('$t_ID','".$_SESSION['user_id']."','$ok','$ile','$zdane');";
									$a_que=mysqli_query($pol, $a);
								}
							}
							else
							{
								echo '<br>Test niezaliczony.';
								
								$b="SELECT `testy_id`,`zdajacy_ID` from wynik WHERE `testy_id` = '$t_ID' and `zdajacy_ID`='".$_SESSION['user_id']."'";
								$b_que=mysqli_query($pol, $b);
								$b_fet=mysqli_fetch_row($b_que);
								if($b_fet==0)
								{
									$a="insert into wynik(`testy_id`,`zdajacy_ID`,`wynik_pkt`,`wynik_%`,`zdane`) values ('$t_ID','".$_SESSION['user_id']."','$ok','$ile','$zdane');";
									$a_que=mysqli_query($pol, $a);
								}
							}
						}
											
						echo '
						<br><br></h2><a id="head_zal2"  style="text-decoration:none" href="index.php">Powrót do strony głównej</a><br><br><br></fieldset>
						';
											
					}
			}
			mysqli_close($pol);
							
		?>
				
		</form>
			
		</td></tr></table>	
		</div>	
	</div>
	</body>
	
<script  src="js/hamburger.js"></script>
</html>
