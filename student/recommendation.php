<?php

$recommendedCareers = [
    "Software Developer",
    "Data Analyst",
    "Cybersecurity Analyst"
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Career Recommendation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-primary shadow-sm">

    <div class="container">

        <a href="../index.php"
           class="navbar-brand fw-bold">

            Career Recommendation System

        </a>

    </div>

</nav>

<!-- Recommendation Section -->
<div class="container py-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold">
            Your Career Recommendations
        </h1>

        <p class="text-muted">

            Based on your responses, the following
            careers may suit you.

        </p>

    </div>

    <div class="row">

        <?php foreach($recommendedCareers as $career): ?>

        <div class="col-md-4 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center p-4">

                    <h4 class="fw-bold text-primary mb-3">

                        <?php echo $career; ?>

                    </h4>

                    <p class="text-muted">

                        This career matches your interests,
                        skills, and preferences based on
                        the assessment completed.

                    </p>

                    <button class="btn btn-outline-primary">

                        View Explanation

                    </button>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>