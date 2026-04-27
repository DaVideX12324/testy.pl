<?php
session_start();
$pol = mysqli_connect('localhost', 'root', '', 'projekt');
if (!$pol) {
    die(json_encode(['error' => 'Błąd połączenia z bazą danych.']));
}

$response = [];
if ($_SESSION['user_typ'] == "Egzaminator") {
    $response['role'] = 'Egzaminator';

    $query = "SELECT `ID`, `nazwa` FROM `testy` WHERE `e-mail`='" . $_SESSION['user_e-mail'] . "'";
    $result = mysqli_query($pol, $query);

    $tests = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $test_id = $row['ID'];
        $test_name = $row['nazwa'];

        $score_query = "SELECT AVG(`wynik_%`) AS srednia, COUNT(*) AS liczba FROM `wynik` WHERE `testy_id`='$test_id'";
        $score_result = mysqli_query($pol, $score_query);
        $score_data = mysqli_fetch_assoc($score_result);

        $tests[] = [
            'id' => $test_id,
            'name' => $test_name,
            'average_score' => $score_data['srednia'] ? round($score_data['srednia'], 2) : '---',
        ];
    }

    $response['tests'] = $tests;
} else {
    $response['role'] = 'Zdający';

    $query = "SELECT `testy_id`, `wynik_pkt`, `wynik_%`, `zdane` FROM `wynik` WHERE `e-mail`='" . $_SESSION['user_e-mail'] . "'";
    $result = mysqli_query($pol, $query);

    $results = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $test_query = "SELECT `nazwa` FROM `testy` WHERE `ID`='" . $row['testy_id'] . "'";
        $test_result = mysqli_query($pol, $test_query);
        $test_name = mysqli_fetch_row($test_result)[0];

        $results[] = [
            'test_id' => $row['testy_id'],
            'test_name' => $test_name,
            'points' => $row['wynik_pkt'],
            'percentage' => $row['wynik_%'],
            'passed' => $row['zdane'] ? 'Tak' : 'Nie',
        ];
    }

    $response['results'] = $results;
}

mysqli_close($pol);

header('Content-Type: application/json');
echo json_encode($response);
