<?php

include("../includes/header.php");
include("../includes/sidebar.php");

/* ==========================================
   Search Assessment
========================================== */

$search = "";

if (!isset($conn) || !$conn) {
    die("Database connection error");
}


if(isset($_GET['search'])){

    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $sql = "

    SELECT *

    FROM assessment_responses

    WHERE fullname LIKE '%$search%'

    ORDER BY created_at DESC

    ";

}else{

    $sql = "

    SELECT *

    FROM assessment_responses

    ORDER BY created_at DESC

    ";

}

$result = mysqli_query($conn,$sql);

$totalAssessments = mysqli_num_rows($result);

?>

<div class="d-flex justify-content-between align-items-center mb-5">

<div>

<h2 class="fw-bold">

<i class="bi bi-ui-checks-grid text-success"></i>

Assessment Management

</h2>

<p class="text-muted">

View and monitor completed student career assessments.

</p>

</div>

<div>

<span class="badge bg-success fs-6 px-4 py-3">

<?= $totalAssessments ?>

Completed Assessments

</span>

</div>

</div>

<form method="GET" class="mb-4">

<div class="input-group">

<input

type="text"

name="search"

class="form-control"

placeholder="Search student..."

value="<?= htmlspecialchars($search) ?>">

<button

class="btn btn-success"

type="submit">

<i class="bi bi-search"></i>

Search

</button>

</div>

</form>

<div class="card shadow border-0">

<div class="card-header bg-success text-white">

<h5 class="mb-0">

Completed Assessments

</h5>

</div>

<div class="card-body">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>ID</th>

<th>Student</th>

<th>Course</th>

<th>Level</th>

<th>Date</th>

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

<td><?= $row['id']; ?></td>

<td><?= htmlspecialchars($row['fullname']); ?></td>

<td><?= htmlspecialchars($row['course']); ?></td>

<td><?= htmlspecialchars($row['level']); ?></td>

<td><?= date("d M Y",strtotime($row['created_at'])); ?></td>

<td>

<a

href="view_assessment.php?id=<?= $row['id']; ?>"

class="btn btn-sm btn-primary">

<i class="bi bi-eye-fill"></i>

View

</a>

<a

href="delete_assessment.php?id=<?= $row['id']; ?>"

class="btn btn-sm btn-danger"

onclick="return confirm('Delete this assessment?');">

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

<td colspan="6" class="text-center">

No assessments found.

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