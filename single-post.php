<?php
    // Initialize the session and starts to capture to be interactive throughout the application
    session_start();
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

    <section class="single-post-content">
      <div class="container">
        <div class="row">
          <div class="col-md-9 post-content" data-aos="fade-up">

            <!-- ======= Single Post Content ======= -->
            <!-- Assignment 3, Task: This page loads from the events.php page when a user selects a title/image to display more information about an event using query strings passed. -->
            <?php
                require_once 'serverlogin.php';

                // Connecting to the database using OOP approach
                $db_conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
                if ($db_conn->connect_error) {
                    die("Connection failed!" . $conn->connect_error);
                }

                // Queries
                $event_number = $_GET['event-number'];

                // Retrieve all info about events, group name, contact name and email, and event type
                $db_query = "SELECT evnt.*, grp.GroupName, grp.ContactName, grp.ContactEmail, evtype.EventType  
                FROM Events evnt 
                JOIN Groups grp ON evnt.GroupID = grp.GroupID
                JOIN EventTypes evtype ON evnt.EventTypeID = evtype.EventTypeID
                WHERE EventID = $event_number";
                $result = $db_conn->query($db_query);

                // Display all information of each Event from each row in the database
                $event = $result->fetch_assoc();

                // Variables
                $first_character = substr($event["EventDesc"], 0, 1); // Takes the first character of the string
                $description = ltrim($event["EventDesc"], $first_character); // Removes the first character of the string
                // Convert the timestamp to separate date and time
                $date = date("D d M, Y", strtotime($event["EventDate"])); // Date in D d M, Y format
                $time = date("h:i A", strtotime($event["EventDate"])); // Time in HH:MM AM/PM format

                // Using heredoc, create the div container containing the image, name, type and description for Single Post Content
                $events_container = <<<EVENT
                    <div class="single-post">
                        <div class="post-meta"><span class="date">{$event["EventType"]}</span> <span class="mx-1">&bullet;</span> <span>DATE: $date TIME: $time</span></div>
                        <h1 class="mb-5">{$event["EventTitle"]}</h1>
                        <h3>Organizers: {$event["GroupName"]}</h3>
                        <h3 class="mb-5">(Contact {$event["ContactName"]} at {$event["ContactEmail"]} for more info)</h3>
                        <p><span class="firstcharacter">$first_character</span>$description</p>
                        <img src="{$event["EventImage"]}" alt="" class="img-fluid">
                    </div> <!-- End Single Post Content -->
                EVENT;
                // Display the div container
                echo $events_container;

                // Close connection
                $db_conn->close();
            ?>

            <!-- ======= Comments ======= -->
            <div class="comments">
              <h5 class="comment-title py-4">2 Comments</h5>
              <div class="comment d-flex mb-4">
                <div class="flex-shrink-0">
                  <div class="avatar avatar-sm rounded-circle">
                    <img class="avatar-img" src="assets/img/person-5.jpg" alt="" class="img-fluid">
                  </div>
                </div>
                <div class="flex-grow-1 ms-2 ms-sm-3">
                  <div class="comment-meta d-flex align-items-baseline">
                    <h6 class="me-2">Jordan Singer</h6>
                    <span class="text-muted">2d</span>
                  </div>
                  <div class="comment-body">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non minima ipsum at amet doloremque qui magni, placeat deserunt pariatur itaque laudantium impedit aliquam eligendi repellendus excepturi quibusdam nobis esse accusantium.
                  </div>

                  <div class="comment-replies bg-light p-3 mt-3 rounded">
                    <h6 class="comment-replies-title mb-4 text-muted text-uppercase">2 replies</h6>

                    <div class="reply d-flex mb-4">
                      <div class="flex-shrink-0">
                        <div class="avatar avatar-sm rounded-circle">
                          <img class="avatar-img" src="assets/img/person-4.jpg" alt="" class="img-fluid">
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-2 ms-sm-3">
                        <div class="reply-meta d-flex align-items-baseline">
                          <h6 class="mb-0 me-2">Brandon Smith</h6>
                          <span class="text-muted">2d</span>
                        </div>
                        <div class="reply-body">
                          Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                        </div>
                      </div>
                    </div>
                    <div class="reply d-flex">
                      <div class="flex-shrink-0">
                        <div class="avatar avatar-sm rounded-circle">
                          <img class="avatar-img" src="assets/img/person-3.jpg" alt="" class="img-fluid">
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-2 ms-sm-3">
                        <div class="reply-meta d-flex align-items-baseline">
                          <h6 class="mb-0 me-2">James Parsons</h6>
                          <span class="text-muted">1d</span>
                        </div>
                        <div class="reply-body">
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio dolore sed eos sapiente, praesentium.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="comment d-flex">
                <div class="flex-shrink-0">
                  <div class="avatar avatar-sm rounded-circle">
                    <img class="avatar-img" src="assets/img/person-2.jpg" alt="" class="img-fluid">
                  </div>
                </div>
                <div class="flex-shrink-1 ms-2 ms-sm-3">
                  <div class="comment-meta d-flex">
                    <h6 class="me-2">Santiago Roberts</h6>
                    <span class="text-muted">4d</span>
                  </div>
                  <div class="comment-body">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto laborum in corrupti dolorum, quas delectus nobis porro accusantium molestias sequi.
                  </div>
                </div>
              </div>
            </div><!-- End Comments -->

            <!-- ======= Comments Form ======= -->
            <div class="row justify-content-center mt-5">

              <div class="col-lg-12">
                <h5 class="comment-title">Leave a Comment</h5>
                <div class="row">
                  <div class="col-lg-6 mb-3">
                    <label for="comment-name">Name</label>
                    <input type="text" class="form-control" id="comment-name" placeholder="Enter your name">
                  </div>
                  <div class="col-lg-6 mb-3">
                    <label for="comment-email">Email</label>
                    <input type="text" class="form-control" id="comment-email" placeholder="Enter your email">
                  </div>
                  <div class="col-12 mb-3">
                    <label for="comment-message">Message</label>

                    <textarea class="form-control" id="comment-message" placeholder="Enter your name" cols="30" rows="10"></textarea>
                  </div>
                  <div class="col-12">
                    <input type="submit" class="btn btn-primary" value="Post comment">
                  </div>
                </div>
              </div>
            </div><!-- End Comments Form -->

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
      
                    // Retrieve the correct list of events to display on the side panel
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
