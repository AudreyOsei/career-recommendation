<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Career Recommendation System
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:
            linear-gradient(
                135deg,
                #0d6efd,
                #6f42c1
            );
            min-height:100vh;
        }

        .hero{
            padding-top:120px;
            padding-bottom:120px;
        }

        .feature-card{
            transition:0.3s;
        }

        .feature-card:hover{
            transform:translateY(-10px);
        }

    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-transparent">

    <div class="container">

        <a class="navbar-brand fw-bold">

            Career Recommendation System

        </a>

        <div>

            <a
                href="student/login.php"
                class="btn btn-light me-2">

                Login

            </a>

            <a
                href="student/registration.php"
                class="btn btn-outline-light">

                Register

            </a>

        </div>

    </div>

</nav>

<section class="hero text-center text-white">

    <div class="container">

        <h1 class="display-4 fw-bold mb-4">

            Discover Your Ideal Career Path

        </h1>

        <p class="lead mb-5">

            An AI-powered career recommendation
            platform that helps students and
            professionals discover careers
            that match their interests,
            skills and aspirations.

        </p>

        <a
            href="student/login.php"
            class="btn btn-light btn-lg px-5">

            Get Started

        </a>

    </div>

</section>

<div class="container mb-5">

    <div class="row">

        <div class="col-md-4 mb-4">

            <div
                class="card feature-card shadow border-0 h-100">

                <div class="card-body text-center p-5">

                    <i
                        class="bi bi-ui-checks-grid
                               fs-1 text-primary">

                    </i>

                    <h4 class="mt-4">

                        Interactive Assessment

                    </h4>

                    <p>

                        Complete an intelligent
                        questionnaire designed to
                        understand your strengths
                        and preferences.

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div
                class="card feature-card shadow border-0 h-100">

                <div class="card-body text-center p-5">

                    <i
                        class="bi bi-robot
                               fs-1 text-primary">

                    </i>

                    <h4 class="mt-4">

                        AI Recommendations

                    </h4>

                    <p>

                        Receive personalized
                        career recommendations
                        enhanced by Artificial
                        Intelligence.

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div
                class="card feature-card shadow border-0 h-100">

                <div class="card-body text-center p-5">

                    <i
                        class="bi bi-graph-up-arrow
                               fs-1 text-primary">

                    </i>

                    <h4 class="mt-4">

                        Career Growth

                    </h4>

                    <p>

                        Explore opportunities and
                        make informed decisions
                        about your future career.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<footer
    class="text-center text-white py-4">

    © <?php echo date('Y'); ?>
   Sefakor Y. A. Osei / Career Recommendation System |
    University of Greenwich MSc Project

</footer>

</body>
</html>