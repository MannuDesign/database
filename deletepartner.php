<?php
include('include/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Optional: Delete image file too (if needed)
    $getImg = mysqli_query($conn, "SELECT p_imges FROM partners WHERE id = $id");
    $imgData = mysqli_fetch_assoc($getImg);
    $imgPath = 'uploads/' . $imgData['p_imges'];
    if (file_exists($imgPath)) {
        unlink($imgPath); // Delete image from folder
    }

    $delete = mysqli_query($conn, "DELETE FROM partners WHERE id = $id");
    if ($delete) {
        echo "<script>alert('Portfolio Item Added Successfully'); window.location.href='view-partners.php'; </script>";
    } else {
        echo "Delete Failed: " . mysqli_error($conn);
    }
}
?>