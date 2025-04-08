<?php 
session_start();
include 'db.php'; // Include database connection

// Fetch party data from the database
$query = "SELECT * FROM parties"; 
$result = $conn->query($query);

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM parties WHERE id=$id");
  echo "<script>alert('Party deleted successfully!'); window.location.href='manage_party.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Parties</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <!-- Correct Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    


<!-- Manage Party Section -->
<main class="container mt-5" style="padding-top: 100px; margin-bottom: 120px;">
    <h2 class="text-center mb-4 text-uppercase fw-bold bg-primary text-white py-2 w-50 mx-auto" style="letter-spacing: 5px;">
      ELECTION  &nbsp; PARTY &nbsp; REPORT
    </h2>

    <!-- Add New Party Button -->
    <div class="text-end mb-3" style="padding-top: 20px;">
        <a href="add_party.php" class="btn btn-primary"> ADD NEW PARTY</a>
    </div>

    <table class="table table-bordered table-hover text-center">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>PARTY &nbsp; LOGO</th>
                <th>PARTY  &nbsp; NAME</th>
                <th>FOUNDED  &nbsp; YEAR</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result->num_rows > 0) {
                $sr = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$sr}</td>
                            <td><img src='{$row['party_logo']}' width='60' height='60' class='rounded'></td>
                            <td>{$row['party_name']}</td>
                            <td>{$row['founded_year']}</td>
                            <td>
                                <a href='edit_party.php?id={$row['id']}' class='btn btn-warning btn-sm me-2'>EDIT</a>
                                <a href='delete_party.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>DELETE</a>
                            </td>
                          </tr>";
                    $sr++;
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No Parties Found</td></tr>";
            }
            ?>
        </tbody>
    </table>
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
