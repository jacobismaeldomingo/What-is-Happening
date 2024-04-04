<?php
  // Initialize the session and starts to capture to be interactive throughout the application
  session_start();

  // Assignment 4, Task: Validate the user login credentials by checking if the username exists in the database and the password is correct
  require_once 'serverlogin.php';
    
  if (!empty($_GET['status']) && $_GET['status'] == "Logout") {
    // Unset all of the session variables.
    session_unset();
    // Destroy the session.
    session_destroy();
    // Redirect to Login page to login again
    header("location: login.php");
    exit();
  }

  // Check if the user is already logged in
  if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    // Redirects the user to the post.php page
    header("location: post.php");
    exit();
  }

  // Connecting to the database using OOP approach
  $db_conn = new mysqli('localhost', 'root', 'root', 'whats_happening');
  if ($db_conn->connect_error) {
    die("Connection failed!" . $conn->connect_error);
  }

  // Check first if the form was submitted via post method
  // This php code is added here because it ensures that server-side processing happens before the HTML content is sent to the client.
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data for each form fields 
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (isset($username) && isset($password)) {
      // Create a Prepared Statement Query 
      $db_login = $db_conn->prepare("SELECT * FROM Login WHERE Login.Username=?");
      // Bind the parameters
      $db_login->bind_param("s", $username);
      $db_login->execute();
      $db_result = $db_login->get_result();

      // If there is one result found that means that username exist in the database
      if ($db_result->num_rows === 1) {
        $login = $db_result->fetch_assoc();
          
        // If the password is the same then the login is correct
        if ($login["Password"] === $password) {
          // If all passes, store data in session variables
          $_SESSION["login"] = true;
          $_SESSION["AccountID"] = $login["AccountID"];
          $_SESSION["GroupID"] = $login["GroupID"];
          $_SESSION["username"] = $username;
        
          // Close connections
          $db_result->close();
          $db_conn->close();

          // This indicate that the login was successful and displays a success message box on the page
          echo "OK";
          exit();
        }
        else {
          // Close connections
          $db_result->close();
          $db_conn->close();

          // Incorrect input of password
          echo "Password is incorrect, please try again.";
          exit();
        }
      }
      else {
        // Close connections
        $db_result->close();
        $db_conn->close();

        // The username is not found in the database
        echo "Username is incorrect, please try again.";
        exit();
      }
    }
    else {
      // Close connections
      $db_result->close();
      $db_conn->close();

      // Error - Both inputs are wrong
      echo "Wrong credentials! Enter your username and password correctly.";
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Renamed the title from "Zenblog Template - Index" to "What's Happening" -->
  <title>What's Happening</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS Files -->
  <link href="assets/css/variables.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: ZenBlog
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/zenblog-bootstrap-blog-template/
  * Author: BootstrapMade.com
  * License: https:///bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <!-- Assignment 1, Task: Updated the name from "Zenblog" to "What's Happening" and changed its link to go its corresponding page (index.php) -->
      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>What's Happening</h1>
      </a>

      <!-- Assignment 1, Task: Updated the entire navigation bar by introducing new titles, removed some titles, and refining existing ones -->
      <!-- Assignment 2, Task: Ensured functionality of all corresponding links works properly especially those with query strings -->
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li class="dropdown"><a href="events.php"><span>Events</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="events.php?category=All">All Events</a></li>
              <li><a href="events.php?category=Music">Music</a></li>
              <li class="dropdown"><a href="events.php?category=Art%2BCulture"><span>Art+Culture</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="events.php?category=Sports">Sports</a></li>
              <li><a href="events.php?category=Food">Food</a></li>
              <li><a href="events.php?category=Fund Raiser">Fund Raiser</a></li>
            </ul>
          </li>

          <!-- Assignment 1&2, Task: New nagivation titles added -->
          <li><a href="groups.php">Community Groups</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="post.php">Post Event</a></li>
          <li class="dropdown"><a href="login.php"><span>Login</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="login.php">Login</a></li>
                <!-- Assignment 4: This link will end the session/logout the user -->
              <li><a href="login.php?status=Logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative">
        <a href="#" class="mx-2"><span class="bi-facebook"></span></a>
        <a href="#" class="mx-2"><span class="bi-twitter"></span></a>
        <a href="#" class="mx-2"><span class="bi-instagram"></span></a>

        <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
        <i class="bi bi-list mobile-nav-toggle"></i>

        <!-- ======= Search Form ======= -->
        <div class="search-form-wrap js-search-form-wrap">
          <form action="search-result.html" class="search-form">
            <span class="icon bi-search"></span>
            <input type="text" placeholder="Search" class="form-control">
            <button class="btn js-search-close"><span class="bi-x"></span></button>
          </form>
        </div><!-- End Search Form -->

      </div>

    </div>

  </header><!-- End Header -->

  <main id="main">
    <section id="contact" class="contact mb-5">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-12 text-center mb-5">
            <!-- Changed the name to be Login as this page will serve as the Login page of the site -->
            <h1 class="page-title">Login</h1>
          </div>
        </div>

        <!-- Assignment 4, Task: Update the login page, to be able to login or create a new account, also shows the username and password -->
        <div class="form mt-5 col-md-8 mx-auto">
          <form id="login-form" action="login.php" method="post" role="form" class="php-email-form">
            <div class="form-group">
                <input type="text" name="username" class="form-control" id="username" placeholder="Your Username" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="password" id="password" placeholder="Your Password" required>
            </div>
            <!-- <input type="hidden" name="logged-in" value=""/> -->
            <div class="my-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">You have successfully logged in. Enjoy!</div>
            </div>
            <!-- Assignment 4, Task: When this button is clicked, the system will check if the username exists in the database then checks if the password is correct -->
            <div class="text-center"><button type="submit" class="btn" name="login-button">Login</button></div>
          </form>
        </div><!-- End Login Form -->

        <!-- Assignment 4: This script is used to redirect a user to post.php after a sucessful login
        If the user got any error message, they stay at login and display the error message for a short amount of time
        then the page resets to let the user try again. -->
        <script>
          document.getElementById("login-form").addEventListener("submit", function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();

            // Check if there is an error message
            let errorMessage = document.querySelector('.error-message');
            if (errorMessage && errorMessage.innerText.trim() !== "") {
              // If there is an error message, do not redirect
              return;
            }
              
            // Redirect the user to post.php URL after form submission with a 1 second delay
            setTimeout(function() {
              location.href = "post.php";
            }, 500);
          });
        </script>

        <!-- Assignment 4, Task: When this button is clicked, the user will be directed to createAccount.php to create a new account. -->
        <div class="form mt-4">
          <h6 class="text-center mt-3 mb-3"><strong>Don't have an account?<br/>
          Sign up your group and start posting your events.</strong></h6>
          
          <div class="text-center"><button type="button" class="btn btn-success" onclick="window.location.href='createAccount.php';">Create Account</button></div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-content">
      <div class="container">

        <!-- Assignment 1, Task: Modified the Footer section by updating the links to be the same as the top navigation bar -->
        <!-- Assignment 2, Task: Removed the Recent Post section and also made sure all links that have query strings works properly -->
        <div class="row g-5">
          <div class="col-lg-4">
            <h3 class="footer-heading">About What's Happening</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam ab, perspiciatis beatae autem deleniti voluptate nulla a dolores, exercitationem eveniet libero laudantium recusandae officiis qui aliquid blanditiis omnis quae. Explicabo?</p>
            <p><a href="about.php" class="footer-link-more">Learn More</a></p>
          </div>
          
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Navigation</h3>
            <ul class="footer-links list-unstyled">
              <li><a href="index.php"><i class="bi bi-chevron-right"></i> Home</a></li>
              <!-- Events link will have a category 'All' to display all events assigned inside events.php -->
              <li><a href="events.php"><i class="bi bi-chevron-right"></i> Events</a></li> 
              <li><a href="groups.php"><i class="bi bi-chevron-right"></i> Community Groups</a></li>
              <li><a href="about.php"><i class="bi bi-chevron-right"></i> About</a></li>
              <li><a href="post.php"><i class="bi bi-chevron-right"></i> Post Event</a></li>
              <li><a href="login.php"><i class="bi bi-chevron-right"></i> Login</a></li>
            </ul>
          </div>

          <!-- Assignment 2, Task: Listed down the categories for Events with their respective categories for query strings -->
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Events</h3>
            <ul class="footer-links list-unstyled">
              <li><a href="events.php?category=All"><i class="bi bi-chevron-right"></i> All Events</a></li>
              <li><a href="events.php?category=Music"><i class="bi bi-chevron-right"></i> Music</a></li>
              <li><a href="events.php?category=Art%2BCulture"><i class="bi bi-chevron-right"></i> Art+Culture</a></li>
              <li><a href="events.php?category=Sports"><i class="bi bi-chevron-right"></i> Sports</a></li>
              <li><a href="events.php?category=Food"><i class="bi bi-chevron-right"></i> Food</a></li>
              <li><a href="events.php?category=Fund Raiser"><i class="bi bi-chevron-right"></i> Fund Raiser</a></li>

            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-legal">
      <div class="container">

        <div class="row justify-content-between">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <div class="copyright">
              © Copyright <strong><span>ZenBlog</span></strong>. All Rights Reserved
            </div>

            <div class="credits">
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
              Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>

          </div>

          <div class="col-md-6">
            <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

        </div>

      </div>
    </div>

  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
