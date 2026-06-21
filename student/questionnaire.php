<?php
session_start();

include("../includes/db.php");

global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION['career_data'] = [

        'fullname' => $_POST['fullname'] ?? '',
        'course' => $_POST['course'] ?? '',
        'level' => $_POST['level'] ?? '',
        'age' => $_POST['age'] ?? '',

        'interest' => $_POST['interest'] ?? [],
        'skill' => $_POST['skill'] ?? '',
        'environment' => $_POST['environment'] ?? '',

        'activities' => $_POST['activities'] ?? '',
        'career_interest' => $_POST['career_interest'] ?? '',
        'challenges' => $_POST['challenges'] ?? '',

        'goal' => $_POST['goal'] ?? []

    ];

    // Save assessment to database

    $fullname =
        $_SESSION['career_data']['fullname'];

    $course =
        $_SESSION['career_data']['course'];

    $level =
        $_SESSION['career_data']['level'];

    $age =
        $_SESSION['career_data']['age'];

    $interest =
        implode(
            ", ",
            $_SESSION['career_data']['interest']
        );

    $skill =
        $_SESSION['career_data']['skill'];

    $environment =
        $_SESSION['career_data']['environment'];

    $goals =
        implode(
            ", ",
            $_SESSION['career_data']['goal']
        );

    $activities =
        $_SESSION['career_data']['activities'];

    $career_interest =
        $_SESSION['career_data']['career_interest'];

    $challenges =
        $_SESSION['career_data']['challenges'];
    
    $activities =
    mysqli_real_escape_string(
        $conn,
        $activities
    );

$career_interest =
    mysqli_real_escape_string(
        $conn,
        $career_interest
    );

$challenges =
    mysqli_real_escape_string(
        $conn,
        $challenges
    );

    $sql = "
    INSERT INTO assessment_responses (
        fullname,
        course,
        level,
        age,
        interest,
        skill,
        environment,
        goals,
        activities,
        career_interest,
        challenges
    )

    VALUES (
        '$fullname',
        '$course',
        '$level',
        '$age',
        '$interest',
        '$skill',
        '$environment',
        '$goals',
        '$activities',
        '$career_interest',
        '$challenges'
    )
    ";

if (mysqli_query($conn, $sql)) {

    $_SESSION['response_id'] =
        mysqli_insert_id($conn);

    header("Location: assessment_success.php");
    exit();

} else {

    die("Database Error: " . mysqli_error($conn));
}

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career AssessmentQuestionnaire</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-primary shadow-sm">

    <div class="container">

        <a href="../index.php" class="navbar-brand fw-bold">
            Career Recommendation System
        </a>

    </div>

</nav>

<!-- Questionnaire Section -->
<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card shadow border-0">

                <div class="card-body p-5">

                    <h2 class="fw-bold text-center mb-3">
                        Career Assessment Questionnaire
                    </h2>

                    <p class="text-muted text-center mb-5">
                       This assessment collects information
                       about your interests, strengths,
                       preferences, and career expectations
                       to generate personalized and explainable
                       career recommendations.
                    </p>

                    <form method="POST">

                        <!-- SECTION 1 -->
                        <h4 class="fw-bold text-primary mb-4">
                            1. Personal Information
                        </h4>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Full Name (Optional)
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="fullname">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Course of Study
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="course"
                                       placeholder="e.g Computer Science">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Level of Study
                                </label>

                                <select class="form-select"
                                        name="level">

                                    <option>Select Level</option>
                                    <option>Diploma</option>
                                    <option>Advanced Diploma</option>
                                    <option>Undergraduate</option>
                                    <option>Postgraduate</option>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Age Range
                                </label>

                                <select class="form-select"
                                        name="age">

                                    <option>Select Age</option>
                                    <option>18–20</option>
                                    <option>21–25</option>
                                    <option>26–30</option>
                                    <option>30+</option>

                                </select>
                            </div>

                        </div>

                        <hr class="my-5">

                        <!-- SECTION 2 -->
                        <h4 class="fw-bold text-primary mb-4">
                            2. Career Interests
                        </h4>

                        <label class="form-label fw-bold mb-3">
                            Which areas interest you most?
                        </label>

                        <div class="row">

                            <div class="col-md-4">
                                <input type="checkbox" name="interest[]" value="Technology">
                                Technology
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="interest[]" value="Business">
                                Business
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="interest[]" value="Healthcare">
                                Healthcare
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="interest[]" value="Education">
                                Education
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="interest[]" value="Creative Arts">
                                Creative Arts
                            </div>

                        </div>

                        <hr class="my-5">

                        <!-- SECTION 3 -->
                        <h4 class="fw-bold text-primary mb-4">
                            3. Skills and Preferences
                        </h4>

                        <label class="form-label fw-bold">
                            What best describes your strongest skill?
                        </label>

                        <select class="form-select mb-4"
                                name="skill">

                            <option>Select Option</option>
                            <option>Problem Solving</option>
                            <option>Leadership</option>
                            <option>Communication</option>
                            <option>Creativity</option>
                            <option>Analytical Thinking</option>

                        </select>

                        <label class="form-label fw-bold">
                            Preferred work environment
                        </label>

                        <select class="form-select"
                                name="environment">

                            <option>Select Option</option>
                            <option>Office</option>
                            <option>Remote</option>
                            <option>Flexible</option>
                            <option>Field Work</option>

                        </select>

                        <hr class="my-5">

                        <!-- SECTION 4 -->
                        <h4 class="fw-bold text-primary mb-4">
                            4. Personal Reflection
                        </h4>

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                What activities do you enjoy most?
                            </label>

                            <textarea class="form-control"
                                      rows="4"
                                      name="activities"></textarea>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                What career are you currently considering?
                            </label>

                            <textarea class="form-control"
                                      rows="4"
                                      name="career_interest"></textarea>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                What challenges do you face in choosing a career?
                            </label>

                            <textarea class="form-control"
                                      rows="4"
                                      name="challenges"></textarea>

                        </div>

                        <hr class="my-5">

                        <!-- SECTION 5 -->
                        <h4 class="fw-bold text-primary mb-4">
                            5. Career Goals
                        </h4>

                        <label class="form-label fw-bold mb-3">
                            What matters most to you in a career?
                        </label>

                        <div class="row">

                            <div class="col-md-4">
                                <input type="checkbox" name="goal[]" value="High Salary">
                                High Salary
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="goal[]" value="Flexibility">
                                Flexibility
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="goal[]" value="Helping Others">
                                Helping Others
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="goal[]" value="Creativity">
                                Creativity
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="goal[]" value="Leadership">
                                Leadership
                            </div>

                            <div class="col-md-4">
                                <input type="checkbox" name="goal[]" value="Job Security">
                                Job Security
                            </div>

                        </div>

                        <div class="text-center mt-5">

                            <button class="btn btn-primary btn-lg px-5"
                                    type="submit">

                                Submit Assessment

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>