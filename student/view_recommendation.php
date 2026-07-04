<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../includes/db.php");

// Ensure we have a mysqli connection variable named $conn
if (!isset($conn)) {
    if (isset($con)) {
        $conn = $con;
    } elseif (isset($mysqli) && ($mysqli instanceof mysqli)) {
        $conn = $mysqli;
    } else {
        die("Database connection not found. Check includes/db.php");
    }
}

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$response_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "

SELECT *

FROM assessment_responses

WHERE id = '$response_id'

AND user_id = '$user_id'

";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {

    die("Assessment not found.");

}

$assessment = mysqli_fetch_assoc($result);

$sql = "

SELECT *

FROM recommendations

WHERE response_id = '$response_id'

ORDER BY match_score DESC

";

$recommendations = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>View Recommendation</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">

<div class="container">

<a href="history.php"
class="navbar-brand">

Career Recommendation System

</a>

<a href="history.php"
class="btn btn-light">

Back to History

</a>

</div>

</nav>

<div class="container py-5">

<h2 class="mb-4">

Career Recommendations

</h2>

<?php while($career = mysqli_fetch_assoc($recommendations)): ?>

<div class="card shadow-sm mb-4">

<div class="card-body">

<h4 class="text-primary">

<?= htmlspecialchars($career['career_name']) ?>

</h4>

<p>

<strong>

Match Score:

<?= $career['match_score'] ?>%

</strong>

</p>

<p>

<?= nl2br(htmlspecialchars($career['explanation'])) ?>

</p>

</div>

</div>

<?php endwhile; ?>

</div>

</body>

</html>