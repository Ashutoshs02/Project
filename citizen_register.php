<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile_no = $_POST['mobile_no'];
    $aadhar_no = $_POST['aadhar_no'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt password

    // Calculate Age
    $birthdate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($birthdate)->y;

    if ($age < 18) {
        echo "<script>alert('You must be 18 or older to register as a citizen.'); window.location.href='citizen_register.php';</script>";
        exit();
    }

    
    // Check in pre-approved citizens
    $check_preapproved = "SELECT * FROM pre_approved_citizens WHERE aadhar_no=? AND mobile_no=? AND is_registered=0";
    $stmt = $conn->prepare($check_preapproved);
    $stmt->bind_param("ss", $aadhar_no, $mobile_no);
    $stmt->execute();
    $pre_result = $stmt->get_result();

    if ($pre_result->num_rows === 0) {
        echo "<script>alert('You are not pre-approved or already registered!'); window.location.href='citizen_register.php';</script>";
        exit();
    }

    // Register citizen
    $insert_query = "INSERT INTO citizens (name, mobile_no, aadhar_no, dob, gender, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssssss", $name, $mobile_no, $aadhar_no, $dob, $gender, $password);

    if ($stmt->execute()) {
        // Mark pre-approved citizen as registered
        $update_pre = "UPDATE pre_approved_citizens SET is_registered=1 WHERE aadhar_no=? AND mobile_no=?";
        $stmt = $conn->prepare($update_pre);
        $stmt->bind_param("ss", $aadhar_no, $mobile_no);
        $stmt->execute();

        echo "<script>alert('Registration successful! You can now log in.'); window.location.href='citizen_login.php';</script>";
    } else {
        echo "<script>alert('Error! Try again.'); window.location.href='citizen_register.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
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
       <!-- Citizen Registration -->
       <div class="container-fluid mt-5" style="padding-top: 75px;"> 
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>CITIZEN &nbsp; REGISTRATION</h4>
                    </div>
    <form method="POST" action="">
        <div class="card-body">
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mobile Number</label>
            <input type="text" name="mobile_no" class="form-control" required pattern="[0-9]{10}">
        </div>
        <div class="mb-3">
            <label>Aadhaar Number</label>
            <input type="text" name="aadhar_no" class="form-control" required pattern="[0-9]{12}">
        </div>
        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="dob" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>
      <!-- Footer -->
<div style="padding-top: 75px;"> 
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
      <p class="mb-0">&copy; 2025 Online Voting System. All Rights Reserved.</p>
    </div>
  </div>
</footer>

</body>
</html>
                              