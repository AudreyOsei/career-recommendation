<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../includes/db.php';

$user_id = $_SESSION['user_id'];



$sql = "
SELECT *
FROM users
WHERE user_id = '$user_id'
";

$result = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($result);


$sql = "
SELECT COUNT(*) AS total
FROM assessment_responses
WHERE user_id='$user_id'
";

$result = mysqli_query($conn, $sql);

$totalAssessments =
mysqli_fetch_assoc($result)['total'];

/*-----------------------------------------
Recommendations Generated
------------------------------------------*/

$sql = "

SELECT COUNT(*) AS total

FROM recommendations

INNER JOIN assessment_responses

ON assessment_responses.id =
recommendations.response_id

WHERE assessment_responses.user_id='$user_id'

";

$result = mysqli_query($conn, $sql);

$totalRecommendations =
mysqli_fetch_assoc($result)['total'];

/*-----------------------------------------
Highest Match Score
------------------------------------------*/

$sql = "

SELECT MAX(match_score) AS highest

FROM recommendations

INNER JOIN assessment_responses

ON assessment_responses.id =
recommendations.response_id

WHERE assessment_responses.user_id='$user_id'

";

$result = mysqli_query($conn, $sql);

$highestScore =
mysqli_fetch_assoc($result)['highest'];

/*-----------------------------------------
Latest Assessment
------------------------------------------*/

$sql = "

SELECT MAX(created_at) AS latest

FROM assessment_responses

WHERE user_id='$user_id'

";

$result = mysqli_query($conn, $sql);

$latestAssessment =
mysqli_fetch_assoc($result)['latest'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{
    background:#f5f7fb;
}

.profile-card,
.info-card{
    border:none;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
}

.avatar{

    width:120px;
    height:120px;

    background:#0d6efd;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    color:white;

    font-size:45px;

    font-weight:bold;

    margin:auto;

}

</style>

</head>

<body>

<nav class="navbar navbar-dark bg-primary shadow">

<div class="container">

<a href="../home.php"
class="navbar-brand fw-bold">

Career Recommendation System

</a>

<a href="../home.php"
class="btn btn-light">

Dashboard

</a>

</div>

</nav>

<div class="container py-5">

<!-- Profile Header -->

<div class="card profile-card mb-4">

<div class="card-body text-center">

<div class="avatar">

<?= strtoupper(substr($user['name'],0,1)); ?>

</div>

<h2 class="mt-3">

<?= htmlspecialchars($user['name']); ?>

</h2>

<p class="text-muted">

Career Recommendation System User

</p>

</div>

</div>

<div class="row">

<!-- Personal Information -->

<div class="col-lg-6 mb-4">

<div class="card info-card h-100">

<div class="card-body">

<h4 class="mb-4">

<i class="bi bi-person-fill text-primary"></i>

Personal Information

</h4>

<p>

<i class="bi bi-person"></i>

<strong>Name:</strong>

<?= htmlspecialchars($user['name']); ?>

</p>

<p>

<i class="bi bi-envelope"></i>

<strong>Email:</strong>

<?= htmlspecialchars($user['email']); ?>

</p>

<p>

<i class="bi bi-calendar"></i>

<strong>Member Since:</strong>

<?= date("d M Y", strtotime($user['created_at'])); ?>

</p>

</div>

</div>

</div>

<!-- Statistics -->

<div class="col-lg-6 mb-4">

<div class="card info-card h-100">

<div class="card-body">

<h4 class="mb-4">

<i class="bi bi-bar-chart-fill text-success"></i>

Assessment Statistics

</h4>

<p>

📋 Total Assessments

<strong class="float-end">

<?= $totalAssessments; ?>

</strong>

</p>

<p>

🎯 Recommendations

<strong class="float-end">

<?= $totalRecommendations; ?>

</strong>

</p>

<p>

⭐ Highest Match Score

<strong class="float-end">

<?= $highestScore ?? 0; ?>%

</strong>

</p>

<p>

🕒 Latest Assessment

<strong class="float-end">

<?= $latestAssessment
? date("d M Y", strtotime($latestAssessment))
: "None"; ?>

</strong>

</p>

</div>

</div>

</div>

</div>

<!-- AI Summary -->

<div class="card info-card mb-4">

<div class="card-body">

<h4>

<i class="bi bi-robot text-primary"></i>

AI Career Summary

</h4>

<hr>

<p>

The system analyses your interests,
skills, preferences and written responses
to generate intelligent and explainable
career recommendations.

</p>

<p>

Complete more assessments over time to
receive increasingly personalised career guidance.

</p>

</div>

</div>

<!-- Account Settings -->

<div class="card info-card">

<div class="card-body">

<h4 class="mb-4">

<i class="bi bi-gear-fill"></i>

Account Settings

</h4>

<div class="d-flex gap-3 flex-wrap">

<a href="edit_profile.php"
class="btn btn-primary">

<i class="bi bi-pencil-square"></i>

Edit Profile

</a>

<a href="change_password.php"
class="btn btn-warning">

<i class="bi bi-key-fill"></i>

Change Password

</a>

<a href="logout.php"
class="btn btn-outline-danger ms-auto">

<i class="bi bi-box-arrow-right"></i>

Logout

</a>

</div>

</div>

</div>

</div>

</body>

</html>