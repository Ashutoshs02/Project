<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM parties WHERE id=$id");
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $party_name = $_POST['party_name'];
    $founded_year = $_POST['founded_year'];
    
    // Check if a new logo is uploaded
    if (!empty($_FILES['party_logo']['name'])) {
        $logo_name = time() . '_' . $_FILES['party_logo']['name']; // Rename file to avoid duplicates
        $logo_tmp_name = $_FILES['party_logo']['tmp_name'];
        $logo_folder = "uploads/" . $logo_name; // Folder where images will be stored

        // Move uploaded file to the folder
        move_uploaded_file($logo_tmp_name, $logo_folder);

        // Update query with new logo
        $conn->query("UPDATE parties SET party_name='$party_name', founded_year='$founded_year', party_logo='$logo_folder' WHERE id=$id");
    } else {
        // Update without changing the logo
        $conn->query("UPDATE parties SET party_name='$party_name', founded_year='$founded_year' WHERE id=$id");
    }

    echo "<script>alert('Party updated successfully!'); window.location.href='manage_party.php';</script>";
}

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

        <!-- Edit/Delete Party -->
        <main class="container mt-5" style="padding-top: 100px; margin-bottom: 120px;">
        <div class="container d-flex justify-content-center">
        <div class="border p-4 shadow-lg rounded bg-light" style="width: 50%; max-width: 500px;">
            <h2 class="text-center mb-4 bg-primary text-white py-2 rounded">EDIT &nbsp; PARTY &nbsp; DETAILS</h2>
            <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Party Name</label>
        <input type="text" name="party_name" value="<?= $row['party_name'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Founded Year</label>
        <input type="number" name="founded_year" value="<?= $row['founded_year'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Current Logo</label><br>
        <img src="<?= $row['party_logo'] ?>" width="100" height="100" class="rounded mb-2">
    </div>
    <div class="mb-3">
        <label class="form-label">Upload New Logo (Optional)</label>
        <input type="file" name="party_logo" class="form-control">
    </div>
    <div class="text-center">
    <button type="submit" class="btn btn-primary ">UPDATE</button>
    <a href="manage_party.php" class="btn btn-secondary  mx-4">BACK</a>
</div>
</form>

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
