<?php
session_start();
if (!isset($_SESSION['user_typ']) || $_SESSION['user_typ'] !== "Egzaminator") {
    header('Location: login.php');
    exit;
}

$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'projekt';

$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$email = $_SESSION['user_e-mail'];
$sql_tests = "SELECT * FROM testy WHERE `e-mail` = ?";
$stmt = $conn->prepare($sql_tests);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <title>Edytuj Testy</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/testy.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script  src="js/hamburger.js"></script>
    <link rel="stylesheet" href="css/hamburger.css">
</head>
<body>
<div id="strona">
    <div id="head">
        <a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
		<nav>
		<div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
			<ul id="menu">
                <li class="menu"><a href="index.php" style="text-decoration:none" id="head_zal">Powrót</a></li>
                <li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj</a></li>
            </ul>
			</div>
			
        </nav>
    </div>

	<div id="main">
    <div id="main2">
        <h1>Twoje testy</h1>
        <?php
        while ($row = $result->fetch_assoc()) {


            echo '<div class="testy_waskie" id="' . $row['ID'] . '">';
            echo '<legend id="rej_leg">' . htmlspecialchars($row['nazwa']) . '</legend><br><br>';
            echo '<a href="edytuj_test.php?test_id=' . $row['ID'] . '" class="zwykle_a5" style="text-decoration:none">Edytuj</a>';
			echo '<a href="usun_test.php?test_id=' . $row['ID'] . '" class="zwykle_a2" style="text-decoration:none">Usuń</a>';
            echo '</div>';
		}

        $stmt->close();
        $conn->close();
        ?>
    </div>
    </div>
</div>
</body>
</html>
