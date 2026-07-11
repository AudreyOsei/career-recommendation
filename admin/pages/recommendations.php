<?php

include("../includes/header.php");
include("../includes/sidebar.php");

// Ensure DB connection exists
if(!isset($conn) || !$conn){
    $conn = mysqli_connect('localhost','root','','career_recommendation');
    if(!$conn){
        die('Database connection failed: '.mysqli_connect_error());
    }
}

/* ==========================================
   Search Recommendation
========================================== */

$search = "";

if(isset($_GET['search'])){

    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $sql = "

    SELECT *

    FROM recommendations

    WHERE career_name LIKE '%$search%'

    ORDER BY created_at DESC

    ";

}else{

    $sql = "

    SELECT *

    FROM recommendations

    ORDER BY created_at DESC

    ";

}

$result = mysqli_query($conn,$sql);

$totalRecommendations = mysqli_num_rows($result);

?>

<div class="d-flex justify-content-between align-items-center mb-5">

<div>

<h2 class="fw-bold">

<i class="bi bi-lightbulb-fill text-warning"></i>

Recommendation Management

</h2>

<p class="text-muted">

View AI-generated career recommendations and recommendation scores.

</p>

</div>

<div>

<span class="badge bg-warning text-dark fs-6 px-4 py-3">

<?= $totalRecommendations ?>

Recommendations

</span>

</div>

</div>

<form method="GET" class="mb-4">

<div class="input-group">

<input

type="text"

name="search"

class="form-control"

placeholder="Search career..."

value="<?= htmlspecialchars($search) ?>">

<button

class="btn btn-warning"

type="submit">

<i class="bi bi-search"></i>

Search

</button>

</div>

</form>

<div class="card shadow border-0">

<div class="card-header bg-warning">

<h5 class="mb-0">

Career Recommendations

</h5>

</div>

<div class="card-body">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>ID</th>

<th>Career</th>

<th>Match Score</th>

<th>Date Generated</th>

<th width="180">

Actions

</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td>

<?= $row['recommendation_id']; ?>

</td>

<td>

<?= htmlspecialchars($row['career_name']); ?>

</td>

<td>

<span class="badge bg-success">

<?= number_format($row['match_score']); ?>%

</span>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])); ?>

</td>

<td>

<a

href="view_recommendation.php?id=<?= $row['recommendation_id']; ?>"

class="btn btn-sm btn-primary">

<i class="bi bi-eye-fill"></i>

View

</a>

<a

href="delete_recommendation.php?id=<?= $row['recommendation_id']; ?>"

class="btn btn-sm btn-danger"

onclick="return confirm('Delete this recommendation?');">

<i class="bi bi-trash-fill"></i>

Delete

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5" class="text-center">

No recommendations found.

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

include("../includes/footer.php");

?>