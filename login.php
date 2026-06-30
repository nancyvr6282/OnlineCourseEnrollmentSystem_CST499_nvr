<?php
session_start();
require_once "db.php";

$message = "";
$alertClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $conn = $db->connect();

    $user_id = $_POST["user_id"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["id"] = $user["id"];
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["first_name"] = $user["first_name"];

            header("Location: register_classes.php");
            exit();
        } else {
            $message = "Invalid password. Please try again.";
            $alertClass = "alert-danger";
        }
    } else {
        $message = "User ID not found. Please register first.";
        $alertClass = "alert-warning";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Course Enrollment System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            Rivera Edu-Tech Innovations
        </a>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">

                    <h1 class="text-center text-primary mb-3">User Login</h1>

                    <p class="text-center text-muted mb-4">
                        Access your online course enrollment account.
                    </p>

                    <?php if (!empty($message)) { ?>
                        <div class="alert <?php echo $alertClass; ?> text-center">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>

                    <form method="POST" action="login.php">

                        <div class="mb-3">
                            <label class="form-label">User ID</label>
                            <input type="text" name="user_id" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-4">
                        <a href="register.php">Create a new account</a>
                        <br>
                        <a href="index.php">Back to Home</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>