<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Enrollment - Online Course Enrollment System</title>

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
<br>
<p class="text-center text-muted mb-4">
    <h3 class="text-center">Welcome, <?php echo $_SESSION["first_name"]; ?>. Select a semester and choose from available online courses.</h3>
</p>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0">
        <div class="card-body p-5">

            <h1 class="text-center text-primary mb-3">
                Course Enrollment
            </h1>

            <p class="text-center text-muted mb-4">
                Select a semester and choose from available online courses.
            </p>

            <form method="POST" action="enrollment.php">

                <div class="mb-4">
                    <label class="form-label">Select Semester</label>
                    <select name="semester" class="form-select" required>
                        <option value="">Choose a semester</option>
                        <option value="Spring">Spring</option>
                        <option value="Summer">Summer</option>
                        <option value="Fall">Fall</option>
                    </select>
                </div>

                <h4 class="mb-3">Available Courses</h4>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="courses[]" value="CST101">
                    <label class="form-check-label">
                        CST101 - Introduction to Computer Software Technology
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="courses[]" value="CST210">
                    <label class="form-check-label">
                        CST210 - Web Development Fundamentals
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="courses[]" value="CST310">
                    <label class="form-check-label">
                        CST310 - Database-Driven Web Applications
                    </label>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="courses[]" value="CST499">
                    <label class="form-check-label">
                        CST499 - Computer Software Technology Capstone
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    Submit Enrollment
                </button>

            </form>

           <div class="text-center mt-4">

    <a href="logout.php" class="btn btn-danger">
        Logout
    </a>

</div>

        </div>
    </div>
</div>

</body>
</html>