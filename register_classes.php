<?php
session_start();
require_once "db.php";

$db = new Database();
$conn = $db->connect();

$message = "";
$alertClass = "";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST["course_id"];

    $checkSql = "SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $user_id, $course_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $message = "You are already registered for this course.";
        $alertClass = "alert-warning";
    } else {
        $sql = "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $course_id);

        if ($stmt->execute()) {
            $message = "Course registration successful!";
            $alertClass = "alert-success";
        } else {
            $message = "Course registration failed.";
            $alertClass = "alert-danger";
        }

        $stmt->close();
    }

    $checkStmt->close();
}

$courses = $conn->query("SELECT * FROM courses ORDER BY semester, course_code");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register for Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-primary text-center mb-4">Register for Classes</h1>

    <?php if (!empty($message)) { ?>
        <div class="alert <?php echo $alertClass; ?> text-center">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <div class="card shadow border-0">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Semester</th>
                        <th>Credits</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $courses->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row["course_code"]; ?></td>
                            <td><?php echo $row["course_name"]; ?></td>
                            <td><?php echo $row["semester"]; ?></td>
                            <td><?php echo $row["credits"]; ?></td>
                            <td>
                                <form method="POST" action="register_classes.php">
                                    <input type="hidden" name="course_id" value="<?php echo $row["course_id"]; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Enroll</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="text-center mt-4">
                <a href="my_classes.php" class="btn btn-success">View My Classes</a>
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>