<?php

include("../includes/header.php");
include("../includes/sidebar.php");

/* ==========================================
   System Statistics
========================================== */

if (!isset($conn)) {
    die("Database connection error: \$conn is not defined.");
}

$totalUsers = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM users")
)['total'];

$totalAssessments = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM assessment_responses")
)['total'];

$totalRecommendations = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM recommendations")
)['total'];

$totalFeedback = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM feedback")
)['total'];

$averageRating = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT AVG(rating) average_rating FROM feedback")
)['average_rating'];

$sql = "

SELECT

career_name,

COUNT(*) total

FROM recommendations

GROUP BY career_name

ORDER BY total DESC

LIMIT 1

";

$topCareer = mysqli_fetch_assoc(mysqli_query($conn,$sql));

?>

<div class="d-flex justify-content-between align-items-center mb-5">

<div>

<h2 class="fw-bold">

<i class="bi bi-bar-chart-fill text-primary"></i>

Reports & Analytics

</h2>

<p class="text-muted">

View overall system performance and recommendation statistics.

</p>

</div>

</div>

<div class="row g-4 mb-5">

<div class="col-md-3">

<div class="card text-center">

<div class="card-body">

<h2 class="text-primary">

<?= $totalUsers ?>

</h2>

<p>Users</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center">

<div class="card-body">

<h2 class="text-success">

<?= $totalAssessments ?>

</h2>

<p>Assessments</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center">

<div class="card-body">

<h2 class="text-warning">

<?= $totalRecommendations ?>

</h2>

<p>Recommendations</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center">

<div class="card-body">

<h2 class="text-danger">

<?= $totalFeedback ?>

</h2>

<p>Feedback</p>

</div>

</div>

</div>

</div>

<div class="card shadow border-0 mb-5">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

System Summary

</h5>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<h6>

⭐ Average User Rating

</h6>

<h2>

<?= number_format($averageRating,1); ?>/5

</h2>

</div>

<div class="col-md-6">

<h6>

🏆 Most Recommended Career

</h6>

<h2>

<?= htmlspecialchars($topCareer['career_name']); ?>

</h2>

</div>

</div>

</div>

</div>

<a
href="export_report.php"
class="btn btn-primary">

<i class="bi bi-download"></i>

Export Administrative Report

</a>
<?php

include("../includes/footer.php");

?>