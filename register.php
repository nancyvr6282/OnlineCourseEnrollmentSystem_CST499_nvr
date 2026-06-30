<?php
require_once "db.php";

$message = "";
$alertClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $conn = $db->connect();

    $user_id = $_POST["user_id"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $sql = "INSERT INTO users (user_id, password, first_name, last_name, phone, email)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $user_id, $password, $first_name, $last_name, $phone, $email);

    if ($stmt->execute()) {
        $message = "Registration successful! Your account has been created.";
        $alertClass = "alert-success";
    } else {
        $message = "Registration failed. The User ID may already exist.";
        $alertClass = "alert-danger";
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
    <title>Register - Online Course Enrollment System</title>

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

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-body p-5">

                    <h1 class="text-center text-primary mb-3">
                        New User Registration
                    </h1>

                    <p class="text-center text-muted mb-4">
                        Create your account to begin your online course enrollment journey.
                    </p>

                    <?php if (!empty($message)) { ?>
                        <div class="alert <?php echo $alertClass; ?> text-center">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>

                    <form method="POST" action="register.php">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">User ID</label>
                                <input type="text" name="user_id" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            Register
                        </button>

                    </form>

                    <div class="text-center mt-4">
                        <a href="login.php">Already have an account? Login</a>
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