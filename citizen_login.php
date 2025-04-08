<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['identifier']; // Can be mobile number or name
    $password = $_POST['password'];

    // Check if the citizen exists
    $sql = "SELECT * FROM citizens WHERE mobile_no=? OR name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify Password
        if (password_verify($password, $row['password'])) {
            $_SESSION['citizen'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['gender'] = $row['gender'];
            header("Location: vote.php");
            exit();
        } else {
            echo "<script>alert('Incorrect Password!'); window.location.href='citizen_login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid Login Credentials'); window.location.href='citizen_login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CITIZEN LOGIN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
<body>
       <!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="#">ONLINE &nbsp; VOTING &nbsp; SYSTEM</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
    <ul class="nav nav-underline  ms-auto">
  <li class="nav-item">
    <a class="nav-link fw-bold text-white" aria-current="page" href="index.php">HOME</a>
  </li>
  <li class="nav-item">
    <a class="nav-link fw-bold text-white" href="about.php">ABOUT</a>
  </li>
  <li class="nav-item">
    <a class="nav-link fw-bold text-white" href="admin_login.php">ADMIN LOGIN</a>
  </li>
        <li class="nav-item">
        <a class="nav-link active fw-bold text-white" href="citizen_login.php">CITIZEN LOGIN</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
       <!-- Citizen Login page-->
       <div class="container-fluid mt-5" style="padding-top: 100px;"> 
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>LOGIN TO YOUR ACCOUNT</h4>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="mb-2">Name or Mobile Number</label>
                                <input type="text" name="identifier" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        <!-- Registration Link -->
                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="citizen_register.php" class=" btn btn-primary">Register</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


       <!-- Footer -->
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
      <p class="mb-0">&copy; 2025 Online Voting System. All Rights Reserved.</p>
    </div>
  </div>
</footer>


</body>
 

</html>