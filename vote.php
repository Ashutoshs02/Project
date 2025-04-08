<?php
session_start();
include 'db.php';

$date_query = "SELECT voting_end_date, result_announcement_date FROM settings WHERE id = 1";
$date_result = $conn->query($date_query);
$settings = $date_result->fetch_assoc();

$voting_end_date = $settings['voting_end_date'] ?? null;
$result_announcement_date = $settings['result_announcement_date'] ?? null;

if (!isset($_SESSION['citizen'])) {
    header("Location: citizen_login.php");
    exit();
}

$citizen_id = $_SESSION['citizen'];
$voting_closed = (date('Y-m-d') > $voting_end_date);

$voted_query = "SELECT has_voted FROM citizen_votes WHERE citizen_id = '$citizen_id'";
$voted_result = $conn->query($voted_query);
$voted = $voted_result->fetch_assoc()['has_voted'] ?? false;

$query = "SELECT c.id, c.party_logo, c.party_name, c.candidate_name, 
                 COALESCE(v.total_votes, 0) AS total_votes
          FROM candidates c
          LEFT JOIN votes v ON c.id = v.candidate_id";

$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vote - Online Voting System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="#">ONLINE &nbsp; VOTING &nbsp; SYSTEM</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="nav nav-underline ms-auto">
        <li class="nav-item"><a class="nav-link fw-bold text-white" href="index.php">HOME</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-white" href="about.php">ABOUT</a></li>
        <li class="nav-item"><a class="nav-link active fw-bold text-white" href="vote.php">VOTE</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-white" href="result.php">RESULTS</a></li>
        <li class="nav-item"><a class="fw-bold text-white btn btn-primary" href="citizen_login.php">LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="container mt-5" style="padding-top: 100px; margin-bottom: 120px;">
    <h2 class="text-center mb-4 text-uppercase fw-bold bg-primary text-white py-2 w-75 mx-auto" style="letter-spacing: 5px;">
      CAST  &nbsp; YOUR  &nbsp; VOTE
    </h2>

    <div class="alert alert-info text-center w-50 mx-auto">
        <strong>Voting Closes On:</strong> <?= date('F j, Y', strtotime($voting_end_date)) ?>
    </div>

    <?php if ($voting_closed) { ?>
        <div class="alert alert-danger text-center w-50 mx-auto">
            <strong>Voting is Closed!</strong> Results will be announced on <?= date('F j, Y', strtotime($result_announcement_date)) ?>.
        </div>
    <?php } ?>

    <div class="container-fluid mt-5">
        <table class="table table-bordered table-hover text-center mt-4">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>PARTY LOGO</th>
                    <th>PARTY NAME</th>
                    <th>CANDIDATE NAME</th>
                    <th>VOTE</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 1;
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><img src="uploads/<?= $row['party_logo'] ?>" width="60"></td>
                        <td><?= $row['party_name'] ?></td>
                        <td><?= $row['candidate_name'] ?></td>
                        <td>
                            <?php if (!$voted && !$voting_closed) { ?>
                                <form method="POST" action="vote_action.php" onsubmit="return confirmVote()">
                                    <input type="hidden" name="candidate_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-primary">VOTE</button>
                                </form>
                            <?php } else { ?>
                                <button class="btn btn-secondary" disabled>VOTED</button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>


<!-- Custom Sticky Footer -->
<footer class="bg-primary text-white py-4 footer">
  <div class="container">
    <div class="row">
      <!-- About Section -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>About</h5>
        <p>An online voting system designed to offer secure, transparent, and efficient elections. Your vote matters, and we ensure its integrity.</p>
      </div>

      <!-- Quick Links -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
          <li><a href="about.php" class="text-white text-decoration-none">About</a></li>
          <li><a href="admin_login.php" class="text-white text-decoration-none">Admin Login</a></li>
          <li><a href="citizen_login.php" class="text-white text-decoration-none">Citizen Login</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-lg-4 col-md-12">
        <h5>Contact Us</h5>
        <p>Email: support@onlinevoting.com</p>
        <p>Phone: +91 9876543210</p>
        <p>Address: New Delhi, India</p>
      </div>
    </div>

    <div class="text-center mt-3">
      <p class="mb-0">&copy; <?= date('Y') ?> Online Voting System. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<script>
function confirmVote() {
    return confirm("Are you sure you want to cast your vote? This action cannot be undone.");
}
</script>

</body>
</html>
