<?php

include("../includes/header.php");
include("../includes/sidebar.php");

/* ===Search Feedback===== */

$search = "";

if (!isset($conn) || !$conn) {
    die("Database connection error");
}


if(isset($_GET['search'])){

    $search = mysqli_real_escape_string($conn,$search = $_GET['search']);

    $sql = "

    SELECT

    feedback.*,

    users.name

    FROM feedback

    INNER JOIN users

    ON feedback.user_id = users.user_id

    WHERE

    users.name LIKE '%$search%'

    OR

    feedback.comment LIKE '%$search%'

    ORDER BY feedback.created_at DESC

    ";

}else{

    $sql = "

    SELECT

    feedback.*,

    users.name

    FROM feedback

    INNER JOIN users

    ON feedback.user_id = users.user_id

    ORDER BY feedback.created_at DESC

    ";

}

$result = mysqli_query($conn,$sql);

$totalFeedback = mysqli_num_rows($result);

/* Average Rating */

$avg = mysqli_query($conn,"
SELECT AVG(rating) AS average_rating
FROM feedback
");

$averageRating = mysqli_fetch_assoc($avg)['average_rating'];

?>

<div class="d-flex justify-content-between align-items-center mb-5">

<div>

<h2 class="fw-bold">

<i class="bi bi-chat-left-text-fill text-warning"></i>

Feedback Management

</h2>

<p class="text-muted">

Review user feedback and monitor overall satisfaction.

</p>

</div>

<div>

<span class="badge bg-warning text-dark fs-6 px-4 py-3">

<?= $totalFeedback ?>

Feedback Received

</span>

</div>

</div>

<div class="row mb-4">

<div class="col-md-6">

<div class="card shadow-sm">

<div class="card-body text-center">

<h1 class="text-warning">

⭐ <?= number_format($averageRating,1); ?>

</h1>

<p class="text-muted">

Average Rating

</p>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card shadow-sm">

<div class="card-body text-center">

<h1 class="text-primary">

<?= $totalFeedback; ?>

</h1>

<p class="text-muted">

Total Feedback Submitted

</p>

</div>

</div>

</div>

</div>

<form method="GET" class="mb-4">

<div class="input-group">

<input

type="text"

name="search"

class="form-control"

placeholder="Search user or comment..."

value="<?= htmlspecialchars($search); ?>">

<button

class="btn btn-warning">

<i class="bi bi-search"></i>

Search

</button>

</div>

</form>

<div class="card shadow border-0">

<div class="card-header bg-warning">

<h5 class="mb-0">

Submitted Feedback

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

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td>

<?= htmlspecialchars($row['name']); ?>

</td>

<td>

<?= str_repeat("⭐",$row['rating']); ?>

</td>

<td>

<?= htmlspecialchars($row['comment']); ?>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])); ?>

</td>

<td>

<a

href="delete_feedback.php?id=<?= $row['feedback_id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete this feedback?');">

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

No feedback available.

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