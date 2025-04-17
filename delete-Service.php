<?php
include('include/db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the icon file (optional)
$sql = "SELECT icon FROM service WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $iconPath = "uploads/" . $row['icon'];
    if (file_exists($iconPath)) {
        unlink($iconPath);
    }
}

$delete = "DELETE FROM service WHERE id = $id";
if ($conn->query($delete)) {
    echo "<script>alert('Deleted successfully');window.location.href='view-service.php';</script>";
} else {
    echo "Error deleting record: " . $conn->error;
}
?>