<?php

session_start();
// ensure correct path and required inclusion of DB connection
require_once __DIR__ . '/../includes/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!isset($conn) || !$conn) {
        $error = "Database connection error.";
    } else {

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) == 1) {

            $user = mysqli_fetch_assoc($result);

        if (
            password_verify(
                $password,
                $user['password']
            )
        ) {

            $_SESSION['user_id'] =
                $user['user_id'];

            $_SESSION['name'] =
                $user['name'];

            $_SESSION['email'] =
                $user['email'];

            header("Location: ../home.php");
            exit();
        }
        else {
            $error = "Incorrect password.";
        }
        }
        else {
            $error = "Email does not exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body p-5">

                    <h2 class="text-center mb-4">

                        Login

                    </h2>

                    <?php if($error != ""): ?>

                        <div class="alert alert-danger">

                            <?php echo $error; ?>

                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-4">

                            <label>Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Login

                        </button>

                    </form>

                    <div class="text-center mt-3">

                        Don't have an account?

                        <a href="register.php">

                            Register

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>