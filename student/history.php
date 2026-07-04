<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../includes/db.php");

if (!isset($conn) || !$conn) {
    die("Database connection failed");
}

$user_id = $_SESSION['user_id'];

$sql = "

SELECT

assessment_responses.id,

assessment_responses.created_at,

MAX(recommendations.match_score) AS highest_score,

SUBSTRING_INDEX(

GROUP_CONCAT(
recommendations.career_name
ORDER BY recommendations.match_score DESC
),

',',

1

) AS top_career,

COUNT(recommendations.recommendation_id)
AS total_recommendations

FROM assessment_responses

INNER JOIN recommendations

ON assessment_responses.id = recommendations.response_id

WHERE assessment_responses.user_id = '$user_id'

GROUP BY assessment_responses.id

ORDER BY assessment_responses.created_at DESC

";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Recommendation History</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">

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

<h2 class="mb-4">

My Recommendation History

</h2>

<div class="table-responsive">

<table class="table table-bordered table-hover bg-white">

<thead class="table-primary">

<tr>

<th>Date</th>

<th>Top Recommendation</th>

<th>Total Recommendations</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<tr>

<td>

<?= date("d M Y", strtotime($row['created_at'])) ?>

</td>

<td>

<?= htmlspecialchars($row['top_career']) ?>

</td>

<td>

<?= $row['total_recommendations'] ?>

</td>

<td>

<a
href="view_recommendation.php?id=<?= $row['id'] ?>"
class="btn btn-primary btn-sm">

View

</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</body>

</html>