<?php

session_start();

if (isset($_SESSION['admin_id'])) {

    header("Location: pages/dashboard.php");
    exit();

}

header("Location: login.php");
exit();

?>