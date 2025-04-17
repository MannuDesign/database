<?php
include('include/db.php');


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM faq WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_affected_rows($conn) > 0) {

        echo "<script>alert('FAQ deleted successfully'); window.location.href='view-faq.php';</script>";
    } else {
        echo "<script>alert('FAQ not found!'); window.location.href='view-category.php';</script>";
        exit();
    }

}





?>