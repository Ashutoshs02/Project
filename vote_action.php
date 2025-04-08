<?php
session_start();
include 'db.php'; // Ensure database connection is included

if (!isset($_SESSION['citizen'])) {
    header("Location: citizen_login.php");
    exit();
}

$citizen_id = $_SESSION['citizen'];
$candidate_id = $_POST['candidate_id'];

// Check if the citizen has already voted
$check_vote = "SELECT has_voted FROM citizen_votes WHERE citizen_id = '$citizen_id'";
$result = $conn->query($check_vote);
$voted = $result->fetch_assoc()['has_voted'] ?? false;

if ($voted) {
    $_SESSION['error'] = "You have already voted!";
    header("Location: vote.php");
    exit();
}

// Check if the candidate already has votes
$check_candidate = "SELECT total_votes FROM votes WHERE candidate_id = '$candidate_id'";
$candidate_result = $conn->query($check_candidate);

if ($candidate_result->num_rows > 0) {
    // Candidate exists, update vote count
    $update_vote = "UPDATE votes SET total_votes = total_votes + 1 WHERE candidate_id = '$candidate_id'";
} else {
    // Candidate does not exist, insert new vote record
    $update_vote = "INSERT INTO votes (candidate_id, total_votes) VALUES ('$candidate_id', 1)";
}

$conn->query($update_vote);

// Mark Citizen as Voted
$update_citizen = "INSERT INTO citizen_votes (citizen_id, has_voted) VALUES ('$citizen_id', 1)
                   ON DUPLICATE KEY UPDATE has_voted = 1";
$conn->query($update_citizen);

$_SESSION['success'] = "Your vote has been successfully cast!";
header("Location: vote.php");
exit();
?>
