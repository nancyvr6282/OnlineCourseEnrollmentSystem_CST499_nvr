<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();
    $conn = $db->connect();

    $enrollment_id = $_POST["enrollment_id"];
    $user_id = $_SESSION["id"];

    $sql = "DELETE FROM enrollments
            WHERE enrollment_id = ?
            AND user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $enrollment_id, $user_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

header("Location: my_classes.php");
exit();
?>