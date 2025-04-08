<?php 
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $party_name = trim($_POST['party_name']);
    $founded_year = trim($_POST['founded_year']);
    
    // Validate inputs
    if (empty($party_name) || empty($founded_year)) {
        die("<script>alert('All fields are required.'); window.location='add_party.php';</script>");
    }

    // Check for duplicate party name
    $check_query = "SELECT * FROM parties WHERE party_name = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $party_name);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        die("<script>alert('Party name already exists. Please choose another name.'); window.location='add_party.php';</script>");
    }

    // Upload Party Logo
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it does not exist
    }

    $file_name = basename($_FILES["party_logo"]["name"]);
    $file_tmp = $_FILES["party_logo"]["tmp_name"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_ext, $allowed_types)) {
        die("<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.'); window.location='add_party.php';</script>");
    }

    $new_file_name = $target_dir . uniqid() . "." . $file_ext;
    if (!move_uploaded_file($file_tmp, $new_file_name)) {
        die("<script>alert('File upload failed. Try again.'); window.location='add_party.php';</script>");
    }

    // Insert Data into Database
    $stmt = $conn->prepare("INSERT INTO parties (party_logo, party_name,founded_year) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $new_file_name, $party_name, $founded_year);

    if ($stmt->execute()) {
        echo "<script>alert('Party Added Successfully'); window.location='manage_party.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Party</title>
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
    
       
<!-- Add New Party Section -->
<main class="container mt-5" style="padding-top: 100px; margin-bottom: 120px;">
    <div class="container d-flex justify-content-center">
        <div class="border p-4 shadow-lg rounded bg-light" style="width: 50%; max-width: 500px;">
            <h2 class="text-center mb-4 bg-primary text-white py-2 rounded">ADD  &nbsp; NEW  &nbsp; PARTY</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Party Name</label>
                    <input type="text" class="form-control" name="party_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Founded Year</label>
                    <input type="text" class="form-control" name="founded_year" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Party Logo</label>
                    <input type="file" class="form-control" name="party_logo" accept="image/*" required>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-primary">SUBMIT</button>
                <a href="manage_party.php" class="btn btn-secondary  mx-4">BACK</a>
            </form>
        </div>
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
         
       


</body>
</html>
