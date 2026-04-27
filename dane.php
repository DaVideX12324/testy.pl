<?php
session_start();
$pol = mysqli_connect('localhost', 'root', '', 'projekt');
if (!$pol) {
    die(json_encode(['error' => 'Błąd połączenia z bazą danych.']));
}

// Obsługa szczegółowych wyników dla testu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_results') {
    $test_id = isset($_POST['test_id']) ? (int)$_POST['test_id'] : 0;

    if ($test_id <= 0) {
        http_response_code(400);
        die(json_encode(['error' => 'Nieprawidłowe ID testu.']));
    }

    $query = "SELECT w.ID, k.`e-mail` AS email, w.`wynik_pkt` AS points, w.`wynik_%` AS percentage, w.zdane AS passed,
                     k.imie AS first_name, k.nazwisko AS last_name
              FROM wynik w 
              JOIN konta k ON w.`zdajacy_ID` = k.`ID`
              WHERE w.testy_id = ?";
    $stmt = $pol->prepare($query);
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['ID'],
            'email' => $row['email'],
            'points' => $row['points'],
            'percentage' => $row['percentage'],
            'passed' => $row['passed'] ? 'Tak' : 'Nie',
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Standardowe dane dla egzaminatora lub zdającego
$response = [];
if ($_SESSION['user_typ'] === 'Egzaminator') {
    $response['role'] = 'Egzaminator';

    $query = "SELECT ID, nazwa FROM testy WHERE `konta_ID` = ?";
    $stmt = $pol->prepare($query);
    $stmt->bind_param("s", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $tests = [];
    while ($row = $result->fetch_assoc()) {
        $test_id = $row['ID'];

        $score_query = "SELECT AVG(`wynik_%`) AS srednia FROM wynik WHERE testy_id = ?";
        $stmt_avg = $pol->prepare($score_query);
        $stmt_avg->bind_param("i", $test_id);
        $stmt_avg->execute();
        $avg_result = $stmt_avg->get_result();
        $avg_row = $avg_result->fetch_assoc();

        $tests[] = [
            'id' => $test_id,
            'name' => $row['nazwa'],
            'average_score' => $avg_row['srednia'] ? round($avg_row['srednia'], 2) : '---',
        ];
    }

    $response['tests'] = $tests;
} else {
    $response['role'] = 'Zdający';

    $query = "SELECT w.testy_id, w.`wynik_pkt` AS points, w.`wynik_%` AS percentage, w.zdane AS passed,
                     k.imie AS first_name, k.nazwisko AS last_name
              FROM wynik w
              JOIN konta k ON w.`zdajacy_ID` = k.`ID`
              WHERE w.`zdajacy_ID` = ?";
    $stmt = $pol->prepare($query);
    $stmt->bind_param("s", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $test_query = "SELECT nazwa FROM testy WHERE ID = ?";
        $stmt_test = $pol->prepare($test_query);
        $stmt_test->bind_param("i", $row['testy_id']);
        $stmt_test->execute();
        $test_result = $stmt_test->get_result();
        $test_name = $test_result->fetch_assoc()['nazwa'];

        $results[] = [
            'test_id' => $row['testy_id'],
            'test_name' => $test_name,
            'points' => $row['points'],
            'percentage' => $row['percentage'],
            'passed' => $row['passed'] ? 'Tak' : 'Nie',
        ];
    }

    $response['results'] = $results;
}

header('Content-Type: application/json');
echo json_encode($response);

mysqli_close($pol);
