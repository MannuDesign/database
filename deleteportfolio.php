<?php
include('include/db.php');

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Sanitize and validate the id
    $id = (int)$_GET['id']; // Cast to integer to ensure it is a valid number

    // SQL Delete query using prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
    $stmt->bind_param("i", $id); // 'i' means integer type for parameter binding

    // Execute the query
    if ($stmt->execute()) {
        // Redirect after deletion
        header("Location: view_Portfolio.php");
        exit(); // Always call exit after header redirection to ensure no further code is executed
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "No ID provided!";
}
?>
