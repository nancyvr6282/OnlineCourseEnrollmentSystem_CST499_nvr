<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$conn = $db->connect();

$user_id = $_SESSION["id"];

$sql = "SELECT enrollments.enrollment_id,
               courses.course_code,
               courses.course_name,
               courses.semester,
               courses.credits
        FROM enrollments
        INNER JOIN courses
        ON enrollments.course_id = courses.course_id
        WHERE enrollments.user_id = ?
        ORDER BY courses.semester, courses.course_code";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Registered Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1 class="text-center text-primary mb-4">My Registered Classes</h1>

    <p class="text-center">
        Student: <strong><?php echo $_SESSION["first_name"]; ?></strong>
    </p>

    <div class="card shadow">
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
                    <?php if ($result->num_rows > 0) { ?>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row["course_code"]; ?></td>
                                <td><?php echo $row["course_name"]; ?></td>
                                <td><?php echo $row["semester"]; ?></td>
                                <td><?php echo $row["credits"]; ?></td>
                                <td>
                                    <form method="POST" action="delete_class.php">
                                        <input type="hidden" name="enrollment_id" value="<?php echo $row["enrollment_id"]; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Drop Course
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                You are not registered for any classes yet.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="text-center mt-4">
                <a href="register_classes.php" class="btn btn-primary">Add More Courses</a>
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>