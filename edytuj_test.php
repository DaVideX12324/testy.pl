<?php
session_start();
if (!isset($_SESSION['user_typ']) || $_SESSION['user_typ'] !== "Egzaminator") {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['test_id'])) {
    header('Location: edytuj_testy.php');
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

$test_id = (int)$_GET['test_id'];
$email = $_SESSION['user_e-mail'];

// Pobranie szczegółów testu
$sql_test = "SELECT * FROM testy WHERE ID = ?";
$stmt = $conn->prepare($sql_test);
$stmt->bind_param("i", $test_id);
$stmt->execute();
$test = $stmt->get_result()->fetch_assoc();

// Pobranie kategorii przypisanych do użytkownika
$sql_categories = "SELECT * FROM kategorie WHERE `e-mail` = ?";
$stmt_categories = $conn->prepare($sql_categories);
$stmt_categories->bind_param("s", $email);
$stmt_categories->execute();
$categories = $stmt_categories->get_result();

// Pobranie pytań i odpowiedzi
$sql_questions = "SELECT * FROM pytania WHERE testy_id = ?";
$stmt_questions = $conn->prepare($sql_questions);
$stmt_questions->bind_param("i", $test_id);
$stmt_questions->execute();
$questions = $stmt_questions->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    
		<meta charset="UTF-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <title>Edytuj Test</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/hamburger.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Kliknięcie przycisku „Pokaż odpowiedzi”
            $(".toggle-answers").click(function () {
                const questionId = $(this).data("id");
                $(`#answers-${questionId}`).toggle();
            });

            // Kliknięcie przycisku „Usuń pytanie”
            $(".delete-question").click(function () {
                const questionId = $(this).data("id");
                if (confirm("Czy na pewno chcesz usunąć to pytanie wraz z odpowiedziami?")) {
                    $.post("usun_pytanie.php", { pytanie_id: questionId }, function () {
                        location.reload();
                    });
                }
            });

            // Kliknięcie przycisku „Usuń odpowiedź”
            $(".delete-answer").click(function () {
                const answerId = $(this).data("id");
                if (confirm("Czy na pewno chcesz usunąć tę odpowiedź?")) {
                    $.post("usun_odpowiedz.php", { odpowiedz_id: answerId }, function () {
                        location.reload();
                    });
                }
            });
        });
    </script>
</head>
<body>
<div id="strona">
    <div id="head">
        <a href="index.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
        <nav class="nav-container">
            <ul id="menu">
                <li class="menu"><a href="testy.php" id="head_zal" style="text-decoration:none">Powrót</a></li>
                <li class="menu"><a href="wylogowano.php" id="head_stw" style="text-decoration:none">Wyloguj</a></li>
            </ul>
        </nav>
    </div>

    <div id="main">
    <div id="main3">
        <form action="zapisz_wszystko.php" method="post">
			<fieldset id="rej_tab">
        <legend id="rej_leg">Edytuj Test: <?php echo htmlspecialchars($test['nazwa']); ?></legend>
            <input type="hidden" name="test_id" value="<?php echo $test['ID']; ?>">
			<br> 
            <label for="nazwa">Nazwa testu:</label><br>
            <input type="text" id="nazwa" name="test[nazwa]" class="text" value="<?php echo htmlspecialchars($test['nazwa']); ?>">
            <br><br>
            <label for="kategoria">Kategoria:</label><br>
            <select id="kategoria" name="test[kategoria]" class="styledSelect">
                <?php while ($category = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['ID']; ?>" <?php echo $category['ID'] == $test['Kategorie_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['Nazwa']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <br><br>

            <h2>Pytania</h2>
            <?php while ($question = $questions->fetch_assoc()): ?>
                <div class="pytania" style="margin-bottom: 20px; padding: 20px; background-color: #f9f9f9; border-radius: 10px;">
                    <div class="pytanie" style="display: flex; align-items: center;">
                        <button type="button" class="delete-question odp_usun" data-id="<?php echo $question['ID']; ?>">✖</button>
                        <input type="hidden" name="questions[<?php echo $question['ID']; ?>][id]" value="<?php echo $question['ID']; ?>">
                        <input type="text" name="questions[<?php echo $question['ID']; ?>][zawartosc]" class="text" value="<?php echo htmlspecialchars($question['zawartosc']); ?>" required>
                        <button type="button" class="toggle-answers btn" style="margin-left: 20px;" data-id="<?php echo $question['ID']; ?>">Pokaż odpowiedzi</button>
                    </div>
                    
                    <div id="answers-<?php echo $question['ID']; ?>" class="answers" style="display: none; margin-top: 10px;">
                        <?php
                        $sql_answers = "SELECT * FROM odpowiedzi WHERE pytania_id = ?";
                        $stmt_answers = $conn->prepare($sql_answers);
                        $stmt_answers->bind_param("i", $question['ID']);
                        $stmt_answers->execute();
                        $answers = $stmt_answers->get_result();
                        ?>
                        <?php while ($answer = $answers->fetch_assoc()): ?>
                            <div class="odp_a" style="display: flex; align-items: center; margin-top: 10px;">
                                <button type="button" class="delete-answer odp_usun" data-id="<?php echo $answer['ID']; ?>">✖</button>
                                <input type="hidden" name="answers[<?php echo $answer['ID']; ?>][id]" value="<?php echo $answer['ID']; ?>">
                                <input type="text" name="answers[<?php echo $answer['ID']; ?>][zawartosc]" class="text" value="<?php echo htmlspecialchars($answer['zawartosc']); ?>" required>
                                <input type="number" name="answers[<?php echo $answer['ID']; ?>][punkty]" class="text" value="<?php echo $answer['punkty']; ?>" required>
                            </div>
                        <?php endwhile; ?>
                        <div class="add-answer">
                            <input type="text" name="new_answers[<?php echo $question['ID']; ?>][zawartosc][]" class="text" placeholder="Treść odpowiedzi">
                            <input type="number" name="new_answers[<?php echo $question['ID']; ?>][punkty][]" class="text" placeholder="Punkty">
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

            <h3>Dodaj nowe pytanie:</h3>
            <div class="new-question">
                <input type="text" name="new_questions[zawartosc][]" class="text" placeholder="Treść pytania">
            </div>
			<br>
            <button type="submit" class="btn">Zapisz zmiany</button>
			</fieldset>
        </form>
    </div>
</div>
</div>
	<script  src="js/hamburger.js"></script>
	<script  src="js/select.js"></script>
</body>
</html>
