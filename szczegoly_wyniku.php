<?php
session_start();

if (!isset($_SESSION['user_typ']) || $_SESSION['user_typ'] !== 'Egzaminator') {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['wynik_id'])) {
    die("Brak wymaganych parametrów: wynik_id.");
}

$wynik_id = intval($_GET['wynik_id']);

$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'projekt';

$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobierz dane testu i email na podstawie id wyniku
$sql_wynik = "SELECT w.testy_id AS test_id, w.zdajacy_ID AS zdajacy_ID, k.`e-mail` AS email 
               FROM wynik w, konta k
               WHERE w.zdajacy_ID = k.ID AND w.ID = ?";
$stmt_wynik = $conn->prepare($sql_wynik);
$stmt_wynik->bind_param("i", $wynik_id);
$stmt_wynik->execute();
$result_wynik = $stmt_wynik->get_result();

if ($result_wynik->num_rows === 0) {
    die("Nie znaleziono wyniku o podanym ID.");
}

$wynik_data = $result_wynik->fetch_assoc();
$test_id = $wynik_data['test_id'];
$zdajacy_ID = $wynik_data['zdajacy_ID'];

$stmt_wynik->close();

$sql_questions = "SELECT p.ID AS question_id, p.zawartosc AS question_content, p.numer AS question_number
                  FROM pytania p
                  WHERE p.testy_id = ?";
$stmt_questions = $conn->prepare($sql_questions);
$stmt_questions->bind_param("i", $test_id);
$stmt_questions->execute();
$questions_result = $stmt_questions->get_result();

$questions = [];
while ($question = $questions_result->fetch_assoc()) {
    $questions[$question['question_id']] = [
        'content' => $question['question_content'],
        'number' => $question['question_number'],
        'answers' => [],
        'selected_answers' => []
    ];
}

$sql_answers = "SELECT o.ID AS answer_id, o.pytania_id AS question_id, o.zawartosc AS answer_content, o.punkty AS points
                FROM odpowiedzi o
                WHERE o.pytania_id IN (SELECT ID FROM pytania WHERE testy_id = ?)";
$stmt_answers = $conn->prepare($sql_answers);
$stmt_answers->bind_param("i", $test_id);
$stmt_answers->execute();
$answers_result = $stmt_answers->get_result();

while ($answer = $answers_result->fetch_assoc()) {
    $questions[$answer['question_id']]['answers'][] = [
        'id' => $answer['answer_id'],
        'content' => $answer['answer_content'],
        'points' => $answer['points']
    ];
}

$sql_selected_answers = "SELECT odpowiedz_id, pytanie_id
                         FROM odpowiadanie
                         WHERE testy_id = ? AND zdajacy_ID = ?";
$stmt_selected_answers = $conn->prepare($sql_selected_answers);
$stmt_selected_answers->bind_param("is", $test_id, $zdajacy_ID);
$stmt_selected_answers->execute();
$selected_answers_result = $stmt_selected_answers->get_result();

while ($selected_answer = $selected_answers_result->fetch_assoc()) {
    $questions[$selected_answer['pytanie_id']]['selected_answers'][] = $selected_answer['odpowiedz_id'];
}

$stmt_questions->close();
$stmt_answers->close();
$stmt_selected_answers->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szczegóły testu</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/hamburger.css">
</head>
<body>
<div id="strona">
    <div id="head">
				<div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
        <a href="testy.php"><img src="img/logo.png" id="img_logo" alt="TESTY.PL"></a>
        <nav>
            <ul id="menu">
                <li class="menu"><a href="testy.php" style="text-decoration:none" id="head_zal">Powrót</a></li>
                <li class="menu"><a href="wylogowano.php" style="text-decoration:none" id="head_stw">Wyloguj</a></li>
            </ul>
        </nav>
    </div>

    <div id="main">
    <div id="main3">
        <h1>Szczegóły testu</h1>
        <?php foreach ($questions as $question): ?>
            <div class="question">
                <h2>Numer pytania: <?= htmlspecialchars($question['number']) ?></h2>
                <p><?= $question['content'] ?></p>
                <div class="answers">
                    <?php foreach ($question['answers'] as $answer): ?>
                        <div class="answer <?php
                            if (in_array($answer['id'], $question['selected_answers'])) {
                                echo $answer['points'] > 0 ? 'correct-selected' : 'wrong-selected';
                            } elseif ($answer['points'] > 0) {
                                echo 'correct-unselected';
                            } else {
                                echo 'neutral';
                            }
                        ?>">
                            <?= $answer['content'] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
	<script  src="js/hamburger.js"></script>
</body>
</html>
