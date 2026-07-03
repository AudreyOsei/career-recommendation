<?php
session_start();
require_once("../includes/db.php");

if (!isset($conn) || !$conn) {
    die("Database connection failed.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        $error = "Passwords do not match.";
    }

    // Check if email already exists
    else {

        // Use prepared statement to check if email exists
            $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $error = "Email already exists.";
            } else {
                mysqli_stmt_close($stmt);

                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "
            INSERT INTO users
            (
                name,
                email,
                password
            )

            VALUES
            (
                '$name',
                '$email',
                '$hashed_password'
            )
            ";

                if (mysqli_query($conn, $sql)) {

                    header("Location: login.php");
                    exit();

                } else {

                    $error =
                        "Registration failed.";
                }
            }
        }
        }


?>

<!DOCTYPE html>
<html>

<head>

    <title>Register</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div
        class="row justify-content-center mt-5">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body p-5">

                    <h2 class="text-center mb-4">
                        Create Account
                    </h2>

                    <?php if($error != ""): ?>

                        <div class="alert alert-danger">

                            <?php echo $error; ?>

                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label>
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-4">

                            <label>
                                Confirm Password
                            </label>

                            <input
                                type="password"
                                name="confirm_password"
                                class="form-control"
                                required>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Register

                        </button>

                    </form>

                    <div class="text-center mt-3">

                        Already have an account?

                        <a href="login.php">

                            Login

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>