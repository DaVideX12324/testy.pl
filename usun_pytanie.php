<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pytanie_id'])) {
    $pytanie_id = (int)$_POST['pytanie_id'];

    $conn = new mysqli('localhost', 'root', '', 'projekt');
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    // Usuń odpowiedzi powiązane z pytaniem
    $sql_delete_answers = "DELETE FROM odpowiedzi WHERE pytania_id = ?";
    $stmt = $conn->prepare($sql_delete_answers);
    $stmt->bind_param("i", $pytanie_id);
    $stmt->execute();

    // Usuń pytanie
    $sql_delete_question = "DELETE FROM pytania WHERE ID = ?";
    $stmt = $conn->prepare($sql_delete_question);
    $stmt->bind_param("i", $pytanie_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}
