<?php
session_start();

require_once __DIR__ . "/../includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['fullname'];

            header("Location: pages/dashboard.php");
            exit();

        } else {

            $error = "Incorrect password.";

        }

    } else {

        $error = "Administrator account not found.";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Administrator Login</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{

background:#f4f6f9;

display:flex;

justify-content:center;

align-items:center;

height:100vh;

}

.login-card{

width:420px;

border:none;

border-radius:20px;

box-shadow:0 15px 35px rgba(0,0,0,.1);

}

.logo{

font-size:60px;

color:#0d6efd;

}

</style>

</head>

<body>

<div class="card login-card">

<div class="card-body p-5">

<div class="text-center mb-4">

<i class="bi bi-shield-lock-fill logo"></i>

<h3 class="fw-bold mt-3">

Administrator Login

</h3>

<p class="text-muted">

Career Recommendation System

</p>

</div>

<?php if($error!=""): ?>

<div class="alert alert-danger">

<?= $error ?>

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
class="btn btn-primary w-100">

<i class="bi bi-box-arrow-in-right"></i>

Login

</button>

</form>

</div>

</div>

</body>

</html>