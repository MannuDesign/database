<?php
include('include/db.php');


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM testimonial WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_affected_rows($conn) > 0) {

        echo "<script>alert('testimonial deleted successfully'); window.location.href='view-testimonial.php';</script>";
    } else {
        echo "<script>alert('testimonial not found!'); window.location.href='edit-testimonial.php';</script>";
        exit();
    }

}





?>