
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['odpowiedz_id'])) {
    $odpowiedz_id = (int)$_POST['odpowiedz_id'];

    $conn = new mysqli('localhost', 'root', '', 'projekt');
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    // Usuń odpowiedź
    $sql_delete_answer = "DELETE FROM odpowiedzi WHERE ID = ?";
    $stmt = $conn->prepare($sql_delete_answer);
    $stmt->bind_param("i", $odpowiedz_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}
