<?php session_start(); 
if(!isset($_SESSION['user_e-mail']))
{
	header('Location: login.php');
}
?>

<!DOCTYPE html>
<html  lang="pl">
	<head>
		<link rel="stylesheet" type="text/css" href="css/testy.css">
		<link rel="stylesheet" type="text/css" href="css/hamburger_wide.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<title>Wyniki Testów</title>
		
	</head>

<body>
    <div id="strona">
        <div id="head">
            <a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
            <nav>
                <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
                <ul id="menu">
                    <!-- Menu generowane dynamicznie przez AJAX -->
                </ul>
            </nav>
        </div>
        <div id="main">
        <div id="main2">
            <!-- Treść generowana dynamicznie przez AJAX -->
        </div>
		</div>
		</div>
	<script  src="js/hamburger.js"></script>
	<script  src="js/ajax_oryg.js"></script>
</body>
</html>
