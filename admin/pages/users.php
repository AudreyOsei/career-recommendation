<?php

include("../includes/header.php");
include("../includes/sidebar.php");

// Ensure $conn is defined (fallback for environments where header doesn't set DB connection)
if(!isset($conn) || $conn === null){
    $conn = mysqli_connect('localhost','root','','career_recommendation');
}

/* ===========================
   Search
=========================== */

$search = "";

if(isset($_GET['search']) && !empty($_GET['search'])){

    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );

    $sql = "

    SELECT *

    FROM users

    WHERE

    name LIKE '%$search%'

    OR

    email LIKE '%$search%'

    ORDER BY user_id DESC

    ";

}else{

    $sql = "

    SELECT *

    FROM users

    ORDER BY user_id DESC

    ";

}

$result = mysqli_query($conn,$sql);

$totalUsers = mysqli_num_rows($result);

?>


<div class="d-flex justify-content-between align-items-center mb-5">

<div>

<h2 class="fw-bold">

<i class="bi bi-people-fill text-primary"></i>

User Management

</h2>

<p class="text-muted">

Manage registered users and monitor system accounts.

</p>

</div>

<div>

<span class="badge bg-primary fs-6 px-4 py-3">

<?= $totalUsers ?>

Registered Users

</span>

</div>

</div>



<form method="GET" class="mb-4">

<div class="input-group">

<input

type="text"

name="search"

class="form-control"

placeholder="Search by name or email..."

value="<?= htmlspecialchars($search) ?>">

<button

class="btn btn-primary"

type="submit">

<i class="bi bi-search"></i>

Search

</button>

</div>

</form>


<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

Registered Users

</h5>

</div>

<div class="card-body">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Date Joined</th>

<th width="170">

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

<?= $row['user_id'] ?>

</td>

<td>

<?= htmlspecialchars($row['name']) ?>

</td>

<td>

<?= htmlspecialchars($row['email']) ?>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])) ?>

</td>

<td>

<a

href="view_user.php?id=<?= $row['user_id'] ?>"

class="btn btn-sm btn-success">

<i class="bi bi-eye-fill"></i>

</a>

<a

href="delete_user.php?id=<?= $row['user_id'] ?>"

class="btn btn-sm btn-danger"

onclick="return confirm('Delete this user?');">

<i class="bi bi-trash-fill"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5" class="text-center">

No users found.

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