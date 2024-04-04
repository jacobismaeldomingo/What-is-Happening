<?php
    // Initialize the session and starts to capture to be interactive throughout the application
    session_start();

    // Assignment 3, Task: Allows groups to add new events by adding a new row on the end of the database
    require_once 'serverlogin.php';

    // Check if the user is not yet logged in
    if (!isset($_SESSION["username"]) && !isset($_SESSION["login"])) {
        // Redirects the user to the login.php page
        header("location: login.php");
        exit();
    }

    // Connecting to the database using OOP approach
    $db_conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($db_conn->connect_error) {
        die("Connection failed!" . $conn->connect_error);
    }

    // Check first if the form was submitted via post method
    // This php code is added here because it ensures that server-side processing happens before the HTML content is sent to the client.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the data for each form fields 
        $event_title = $_POST["event-title"];
        $event_date = $_POST["event-date"];
        $event_time = $_POST["event-time"];
        $event_type = $_POST["event-type"];
        $image_name = $_POST["image-name"];
        $event_description = $_POST["event-description"];

        // This checks the fields if they are set or has values
        if (isset($event_title) and isset($event_date) and isset($event_time) and isset($event_type) and isset($image_name) and isset($event_description)) {

            // Create a Prepared Statement Query 
            $newEvent = $db_conn->prepare("INSERT INTO Events(EventTypeID, GroupID, EventDate, SubmitDate, EventTitle, EventImage, EventDesc) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            // Bind the parameters
            $newEvent->bind_param("iisssss", $eventTypeID, $groupID, $eventDate, $submitDate, $eventTitle, $eventImage, $eventDesc);

            // Queries - Specifically for EvenTypeID and GroupID
            // Retrieve the correct Event Type to get the ID assosiated with it to store for EventTypeID
            $db_eventType_query = "SELECT * From EventTypes WHERE EventType='$event_type'";
            $type_result = $db_conn->query($db_eventType_query);
            $associated_eventTypeID;
            if ($type_result->num_rows === 1) {
                $eventType = $type_result->fetch_assoc();
                $associated_eventTypeID = $eventType["EventTypeID"];
            }

            // Retrieve the correct Community Group to get the ID assosiated with it to store for GroupID
            $group_id = $_SESSION["GroupID"];
            $db_group_query = "SELECT * From Groups WHERE GroupID=$group_id";
            $group_result = $db_conn->query($db_group_query);
            $associated_groupID;
            if ($group_result->num_rows === 1) {
                $eventGroup = $group_result->fetch_assoc();
                $associated_groupID = $eventGroup["GroupID"];
            }

            // Event Date Formmating - Convert the date and time to timestamp
            $date = date("Y-m-d", strtotime($event_date)); // Date in YYYY-mm-dd format
            $time = date("H:i:s", strtotime($event_time)); // Time in HH:ii:ss format

            // Store the information to the database
            $eventTypeID = $associated_eventTypeID;
            $groupID = $associated_groupID;
            $eventDate = $date . " " . $time;
            // Store the current timestamp
            $submitDate = date('Y-m-d H:i:s');
            $eventTitle = $event_title;
            // Store the image name with the correct file path
            $eventImage = "files/images/events/" . $image_name . ".jpg";
            $eventDesc = $event_description;

            // Execute the query to insert the data
            $newEvent->execute();

            // Close connection
            $newEvent->close();
            $db_conn->close();     
            
            // This is important as this indicate that the event was successfully created and display a success message box on the page
            echo "OK";
            exit();
        }
        else {
            // Error message if one or more fields is not yet filled out
            echo "Oops! One/more of your fields has not yet been filled out!";
        }
    }
    $db_conn->close(); 
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
          <div class="col-lg-12 text-center mb-3">
            <!-- Assignment 2, Task: Changed the name to be Post New Event as this page will serve as the page where groups can add a new event -->
            <h1 class="page-title">Post New Event</h1>
            <!-- Assignment 4, Task: Name of the group that is logged in is shown -->
            <?php 
              require_once 'serverlogin.php';

              // Connecting to the database using OOP approach
              $db_conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
              if ($db_conn->connect_error) {
                  die("Connection failed!" . $conn->connect_error);
              }

              // Retrieve the correct Community Group to get the ID assosiated with it to store for GroupID
              $group_id = $_SESSION["GroupID"];
              $db_query = "SELECT * From Groups WHERE Groups.GroupID=$group_id";
              $group_result = $db_conn->query($db_query);
              if ($group_result->num_rows === 1) {
                $group = $group_result->fetch_assoc();
                echo "<h4 class=\"text-center mt-3\">" . $group["GroupName"] . "</h4>";
              }
              
              $db_conn->close();
            ?>
          </div>
        </div>

        <!-- Assignment 2, Task: New form fields created and used for to gather information about the new event that will be posted to events.php -->
        <div class="form mt-3">
            <form action="post.php" method="post" role="form" class="php-email-form">
                <div class="form-group">
                    <input type="text" class="form-control" name="event-title" id="event-title" placeholder="Your Event Title" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="event-date" id="event-date" placeholder="Your Event Date (Format: day-month-year)" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="event-time" id="event-time" placeholder="Your Event Time (Format: hours:minutes AM/PM)" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="event-type" id="event-type" placeholder="Your Event Type" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="image-name" id="image-name" placeholder="Image Name" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="event-description" rows="5" placeholder="The Event Description" required></textarea>
                </div>
                <div class="my-3">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your new event has been added. Check the events page to see your new event post!</div>
                </div>
                <!-- Assignment 2, Task: When this button is clicked a new Event should be added in events.php and also the .csv file is updated -->
                <div class="text-center"><button type="submit" name="submit">Submit</button></div>
            </form>
        </div><!-- End Event Form -->
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
