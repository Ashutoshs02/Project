<?php
include 'db.php';

if (isset($_POST['candidate_id'])) {
    $candidate_id = $_POST['candidate_id'];

    // Check if the candidate already has votes recorded
    $check = $conn->query("SELECT * FROM votes WHERE candidate_id=$candidate_id");

    if ($check->num_rows > 0) {
        // If candidate exists in votes table, increase vote count
        $conn->query("UPDATE votes SET total_votes = total_votes + 1 WHERE candidate_id=$candidate_id");
    } else {
        // If no votes exist, insert a new record
        $conn->query("INSERT INTO votes (candidate_id, total_votes) VALUES ($candidate_id, 1)");
    }

    echo "<script>alert('Vote cast successfully!'); window.location.href='dashboard.php';</script>";
}

$conn->close();
?>
