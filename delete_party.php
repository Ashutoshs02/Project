<?php
include 'db.php'; // Include database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch party data to get the logo path
    $query = "SELECT party_logo FROM parties WHERE id = $id";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $logo_path = $row['party_logo'];

        // Delete the party from the database
        $delete_query = "DELETE FROM parties WHERE id = $id";
        if ($conn->query($delete_query) === TRUE) {
            // Delete the logo file from the server
            if (file_exists($logo_path)) {
                unlink($logo_path);
            }

            echo "<script>alert('Party deleted successfully!'); window.location.href='manage_party.php';</script>";
        } else {
            echo "<script>alert('Error deleting party!'); window.location.href='manage_party.php';</script>";
        }
    }
}

$conn->close();
?>
