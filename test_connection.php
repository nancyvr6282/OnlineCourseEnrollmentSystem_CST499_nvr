<?php
require_once "db.php";

$db = new Database();
$conn = $db->connect();

echo "Database connected successfully!";
?>