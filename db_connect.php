<?php
$conn = new mysqli("localhost", "root", "", "online_course_enrollment");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>