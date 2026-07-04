<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: student/login.php");
    exit();
}

require_once("includes/db.php");

if (!isset($conn) || !$conn) {
    die("Database connection failed.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <title>Career Recommendation System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background-color:#f8f9fa;
        }

        .hero-section{
            padding:100px 0;
        }

        .feature-card{
            border:none;
            border-radius:15px;
            transition:0.3s ease;
        }

        .feature-card:hover{
            transform:translateY(-5px);
        }

        footer{
            background:#0d6efd;
            color:white;
            padding:20px;
        }

    </style>

</head>

<body>
    
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">

            <a class="navbar-brand fw-bold" href="#">Career Recommendation System</a>

            <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">
                        About
                    </a>
                </li>

               <li class="nav-item">
    <a class="nav-link"
       href="student/questionnaire.php">

        Assessment

    </a>
</li>

<li class="nav-item">
    <a class="nav-link"
       href="student/history.php">

        History

    </a>
</li>

<li class="nav-item">
    <a class="nav-link"
       href="student/profile.php">

        Profile

    </a>
</li>

<li class="nav-item">
    <a class="nav-link"
       href="student/feedback.php">

        Feedback

    </a>
</li>

<li class="nav-item">
    <a class="nav-link text-warning fw-bold"
       href="student/logout.php">

        Logout

    </a>
</li>

            </ul>

        </div>
    </div>
</nav>

    <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6">

                <h2 class="fw-bold">

Welcome Back,

<span class="text-primary">

<?= htmlspecialchars($_SESSION['name']); ?>

</span>

👋

</h2>

<p class="text-muted">

Choose what you would like to do today.

</p>

</div>

<div class="row g-4">

<div class="col-md-3">

<a href="student/questionnaire.php"
class="text-decoration-none">

<div class="card feature-card shadow text-center p-4">

<i class="bi bi-ui-checks-grid
text-primary fs-1"></i>

<h5 class="mt-3">

Start Assessment

</h5>

</div>

</a>

</div>

<div class="col-md-3">

<a href="student/history.php"
class="text-decoration-none">

<div class="card feature-card shadow text-center p-4">

<i class="bi bi-clock-history
text-success fs-1"></i>

<h5 class="mt-3">

Recommendation History

</h5>

</div>

</a>

</div>

<div class="col-md-3">

<a href="student/profile.php"
class="text-decoration-none">

<div class="card feature-card shadow text-center p-4">

<i class="bi bi-person-circle
text-warning fs-1"></i>

<h5 class="mt-3">

My Profile

</h5>

</div>

</a>

</div>

<div class="col-md-3">

<a href="student/feedback.php"
class="text-decoration-none">

<div class="card feature-card shadow text-center p-4">

<i class="bi bi-star-fill
text-danger fs-1"></i>

<h5 class="mt-3">

Feedback

</h5>

</div>

</a>

</div>
<br><br><br><br><br><br><br><br><br><br><br>
                <div class="row align-items-center">

            <!-- Left Side -->
            <div class="col-md-6">

                <h1 class="fw-bold display-5 mb-4">
                    Discover Your Ideal Career Path
                </h1>

                <p class="lead text-muted">
                    Receive intelligent and explainable career
                    recommendations based on your interests,
                    strengths, preferences, and personal responses.

                    The system analyses your inputs to suggest
                    relevant career paths and explain why they
                    may be suitable for you.
                </p>

            </div>

            <!-- Right Side -->
            <div class="col-md-6 text-center">

                <img src="https://cdn.sketchbubble.com/pub/media/catalog/product/optimized1/c/f/cfe9f73480096f097d405903cdaadbac0185c9dadba584610101c8d3b0d68560/career-journey-slide2.png"
                     class="img-fluid"
                     width="350"
                     alt="Career Illustration">

            </div>

        </div>

        </div>

    </section>

<!-- Features -->
<section class="py-5 bg-white">

    <div class="container text-center">

        <h2 class="fw-bold mb-5">
            System Features
        </h2>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="card shadow-sm feature-card p-4">

                    <i class="bi bi-person-check-fill
                    text-primary fs-1 mb-3"></i>

                    <h5 class="fw-bold">
                        Personalized Recommendations
                    </h5>

                    <p class="text-muted">
                        Career suggestions based on user interests,
                        skills, and preferences.
                    </p>

                </div>
            </div>

            <div class="col-md-4">

                <div class="card shadow-sm feature-card p-4">

                    <i class="bi bi-lightbulb-fill
                    text-warning fs-1 mb-3"></i>

                    <h5 class="fw-bold">
                        Explainable Guidance
                    </h5>

                    <p class="text-muted">
                        Understand why a career is recommended
                        through clear explanations.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm feature-card p-4">

                    <i class="bi bi-bar-chart-fill
                    text-success fs-1 mb-3"></i>

                    <h5 class="fw-bold">
                        Skills Matching
                    </h5>

                    <p class="text-muted">
                        Match personal strengths and interests
                        with suitable career paths.
                    </p>

                </div>

            </div>

        </div>
    </div>
</section>

<!-- About -->
<section id="about" class="py-5">

    <div class="container text-center">

        <h2 class="fw-bold mb-4">
            About the System
        </h2>

        <p class="text-muted col-md-8 mx-auto">

            This system helps undergraduate students make better
            career decisions by providing intelligent and
            explainable recommendations based on individual
            interests, preferences, and strengths.

        </p>

    </div>
</section>

<!-- Footer -->
<footer class="text-center">

    <p class="mb-0">
        © 2026 Career Recommendation System |
        Final Year Project
    </p>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>