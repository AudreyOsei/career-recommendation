<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("../includes/db.php");

if (!isset($conn)) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$success = "";
$error = "";

if(isset($_POST['submit_feedback'])){

    $rating = intval($_POST['rating']);

    $comment = trim($_POST['comment']);

    if(empty($rating)){

        $error = "Please select a rating.";

    }

    else{

        $recommendation_id =
        isset($_POST['recommendation_id']) ? intval($_POST['recommendation_id']) : '';

        $comment =
        mysqli_real_escape_string(
            $conn,
            $comment
        );

       $sql = "

INSERT INTO feedback
(

user_id,

rating,

comment

)

VALUES
(

'$user_id',

'$rating',

'$comment'

)

";

        if(mysqli_query($conn,$sql)){

            $success =
            "Feedback submitted successfully.";

        }

        else{

            $error =
            "Database Error : "
            . mysqli_error($conn);

        }

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

Feedback

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

.star{

font-size:50px;

color:#d1d5db;

cursor:pointer;

transition:.3s;

margin:8px;

}

.star:hover{

transform:scale(1.2);

}

.star.active{

color:#ffc107;

}

</style>

</head>

<body>

<nav class="navbar navbar-dark bg-primary">

<div class="container">

<a
href="../home.php"
class="navbar-brand fw-bold">

Career Recommendation System

</a>

<a
href="../home.php"
class="btn btn-light">

Dashboard

</a>

</div>

</nav>

<div class="container feedback-container">

<div class="card feedback-card">

<div class="hero">

<i class="bi bi-chat-heart-fill"></i>

<h2>

Rate Your Experience

</h2>

<p>

Thank you for using our AI Career Recommendation System.

Your feedback helps us improve future recommendations.

</p>

</div>

<div class="card-body p-5">

<?php if($success!=""): ?>

<div class="alert alert-success">

<?= $success; ?>

</div>

<?php endif; ?>

<?php if($error!=""): ?>

<div class="alert alert-danger">

<?= $error; ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="rating">

<input
type="hidden"
id="rating"
name="rating">

<span class="star" data-rating="1">
<i class="bi bi-star-fill"></i>
</span>

<span class="star" data-rating="2">
<i class="bi bi-star-fill"></i>
</span>

<span class="star" data-rating="3">
<i class="bi bi-star-fill"></i>
</span>

<span class="star" data-rating="4">
<i class="bi bi-star-fill"></i>
</span>

<span class="star" data-rating="5">
<i class="bi bi-star-fill"></i>
</span>

</div>

<div class="mt-5">

<label class="fw-bold">

Share your experience

</label>

<textarea

name="comment"

rows="6"

class="form-control"

placeholder="Tell us about your experience with the AI recommendations...">

</textarea>

</div>

<div class="text-center mt-5">

<button

type="submit"

name="submit_feedback"

class="btn btn-primary btn-feedback">

<i class="bi bi-send-fill"></i>

Submit Feedback

</button>

</div>

</form>

</div>

</div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function(){

const stars=document.querySelectorAll(".star");

const rating=document.getElementById("rating");

stars.forEach(star=>{

star.addEventListener("click",function(){

const value=this.dataset.rating;

rating.value=value;

stars.forEach(s=>{

if(s.dataset.rating<=value){

s.classList.add("active");

}else{

s.classList.remove("active");

}

});

});

});

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>