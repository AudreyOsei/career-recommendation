<?php
session_start();

include("../includes/db.php");

global $conn;

$careers = require("../database/career_data.php");

require("../api/gemini.php");

if (!isset($_SESSION['career_data'])) {
    header("Location: questionnaire.php");
    exit();
}

$userData = $_SESSION['career_data'];

$interests = $userData['interest'] ?? [];
$skill = $userData['skill'] ?? '';
$environment = $userData['environment'] ?? '';
$goals = $userData['goal'] ?? [];

$recommendedCareers = [];

$recommendedCareers = [];

foreach ($careers as $career) {

    // Initialize score for every career
    $score = 0;
    $reasons = [];

    // Interest match
    if (
        (is_string($career['category']) &&
        in_array($career['category'], $interests))

        ||

        (is_array($career['category']) &&
        count(array_intersect($career['category'], $interests)) > 0)
    ) {

        $score += 40;

        $reasons[] =
            "you selected " .
            implode(", ", $interests) .
            " as an area of interest";
    }

    // Skill match
    if (in_array($skill, $career['skills'])) {

        $score += 30;

        $reasons[] =
            "your strongest skill is " .
            $skill;
    }

    // Environment match
    if (in_array($environment, $career['environment'])) {

        $score += 20;

        $reasons[] =
            "you prefer a " .
            $environment .
            " work environment";
    }

    // Goal match
    if (!empty($goals)) {

        if (
            in_array("High Salary", $goals)
            &&
            in_array($career['name'], [
                "Software Developer",
                "AI / Machine Learning Engineer",
                "Financial Analyst",
                "Cybersecurity Analyst",
                "Project Manager"
            ])
        ) {

            $score += 10;
        }

        $reasons[] =
            "you identified " .
            implode(", ", $goals) .
            " as important career goals";
    }

    // Save recommendation
    if ($score >= 40) {

       $career['score'] = $score;

$ruleExplanation =
    "This career was recommended because "
    . implode(", ", $reasons) . ".";

// Gemini explanation
$career['explanation'] = $ruleExplanation;

$recommendedCareers[] = $career;
    }
}

// Sort highest score first
usort($recommendedCareers, function($a, $b){
    return $b['score'] - $a['score'];
});

// Top 5 only
$recommendedCareers = array_slice(
    $recommendedCareers,
    0,
    5
);

// Enhance top 2 recommendations with Gemini
for ($i = 0; $i < min(2, count($recommendedCareers)); $i++) {

    $recommendedCareers[$i]['explanation'] =
        generateCareerExplanation(
            $recommendedCareers[$i]['name'],
            $userData,
            $recommendedCareers[$i]['explanation']
        );
}

$response_id =
    $_SESSION['response_id'] ?? 0;

    mysqli_query(
    $conn,
    "DELETE FROM recommendations
     WHERE response_id = '$response_id'"
);


foreach ($recommendedCareers as $career) {

    $career_name =
        mysqli_real_escape_string(
            $conn,
            $career['name']
        );

    $match_score =
        $career['score'];

    $explanation =
        mysqli_real_escape_string(
            $conn,
            $career['explanation']
        );

    $sql = "
    INSERT INTO recommendations
    (
        response_id,
        match_score,
        career_name,
        explanation
    )

    VALUES
    (
        '$response_id',
        '$match_score',
        '$career_name',
        '$explanation'
    )
    ";

    mysqli_query($conn, $sql);

  if (mysqli_query($conn, $sql)) {


} else {

    die(
        "Recommendation Error: "
        . mysqli_error($conn)
    );
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Career Recommendations</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container">

        <a href="../index.php"
           class="navbar-brand fw-bold">

            Career Recommendation System

        </a>

    </div>
</nav>

<div class="container py-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold">
            Your Career Recommendations
        </h1>

        <p class="text-muted">

            Based on your interests,
            skills, preferences and responses,
            the following careers may suit you.

        </p>

    </div>

    <div class="row">

        <?php foreach($recommendedCareers as $career): ?>

        <div class="col-md-4 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body p-4 text-center">

                    <h4 class="fw-bold text-primary">

                        <?php echo $career['name']; ?>

                    </h4>

                    <p class="text-muted mt-3">

                        Match Score:
                        <strong>
                            <?php echo $career['score']; ?>%
                        </strong>

                    </p>

                    <p class="text-muted">

                          <?php echo $career['explanation']; ?>

                    </p>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>