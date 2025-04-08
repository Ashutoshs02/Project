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
       <!-- Carousel -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  
  <div class="carousel-inner">
    <!-- Slide 1 -->
    <div class="carousel-item active">
      <img src="h2.jpg" class="d-block w-100" alt="Administration">
      <div class="carousel-caption d-none d-md-block">
        <h1>"Effective administration turns vision into reality through organization and leadership."</h1>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="h3.jpg" class="d-block w-100" alt="Voting">
      <div class="carousel-caption d-none d-md-block">
        <h1>"Your vote is your voice—use it to shape the future."</h1>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item">
      <img src="h4.jpg" class="d-block w-100" alt="Unity">
      <div class="carousel-caption d-none d-md-block">
        <h1>"Unity is strength—together we rise, divided we fall."</h1>
      </div>
    </div>
  </div>

  <!-- Navigation Buttons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
       
        <!-- Key Features Section -->
<div class="container mt-5">
    <h1 class="text-center fw-bold  text-primary">Why Choose Our Voting System?</h1>
    <div class="row text-center mt-4">
        <div class="col-md-4">
            <i class="fas fa-shield-alt fa-3x text-primary"></i>
            <h4 class="mt-2">Secure & Reliable</h4>
            <p>Advanced encryption ensures votes are safe and tamper-proof.</p>
        </div>
        <div class="col-md-4">
            <i class="fas fa-check-circle fa-3x text-primary"></i>
            <h4 class="mt-2">Transparent & Fair</h4>
            <p>Real-time voting updates with a transparent counting process.</p>
        </div>
        <div class="col-md-4">
            <i class="fas fa-user-friends fa-3x text-primary"></i>
            <h4 class="mt-2">Easy & Accessible</h4>
            <p>User-friendly interface designed for citizens of all age groups.</p>
        </div>
    </div>
</div>
          <!-- Call to Action -->
<div class="container text-center mt-5">
    <h1 class=" text-primary">Ready to Vote?</h1>
    <p class="lead fw-bold">Register now and make your voice heard in the upcoming elections.</p>
    <a href="citizen_register.php" class="btn btn-lg btn-primary fw-bold">Register Now</a>
</div>

       <!-- Footer -->
<div style="padding-top: 50px;"> 
<footer class="bg-primary text-white py-4 footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>About</h5>
        <p>An online voting system designed to offer secure, transparent, and efficient elections. Your vote matters, and we ensure its integrity.</p>
      </div>
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
          <li><a href="about.php" class="text-white text-decoration-none">About</a></li>
          <li><a href="admin_login.php" class="text-white text-decoration-none">Admin Login</a></li>
          <li><a href="citizen_login.php" class="text-white text-decoration-none">Citizen Login</a></li>
        </ul>
      </div>
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
