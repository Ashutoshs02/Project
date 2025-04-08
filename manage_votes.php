<?php
include 'db.php'; // Database connection

// Fetch vote counts for candidates
$candidateQuery = "SELECT c.id, c.party_logo, c.party_name, c.candidate_name, 
                          COALESCE(v.total_votes, 0) AS total_votes
                   FROM candidates c
                   LEFT JOIN votes v ON c.id = v.candidate_id
                   ORDER BY c.id ASC";
$candidateResult = $conn->query($candidateQuery);

// Prepare data for charts
$chartData = [];
$labels = [];
$votes = [];

while ($row = $candidateResult->fetch_assoc()) {
    $chartData[] = $row;
    $labels[] = $row['candidate_name'];
    $votes[] = (int)$row['total_votes'];
}

// Total registered and voted citizens
$totalCitizens = $conn->query("SELECT COUNT(*) as total FROM citizens")->fetch_assoc()['total'];
$votedCitizens = $conn->query("SELECT COUNT(DISTINCT citizen_id) as voted FROM 	citizen_votes")->fetch_assoc()['voted'];
$notVotedCitizens = $totalCitizens - $votedCitizens;

// Prevent divide by zero
$votedPercent = $totalCitizens > 0 ? round(($votedCitizens / $totalCitizens) * 100, 2) : 0;
$notVotedPercent = 100 - $votedPercent;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Votes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/style.css">
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
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle fw-bold text-white" href="#" id="adminDropdown" role="button"
             data-bs-toggle="dropdown" aria-expanded="false">ADMINISTRATION</a>
          <ul class="dropdown-menu" aria-labelledby="adminDropdown">
            <li><a class="dropdown-item" href="manage_citizen.php">MANAGE CITIZEN</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="manage_party.php">MANAGE PARTY</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="manage_candidate.php">MANAGE CANDIDATE</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="manage_votes.php">MANAGE VOTES</a></li>
            
          </ul>
        </li>
          <a class="fw-bold text-white btn btn-primary" href="admin_login.php">LOGOUT</a>
      </ul>
    </div>
  </div>
</nav>

<!-- Content -->
<main class="container mt-5" style="padding-top: 100px; margin-bottom: 120px;">
    <h2 class="text-center mb-4 text-uppercase fw-bold bg-primary text-white py-2 w-75 mx-auto">VOTING RESULT</h2>

    <!-- Vote Table -->
    <table class="table table-bordered table-hover text-center mt-4">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>PARTY &nbsp; LOGO</th>
                <th>PARTY &nbsp; NAME</th>
                <th>CANDIDATE &nbsp; NAME</th>
                <th>TOTAL &nbsp; VOTES</th>
            </tr>
        </thead>
        <tbody>
        <?php $count = 1; foreach ($chartData as $row): ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><img src="uploads/<?= $row['party_logo']; ?>" width="50"></td>
                <td><?= $row['party_name']; ?></td>
                <td><?= $row['candidate_name']; ?></td>
                <td><?= $row['total_votes']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Charts -->
    <div class="row mt-5">
        <div class="col-md-6">
            <h5 class="text-center">VOTE COUNT PER CANDIDATE</h5>
            <canvas id="votesBarChart"></canvas>
        </div>
        <div class="col-md-6">
            <h5 class="text-center">VOTER PARTICIPATION</h5>
            <canvas id="participationPieChart"></canvas>
        </div>
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
    // Bar Chart - Vote Count
    const ctx1 = document.getElementById('votesBarChart').getContext('2d');
    const votesBarChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Total Votes',
                data: <?= json_encode($votes) ?>,
                backgroundColor: '#0d6efd',
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Pie Chart - Participation
    const ctx2 = document.getElementById('participationPieChart').getContext('2d');
    const participationPieChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Voted', 'Not Voted'],
            datasets: [{
                label: 'Participation',
                data: [<?= $votedPercent ?>, <?= $notVotedPercent ?>],
                backgroundColor: ['#198754', '#dc3545']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
