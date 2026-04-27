<?php
session_start();
if (!isset($_SESSION['user_typ']) || $_SESSION['user_typ'] !== "Egzaminator") {
    header('Location: login.php');
    exit;
}
if(isset($_POST['test_id']))
{
$test_id = (int)$_POST['test_id'];

$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'projekt';

$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Usuwanie odpowiedzi, pytań, wyników, ocen i testu
$conn->begin_transaction();

try {
    // Usuń odpowiedzi
    $sql_delete_answers = "DELETE o FROM odpowiedzi o 
                           JOIN pytania p ON o.pytania_id = p.ID 
                           WHERE p.testy_id = ?";
    $stmt = $conn->prepare($sql_delete_answers);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();

    // Usuń pytania
    $sql_delete_questions = "DELETE FROM pytania WHERE testy_id = ?";
    $stmt = $conn->prepare($sql_delete_questions);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();

    // Usuń wyniki
    $sql_delete_results = "DELETE FROM wynik WHERE testy_id = ?";
    $stmt = $conn->prepare($sql_delete_results);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();

    // Usuń oceny
    $sql_delete_grades = "DELETE FROM ocena WHERE testy_id = ?";
    $stmt = $conn->prepare($sql_delete_grades);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();

    // Usuń test
    $sql_delete_test = "DELETE FROM testy WHERE ID = ?";
    $stmt = $conn->prepare($sql_delete_test);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();

    $conn->commit();
    header('Location: testy.php?deleted=success');
} catch (Exception $e) {
    $conn->rollback();
    echo "Błąd podczas usuwania testu: " . $e->getMessage();
    exit;
}

$conn->close();
}
else
{
$test_id = (int)$_GET['test_id'];

$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'projekt';

$conn = new mysqli($host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobranie szczegółów testu
$sql_test = "SELECT nazwa FROM testy WHERE ID = ?";
$stmt = $conn->prepare($sql_test);
$stmt->bind_param("i", $test_id);
$stmt->execute();
$result = $stmt->get_result();
$test = $result->fetch_assoc();

if (!$test) {
    echo "Nie znaleziono testu.";
    exit;
}
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <title>Usuń Test</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/testy.css">
    <link rel="stylesheet" href="css/hamburger.css">
</head>
<body>
<div id="strona">
    <div id="head">
        <a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
        <nav>
            <ul id="menu">
                <li class="menu"><a href="testy.php" style="text-decoration:none" id="head_zal">Powrót</a></li>
                <li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj</a></li>
            </ul>
        </nav>
    </div>
<div id="main">
    <div id="main3">
        <h1>Potwierdzenie usunięcia testu</h1>
        <p>Czy na pewno chcesz usunąć test <strong><?php echo htmlspecialchars($test['nazwa']); ?></strong>?</p>
        <form action="usun_test.php" method="POST">
            <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
            <button type="submit" style="text-decoration:none" class="zwykle_a4">Tak, usuń test</button>
            <a href="testy.php" style="text-decoration:none" class="zwykle_a5">Anuluj</a>
        </form>
    </div>
</div>
</div>
</body>
</html>
