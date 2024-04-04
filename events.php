<?php
    // Initialize the session and starts to capture to be interactive throughout the application
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Assignment 1, Task: Renamed the title from "Zenblog Template - Index" to "What's Happening" -->
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
    <section>
      <div class="container">
        <div class="row">

          <div class="col-md-9" data-aos="fade-up">

            <!-- Assignment 3, Task: Populate and dynamically display the event with their image, title, community group, date and category from the database -->
            <?php
                require_once 'serverlogin.php';

                // Retrieve the query string that is selected containing the category
                // This variable first check if the category is empty, if it is then assign it to "All" else the actual value of the GET method
                $category = empty($_GET['category']) ? "All" : $_GET['category'];

                // Update the name based on the category selected and display it
                echo "<h3 class=\"category-title\">EVENT CATERGORY: $category</h3>";

                // Connecting to the database using OOP approach
                $db_conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
                if ($db_conn->connect_error) {
                    die("Connection failed!" . $conn->connect_error);
                }

                // Queries
                $db_query; // This query string will contain the query for displaying specific events or all.

                // If there is a specific category selected display rows that is part of that category
                if ($category != "All") {
                    $db_category;
                    $db_type_query = "SELECT * FROM EventTypes"; // Select all rows inside the EventTypes Table
                    $output = $db_conn->query($db_type_query);

                    // Inside EventTypes table, if the category is found then display all events related to that category
                    if ($output->num_rows > 0) {
                        while ($row = $output->fetch_assoc()) {
                            if ($row["EventType"] == $category) {
                                $db_category = $row["EventTypeID"];
                                break;
                            }
                        }
                    }

                    // The query will now only display the selected category
                    $db_query = "SELECT evnt.*, grp.GroupName, grp.GroupImage, evtype.EventType 
                    FROM Events evnt 
                    JOIN Groups grp ON evnt.GroupID = grp.GroupID
                    JOIN EventTypes evtype ON evnt.EventTypeID = evtype.EventTypeID
                    WHERE evnt.EventTypeID = $db_category
                    ORDER BY evnt.EventDate ASC";
                }
                else {
                    // If none was found (e.g. Category = All), then display all events
                    // Basically select all rows inside the Events Table
                    $db_query = "SELECT evnt.*, grp.GroupName, grp.GroupImage, evtype.EventType  
                    FROM Events evnt 
                    JOIN Groups grp ON evnt.GroupID = grp.GroupID
                    JOIN EventTypes evtype ON evnt.EventTypeID = evtype.EventTypeID
                    ORDER BY evnt.EventDate ASC";
                }

                // This result contains the query created either by specific category or show all
                $result = $db_conn->query($db_query);

                // Display all information of each Group from each row in the database
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Convert the timestamp to separate date and time
                        $date = date("d-M-y", strtotime($row["EventDate"])); // Date in DD-MM-YY format
                        $time = date("h:i A", strtotime($row["EventDate"])); // Time in HH:MM AM/PM format

                        // Using heredoc, create each div container containing the image, name, type and description
                        $events_container = <<<EVENT
                            <div class="d-md-flex post-entry-2 half">
                                <a href="single-post.php?event-number={$row["EventID"]}" class="me-4 thumbnail">
                                    <img src="{$row["EventImage"]}" alt="" class="img-fluid">
                                </a>
                                <div>
                                    <div class="post-meta"><span class="date">{$row["EventType"]}</span> <span class="mx-1">&bullet;</span> <span>$date</span> <span class="mx-1">&bullet;</span> <span>$time</span></div>
                                    <h3><a href="single-post.php?event-number={$row["EventID"]}">{$row["EventTitle"]}</a></h3>
                                    <div class="d-flex align-items-center author">
                                    <div class="photo"><img src="{$row["GroupImage"]}" alt="" class="img-fluid"></div>
                                    <div class="name">
                                        <h3 class="m-0 p-0">{$row["GroupName"]}</h3>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        EVENT;
                        // Display each div containers
                        echo $events_container;
                    }
                }
    
                // Close connection
                $db_conn->close();
            ?>

            <div class="text-start py-4">
              <div class="custom-pagination">
                <a href="#" class="prev">Prevous</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#" class="next">Next</a>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <!-- ======= Sidebar ======= -->
            <div class="aside-block">

              <!-- Assignment 1, Task: Modified the colum slider to only contain 2 headers: Upcoming and Latest Added -->
              <!-- With the new changes, I made sure that both headers still work with their new proper names of Upcoming and Latest Added -->
              <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-upcoming-tab" data-bs-toggle="pill" data-bs-target="#pills-upcoming" type="button" role="tab" aria-controls="pills-upcoming" aria-selected="true">Upcoming</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-latest-tab" data-bs-toggle="pill" data-bs-target="#pills-latest" type="button" role="tab" aria-controls="pills-latest" aria-selected="false">Latest Added</button>
                </li>
              </ul>

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab">
                  <!-- Assignment 4, Task: Upcoming side panel will list in order all events by the EventDate (closest date first) -->
                  <?php
                    require_once 'serverlogin.php';

                    // Connecting to the database using OOP approach
                    $db_conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
                    if ($db_conn->connect_error) {
                        die("Connection failed!" . $conn->connect_error);
                    }
      
                    // Retrieve the correct Event/s to display dynamically on the side panel
                    $db_query = "SELECT * From Events ORDER BY EventDate ASC";
                    $db_result = $db_conn->query($db_query);
                    if ($db_result->num_rows > 0) {
                      while ($db_event = $db_result->fetch_assoc()) {

                        // Retrieve the Event Type given the Event Type ID associated from the event
                        $db_eventTypes_query = "SELECT EventType From EventTypes WHERE EventTypeID=" . $db_event["EventTypeID"];
                        $type_result = $db_conn->query($db_eventTypes_query);
                        $db_eventType = $type_result->fetch_assoc();

                        // Retrieve the Group Name given the Group ID associated from the event
                        $db_groups_query = "SELECT GroupName From Groups WHERE GroupID=" . $db_event["GroupID"];
                        $group_result = $db_conn->query($db_groups_query);
                        $db_group = $group_result->fetch_assoc();

                        // Convert the timestamp to separate date and time
                        $date = date("d-M-y", strtotime($db_event["EventDate"])); // Date in DD-MM-YY format

                        // Using heredoc, create the div container containing the event that is happening soon
                        $upcoming_container = <<<UPCOMING
                          <div class="post-entry-1 border-bottom">
                            <div class="post-meta"><span class="date">{$db_eventType["EventType"]}</span> <span class="mx-1">&bullet;</span> <span>$date</span></div>
                            <h2 class="mb-2"><a href="single-post.php?event-number={$db_event["EventID"]}">{$db_event["EventTitle"]}</a></h2>
                            <span class="author mb-3 d-block">{$db_group["GroupName"]}</span>
                          </div>
                        UPCOMING;

                        // Display the div container
                        echo $upcoming_container;
                      }
                    }
                    
                    // Close the connection
                    $db_conn->close();
                  ?>
                </div> <!-- End Upcoming -->

                <!-- Assignment 4, Task: Latest side panel will list in order all events by the most recent added event (Submit Date) -->
                <div class="tab-pane fade" id="pills-latest" role="tabpanel" aria-labelledby="pills-latest-tab">
                  <?php
                    require_once 'serverlogin.php';

                    // Connecting to the database using OOP approach
                    $db_conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
                    if ($db_conn->connect_error) {
                        die("Connection failed!" . $conn->connect_error);
                    }
      
                    // Display in order all the events by most recent added event
                    $db_query = "SELECT * From Events ORDER BY SubmitDate DESC";
                    $db_result = $db_conn->query($db_query);
                    if ($db_result->num_rows > 0) {
                      while ($db_event = $db_result->fetch_assoc()) {

                        // Retrieve the Event Type given the Event Type ID associated from the event
                        $db_eventTypes_query = "SELECT EventType From EventTypes WHERE EventTypeID=" . $db_event["EventTypeID"];
                        $type_result = $db_conn->query($db_eventTypes_query);
                        $db_eventType = $type_result->fetch_assoc();

                        // Retrieve the Group Name given the Group ID associated from the event
                        $db_groups_query = "SELECT GroupName From Groups WHERE GroupID=" . $db_event["GroupID"];
                        $group_result = $db_conn->query($db_groups_query);
                        $db_group = $group_result->fetch_assoc();

                        // Convert the timestamp to separate date and time
                        $date = date("d-M-y", strtotime($db_event["EventDate"])); // Date in DD-MM-YY format

                        // Using heredoc, create the div container containing the event that is happening soon
                        $latest_container = <<<LATEST
                          <div class="post-entry-1 border-bottom">
                            <div class="post-meta"><span class="date">{$db_eventType["EventType"]}</span> <span class="mx-1">&bullet;</span> <span>$date</span></div>
                            <h2 class="mb-2"><a href="single-post.php?event-number={$db_event["EventID"]}">{$db_event["EventTitle"]}</a></h2>
                            <span class="author mb-3 d-block">{$db_group["GroupName"]}</span>
                          </div>
                        LATEST;

                        // Display the div container
                        echo $latest_container;
                      }
                    }
                    // Close the connection
                    $db_conn->close();
                  ?>
                </div> <!-- End Latest -->

              </div>
            </div>

            <!-- Assignment 1, Task: Removed the video section based on the given instructions. Do not need anymore. -->
            <!-- Assignment 1, Task: Updated the Categories heading to Events providing the Events categories while making sure they are linked to the main Events page. -->
            <!-- Assignment 2, Task: The links should contain a query string called Category to filter events in events.php -->
            <div class="aside-block">
              <h3 class="aside-title">Events</h3>
              <ul class="aside-links list-unstyled">
                <li><a href="events.php?category=All"><i class="bi bi-chevron-right"></i> All Events</a></li>
                <li><a href="events.php?category=Music"><i class="bi bi-chevron-right"></i> Music</a></li>
                <li><a href="events.php?category=Art%2BCulture"><i class="bi bi-chevron-right"></i> Art+Culture</a></li>
                <li><a href="events.php?category=Sports"><i class="bi bi-chevron-right"></i> Sports</a></li>
                <li><a href="events.php?category=Food"><i class="bi bi-chevron-right"></i> Food</a></li>
                <li><a href="events.php?category=Fund Raiser"><i class="bi bi-chevron-right"></i> Fund Raiser</a></li>
              </ul>
            </div><!-- End Events -->

            <!-- Assignment 1, Task: Updated the Tag section to contain the same Events categories above and also making sure they are also linked to the main Events page. -->
            <!-- Assignment 2, Task: The links should contain a query string called Category to filter events in events.php -->
            <div class="aside-block">
              <h3 class="aside-title">Tags</h3>
              <ul class="aside-tags list-unstyled">
                <li><a href="events.php?category=All">All Events</a></li>
                <li><a href="events.php?category=Music">Music</a></li>
                <li><a href="events.php?category=Art%2BCulture">Art+Culture</a></li>
                <li><a href="events.php?category=Sports">Sports</a></li>
                <li><a href="events.php?category=Food">Food</a></li>
                <li><a href="events.php?category=Fund Raiser">Fund Raiser</a></li>
              </ul>
            </div><!-- End Tags -->

          </div>

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
