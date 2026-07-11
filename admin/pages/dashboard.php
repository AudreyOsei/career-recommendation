<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../includes/header.php");
include("../includes/sidebar.php");

if (!isset($conn) || !$conn) {
    die("Database connection error");
}

?>

<!Dashboard Header>

<div class="d-flex justify-content-between align-items-center mb-5">

    <div>

        <h2 class="fw-bold mb-2">

            Administrator Dashboard

        </h2>

        <p class="text-muted mb-1">

            Welcome back,

            <strong class="text-primary">

                <?= htmlspecialchars($_SESSION['admin_name']); ?>

            </strong>

        </p>

        <p class="text-secondary">

            Monitor users, assessments, career recommendations, AI insights and overall system activities.

        </p>

    </div>

    <div>

        <span class="badge bg-primary fs-6 px-4 py-3">

            <?= date("l, d F Y"); ?>

        </span>

    </div>

</div>

<?php

/* Dashboard Statistics */

$sql = "SELECT COUNT(*) AS total FROM users";
$result = mysqli_query($conn,$sql);
$totalUsers = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM assessment_responses";
$result = mysqli_query($conn,$sql);
$totalAssessments = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM recommendations";
$result = mysqli_query($conn,$sql);
$totalRecommendations = mysqli_fetch_assoc($result)['total'];

$sql = "SELECT COUNT(*) AS total FROM feedback";
$result = mysqli_query($conn,$sql);
$totalFeedback = mysqli_fetch_assoc($result)['total'];

?>

<div class="row g-4">

<!-- Users -->

<div class="col-lg-3 col-md-6">

<div class="card h-100">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<p class="text-muted mb-2">

Total Users

</p>

<h2 class="fw-bold">

<?= number_format($totalUsers); ?>

</h2>

</div>

<i class="bi bi-people-fill text-primary card-icon"></i>

</div>

<hr>

<a href="users.php" class="text-decoration-none fw-semibold">

Manage Users

<i class="bi bi-arrow-right-circle-fill"></i>

</a>

</div>

</div>

</div>

<!-- Assessments -->

<div class="col-lg-3 col-md-6">

<div class="card h-100">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<p class="text-muted mb-2">

Assessments

</p>

<h2 class="fw-bold">

<?= number_format($totalAssessments); ?>

</h2>

</div>

<i class="bi bi-ui-checks-grid text-success card-icon"></i>

</div>

<hr>

<a href="assessments.php" class="text-decoration-none fw-semibold">

View Assessments

<i class="bi bi-arrow-right-circle-fill"></i>

</a>

</div>

</div>

</div>

<!-- Recommendations -->

<div class="col-lg-3 col-md-6">

<div class="card h-100">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<p class="text-muted mb-2">

Recommendations

</p>

<h2 class="fw-bold">

<?= number_format($totalRecommendations); ?>

</h2>

</div>

<i class="bi bi-lightbulb-fill text-warning card-icon"></i>

</div>

<hr>

<a href="recommendations.php" class="text-decoration-none fw-semibold">

View Recommendations

<i class="bi bi-arrow-right-circle-fill"></i>

</a>

</div>

</div>

</div>

<!-- Feedback -->

<div class="col-lg-3 col-md-6">

<div class="card h-100">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<p class="text-muted mb-2">

User Feedback

</p>

<h2 class="fw-bold">

<?= number_format($totalFeedback); ?>

</h2>

</div>

<i class="bi bi-chat-left-text-fill text-danger card-icon"></i>

</div>

<hr>

<a href="feedback.php" class="text-decoration-none fw-semibold">

View Feedback

<i class="bi bi-arrow-right-circle-fill"></i>

</a>

</div>

</div>

</div>

</div>

<!--AI Recommendation Engine-->

<div class="card shadow-lg border-0 mt-5 mb-5">

    <div class="card-body p-5">

        <div class="row align-items-center">

            <div class="col-md-2 text-center">

                <i class="bi bi-robot display-1 text-primary"></i>

            </div>

            <div class="col-md-10">

                <h3 class="fw-bold">

                    AI Recommendation Engine

                </h3>

                <p class="text-muted">

                    This system combines a rule-based recommendation engine with Google's Gemini AI to generate personalised, explainable career recommendations based on each student's assessment responses.

                </p>

                <div class="row mt-4">

                    <div class="col-md-4">

                        <h2 class="text-primary fw-bold">

                            <?= number_format($totalRecommendations); ?>

                        </h2>

                        <small class="text-muted">

                            Recommendations Generated

                        </small>

                    </div>

                    <div class="col-md-4">

                        <h2 class="text-success fw-bold">

                            <?= number_format($totalAssessments); ?>

                        </h2>

                        <small class="text-muted">

                            Assessments Processed

                        </small>

                    </div>

                    <div class="col-md-4">

                        <h2 class="text-warning fw-bold">

                            Gemini AI

                        </h2>

                        <small class="text-muted">

                            Recommendation Assistant

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

/*Recent Registered Users*/

$sql = "

SELECT

name,
email,
created_at

FROM users

ORDER BY user_id DESC

LIMIT 5

";

$recentUsers = mysqli_query($conn,$sql);

?>

<div class="card shadow border-0 mb-5">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

<i class="bi bi-people-fill"></i>

Recent Registered Users

</h5>

</div>

<div class="card-body">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Name</th>

<th>Email</th>

<th>Date Joined</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($recentUsers)>0){

while($row=mysqli_fetch_assoc($recentUsers)){

?>

<tr>

<td>

<?= htmlspecialchars($row['name']) ?>

</td>

<td>

<?= htmlspecialchars($row['email']) ?>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])) ?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="3" class="text-center text-muted">

No registered users found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<?php

/* Latest Assessments */

$sql = "

SELECT

fullname,
course,
level,
created_at

FROM assessment_responses

ORDER BY created_at DESC

LIMIT 5

";

$recentAssessments = mysqli_query($conn, $sql);

?>

<div class="card shadow border-0 mb-5">

<div class="card-header bg-success text-white">

<h5 class="mb-0">

<i class="bi bi-ui-checks-grid"></i>

Latest Assessments

</h5>

</div>

<div class="card-body">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Student</th>

<th>Course</th>

<th>Level</th>

<th>Date Completed</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($recentAssessments)>0){

while($row=mysqli_fetch_assoc($recentAssessments)){

?>

<tr>

<td>

<?= htmlspecialchars($row['fullname']) ?>

</td>

<td>

<?= htmlspecialchars($row['course']) ?>

</td>

<td>

<?= htmlspecialchars($row['level']) ?>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])) ?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="4" class="text-center text-muted">

No assessment records found.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<?php

/*Recent Feedback*/

$sql = "

SELECT

users.name,

feedback.rating,

feedback.comment,

feedback.created_at

FROM feedback

INNER JOIN users

ON feedback.user_id = users.user_id

ORDER BY feedback.created_at DESC

LIMIT 5

";

$recentFeedback = mysqli_query($conn, $sql);

?>

<div class="card shadow border-0 mb-5">

<div class="card-header bg-warning">

<h5 class="mb-0">

<i class="bi bi-chat-left-text-fill"></i>

Recent User Feedback

</h5>

</div>

<div class="card-body">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>User</th>

<th>Rating</th>

<th>Comment</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($recentFeedback)>0){

while($row=mysqli_fetch_assoc($recentFeedback)){

?>

<tr>

<td>

<?= htmlspecialchars($row['name']) ?>

</td>

<td>

<?= str_repeat("⭐",$row['rating']) ?>

</td>

<td>

<?= htmlspecialchars(substr($row['comment'],0,60)) ?>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])) ?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="4" class="text-center text-muted">

No feedback submitted yet.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<?php

/*Recommendation Analytics*/

$sql = "

SELECT

career_name,

COUNT(*) AS total

FROM recommendations

GROUP BY career_name

ORDER BY total DESC

";

$result = mysqli_query($conn,$sql);

$careerNames = [];
$careerTotals = [];

while($row = mysqli_fetch_assoc($result)){

    $careerNames[] = $row['career_name'];
    $careerTotals[] = $row['total'];

}

?>

<div class="card shadow border-0 mb-5">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">

            <i class="bi bi-bar-chart-fill"></i>

            Career Recommendation Analytics

        </h5>

    </div>

    <div style="height:420px;">

          <canvas id="careerChart"></canvas>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

window.onload = function(){

const ctx = document.getElementById('careerChart');

console.log(ctx);

new Chart(ctx,{

type:'bar',

data:{

labels:<?= json_encode($careerNames); ?>,

datasets:[{

label:'Recommendations',

data:<?= json_encode($careerTotals); ?>,

backgroundColor: [
    '#2563EB',
    '#10B981',
    '#F59E0B',
    '#EF4444',
    '#8B5CF6',
    '#06B6D4',
    '#EC4899',
    '#84CC16',
    '#F97316',
    '#14B8A6',
    '#6366F1'
],

borderRadius:6

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true,

ticks:{

precision:0

}

}

}

}

});

}

</script>


<?php include("../includes/footer.php"); ?>
