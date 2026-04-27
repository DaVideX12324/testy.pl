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

// Aktualizacja szczegółów testu
if (isset($_POST['test'])) {
    $test_id = (int)$_POST['test_id'];
    $nazwa = $conn->real_escape_string($_POST['test']['nazwa']);
    $kategoria = (int)$_POST['test']['kategoria'];

    $sql = "UPDATE testy SET nazwa = ?, Kategorie_id = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $nazwa, $kategoria, $test_id);
    $stmt->execute();
    $stmt->close();
}

// Aktualizacja pytań
if (isset($_POST['questions'])) {
    foreach ($_POST['questions'] as $question) {
        $id = (int)$question['id'];
        $zawartosc = $conn->real_escape_string($question['zawartosc']);

        $sql = "UPDATE pytania SET zawartosc = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $zawartosc, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Aktualizacja odpowiedzi
if (isset($_POST['answers'])) {
    foreach ($_POST['answers'] as $answer) {
        $id = (int)$answer['id'];
        $zawartosc = $conn->real_escape_string($answer['zawartosc']);
        $punkty = (int)$answer['punkty'];

        $sql = "UPDATE odpowiedzi SET zawartosc = ?, punkty = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $zawartosc, $punkty, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Dodanie nowych pytań
if (isset($_POST['new_questions']['zawartosc'])) {
    foreach ($_POST['new_questions']['zawartosc'] as $new_question) {
        if (!empty($new_question)) {
            $zawartosc = $conn->real_escape_string($new_question);

            $sql = "INSERT INTO pytania (testy_id, zawartosc) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $test_id, $zawartosc);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Dodanie nowych odpowiedzi
if (isset($_POST['new_answers'])) {
    foreach ($_POST['new_answers'] as $question_id => $new_answers) {
        foreach ($new_answers['zawartosc'] as $index => $zawartosc) {
            if (!empty($zawartosc)) {
                $punkty = (int)$new_answers['punkty'][$index];
                $zawartosc = $conn->real_escape_string($zawartosc);

                $sql = "INSERT INTO odpowiedzi (pytania_id, zawartosc, punkty) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isi", $question_id, $zawartosc, $punkty);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

header("Location: edytuj_test.php?test_id=$test_id");
$conn->close();
exit;
?>
