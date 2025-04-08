<?php
include 'db.php'; // Database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch candidate's data to get the party logo
    $query = "SELECT party_logo FROM candidates WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $photo_path = "uploads/" . $row['party_logo'];

        // Delete candidate from database
        $delete_query = "DELETE FROM candidates WHERE id = $id";
        if ($conn->query($delete_query) === TRUE) {
            // Delete the photo from the server
            if (file_exists($photo_path)) {
                unlink($photo_path);
            }
            echo "<script>alert('Candidate deleted successfully!'); window.location.href='manage_candidate.php';</script>";
        } else {
            echo "<script>alert('Error deleting candidate!'); window.location.href='manage_candidate.php';</script>";
        }
    }
}

$conn->close();
?>
