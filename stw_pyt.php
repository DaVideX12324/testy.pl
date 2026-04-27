

<?php session_start(); 
if(!isset($_SESSION['user_id']))
{
	header('Location: login.php');
}
?>


<!DOCTYPE html><html  lang="pl">
	<head>
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://cdn.tiny.cloud/1/77jo6yetk68x0utw871r3155b8ofes1savfwit2imp9yo2rc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Tworzenie pytań</title>
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
		<br>
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
			$numer=1;
			$czy="SELECT numer FROM `pytania` WHERE `testy_id`=$t_ID";
			$czy_que=mysqli_query($pol,$czy);
			$czy_fet=mysqli_fetch_row($czy_que);
			if(($czy_fet))
			{
				if($czy_fet[0]==$numer)
				{
					while($czy_fet)
					{
						$numer++;								
						$czy_fet=mysqli_fetch_row($czy_que);
					}
				}
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

	
				<table id="rej_tab"><tr><td>
				
					<form method="POST" action="stw_pyt.php" id="form">
						<legend id="rej_leg">
							<input type="hidden" name="test_id" value="<?php echo $t_ID ?>">
							
						<?php 
						$numer=1;
						$pol=mysqli_connect('localhost','root','','projekt');
						$czy="SELECT numer FROM `pytania` WHERE `testy_id`=$t_ID";
						$czy_que=mysqli_query($pol,$czy);
						$czy_fet=mysqli_fetch_row($czy_que);
							
						if((!$czy_fet))
						{
							echo 'Pytanie #'.$numer;
						}
						else
						{
							if($czy_fet[0]==$numer)
							{
								while($czy_fet)
								{
									$numer++;								
									$czy_fet=mysqli_fetch_row($czy_que);
								}
							echo 'Pytanie #'.$numer;
							}
						}	
						mysqli_close($pol);
						?>
						
						</legend>	
							<textarea id="p_tres"></textarea>
							<script>
								tinymce.init({
									selector: '#p_tres',
									width: 900,
									height: 150,
									plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
									toolbar: 'undo redo | blocks  fontsize | bold italic underline | link image media table  | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
									menubar:false, 
									file_picker_types: 'image',
									  /* and here's our custom image picker*/
									  file_picker_callback: (cb, value, meta) => {
										const input = document.createElement('input');
										input.setAttribute('type', 'file');
										input.setAttribute('accept', 'image/*');

										input.addEventListener('change', (e) => {
										  const file = e.target.files[0];

										  const reader = new FileReader();
										  reader.addEventListener('load', () => {
											/*
											  Note: Now we need to register the blob in TinyMCEs image blob
											  registry. In the next release this part hopefully won't be
											  necessary, as we are looking to handle it internally.
											*/
											const id = 'blobid' + (new Date()).getTime();
											const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
											const base64 = reader.result.split(',')[1];
											const blobInfo = blobCache.create(id, file, base64);
											blobCache.add(blobInfo);

											/* call the callback and populate the Title field with the file name */
											cb(blobInfo.blobUri(), { title: file.name });
										  });
										  reader.readAsDataURL(file);
										});

										input.click();
									  },
									});
							</script>		
							<div id="tu"></div>
							<br>
							
							<h2>Typ odpowiedzi</h2>
							<select id="rej_typ" name="typ_odp" onchange="typ()">
							
								<option selected value="1">Jednokrotny wybór</option>
								<option value="2">Wielokrotny wybór</option>
								<option disabled value="3">Opisowe</option>
								
							</select>
							<br><h2>Odpowiedzi</h2>Po podaniu odpowiedzi zaznacz prawidłową, która będzie punktowana.
							<br><div id='dodaj_odp'></div>
							<input type="button" class="btn2" id="dod" value="+ Dodaj odpowiedź"><br>							
														
						<div id="pkt"><button onclick="Zapis()" class="btn2">Zapisz i dodaj kolejne</button></div>
						<div id="pkt"><button onclick="Zapis()" class="btn2" formaction="punktacja.php">Zapisz test</button></div>
								
					</form>
			
				</td></tr></table>	
		<br>
		</div>	
	</div>
	</body>
<script  src="js/stw_odp.js?v=3"></script>
<script  src="js/hamburger.js"></script>
<script  src="js/select.js"></script>
</html>
