<?php
session_start();
include 'db.php';

// Fetch voting deadline and result date
$date_query = "SELECT voting_end_date, result_announcement_date FROM settings WHERE id = 1";
$date_result = $conn->query($date_query);
$settings = $date_result->fetch_assoc();

$voting_end_date = $settings['voting_end_date'] ?? null;
$result_announcement_date = $settings['result_announcement_date'] ?? null;

// Get today's date
$current_date = date('Y-m-d');

// Check if results can be displayed
$show_results = ($current_date >= $result_announcement_date);

// Fetch vote counts
$query = "SELECT c.id, c.party_logo, c.party_name, c.candidate_name, 
                 COALESCE(v.total_votes, 0) AS total_votes
          FROM candidates c
          LEFT JOIN votes v ON c.id = v.candidate_id
          ORDER BY total_votes DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
        <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="#">ONLINE &nbsp; VOTING &nbsp; SYSTEM</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="nav nav-underline ms-auto">
        <li class="nav-item">
          <a class="nav-link fw-bold text-white" href="index.php">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold text-white" href="about.php">ABOUT</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold text-white" href="vote.php">VOTE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold active text-white" href="result.php">RESULTS</a>
        </li>

          <a class="fw-bold text-white btn btn-primary" href="citizen_login.php">LOGOUT</a>
           </div>
      </div>
 </nav>

 <main class="container mt-5" style="padding-top: 100px; margin-bottom: 120px;">
    <h2 class="text-center mb-4 text-uppercase fw-bold bg-primary text-white py-2 w-75 mx-auto" style="letter-spacing: 5px;">
      ELECTION  &nbsp; RESULTS 
    </h2>

    <?php if (!$show_results) { ?>
        <div class="alert alert-warning text-center  w-50 mx-auto">
            
            Results will be announced on <strong><?= date('F j, Y', strtotime($result_announcement_date)) ?></strong>.
        </div>
    <?php } else { ?>
      
      <div class="container-fluid mt-5" style="padding-top: 20px;"> 
        <table class="table table-bordered table-hover text-center mt-4">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>PARTY LOGO</th>
                    <th>PARTY NAME</th>
                    <th>CANDIDATE NAME</th>
                    <th>TOTAL VOTES</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><img src="uploads/<?= $row['party_logo'] ?>" width="60"></td>
                        <td><?= $row['party_name'] ?></td>
                        <td><?= $row['candidate_name'] ?></td>
                        <td><strong><?= $row['total_votes'] ?></strong></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
       <?php } ?>
    </div>
</main>

<!-- Custom Sticky Footer -->
<footer class="bg-primary text-white py-4 footer-1">
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


</body>
</html>
