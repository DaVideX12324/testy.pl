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
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Tworzenie pytań</title>
</head>
		
	</head>

	<body>	
<?php	
		$oc_ID=1;
		$ile=$_POST['ile'];
		$idtest=$_POST['test_id'];
		$pol=mysqli_connect('localhost','root','','projekt');
	
	
					
		if($_POST['czego']==1)
		{
			$czego="min_%";
		}
		else
		{
			$czego="min_pkt";
		}
		$czy="SELECT `ID` FROM `ocena`";
		$czy_que=mysqli_query($pol, $czy);
		$czy_fet=mysqli_fetch_row($czy_que);

		if(!$czy_fet)
		{				
			$d="INSERT INTO ocena(`ID`,`testy_id`,`".$czego."`) VALUES ('$oc_ID','$idtest','$ile')";
			mysqli_query($pol, $d);
			$d="UPDATE `testy` SET `ocena_id` = '".$oc_ID."' WHERE `ID` = '$idtest'";
			mysqli_query($pol, $d);	
		}		
		else
		{
			if($czy_fet[0]==0)
			{					
				$d="INSERT INTO ocena(`ID`,`testy_id`,`".$czego."`) VALUES ('$oc_ID','$idtest','$ile')";
				mysqli_query($pol, $d);	
				$d="UPDATE `testy` SET `ocena_id` = '".$oc_ID."' WHERE `ID` = '$idtest'";
				mysqli_query($pol, $d);			
			}
						
			else
			{
				if($czy_fet[0]==$oc_ID)
				{
					while($czy_fet)
					{
						$oc_ID++;
						$czy_fet=mysqli_fetch_row($czy_que);	
					}					
					$d="INSERT INTO ocena(`ID`,`testy_id`,`".$czego."`) VALUES ('$oc_ID','$idtest','$ile')";
					mysqli_query($pol, $d);
					$d="UPDATE `testy` SET `ocena_id` = '".$oc_ID."' WHERE `ID` = '$idtest'";
					mysqli_query($pol, $d);			
									
				}					
			}
		}
	
		mysqli_close($pol);
						
			?>
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
				
						
						<h2 id="ok">Pomyślnie utworzono test</h2><br><h2>ID Twojego testu: <?php echo $idtest;
 ?></h2><br><a class="zwykle_a2"  style="text-decoration:none" href="testy.php">Powrót </a><br><br><br>

								
								
			</fieldset>	
		</td></tr></table>	
		</div>	
	</div>
	</body>			
</html>
