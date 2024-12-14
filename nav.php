<?php include 'api/connection.php'; ?>


<?php
include 'api/connection.php';


// Get the ID from the URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Default member name
$memberName = 'User';

// Query to find the member by ID and get their name
$sql = "SELECT name FROM member WHERE memberID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

// If the member is found
if ($stmt->num_rows > 0) {
    $stmt->bind_result($fullName);
    $stmt->fetch();
    // Extract the first name from the full name
    $memberName = explode(' ', $fullName)[0];
}




// Query to count the total number of members
$sql = "SELECT COUNT(*) AS memberCount FROM member";
$result = $conn->query($sql);

// Fetch the member count
$memberCount = ($result->num_rows > 0) ? $result->fetch_assoc()['memberCount'] : 0;

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="icon" type="image/x-icon" href="images/logo.png">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CJCRSG</title>
    <!-- Linking Google fonts for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="css/event.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
 
  <!-- DataTables CSS -->
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<style>
   body {
        margin: 0;
        padding: 0;
        background-image: url('images/bg-myatt.png'); /* Use your file path */
        background-size: cover; /* Ensures the image covers the entire screen */
        background-position: center; /* Centers the image */
        background-repeat: no-repeat; /* Prevents the image from repeating */
        background-attachment: fixed; /* Keeps the image fixed during scrolling */
        font-family: Arial, sans-serif; /* Apply a clean font style */
    }
    /* Custom hover style for dropdown items */
    .dropdown-menu .dropdown-item:hover {
      background-color: #435186 !important;
      color: white !important; /* Ensures the text remains visible */
    }
  </style>
  <body>





  <header>
    <nav class="navbar" >
        <span class="hamburger-btn material-symbols-rounded">menu</span>
        <a href="#" class="logo">
            <img src="images/logo.png" alt="logo">
            <h2>CJCRSG</h2>
        </a>
        <ul class="links">
            <span class="close-btn material-symbols-rounded">close</span>
            <li><a href="home.php?id=<?php echo $_GET['id']; ?>">Home</a></li>
            <li><a href="myattendance.php?id=<?php echo $_GET['id']; ?>">Attendance</a></li>
            <li><a href="announcement.php?id=<?php echo $_GET['id']; ?>">Announcement</a></li>
        </ul>

          <!-- Dropdown Menu -->
          <div class="dropdown">
        <button
            class="btn dropdown-toggle"
            type="button"
            id="userDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            style="background-color: white; color: black; border: 1px solid #ccc;"
        >
            <i class="bi bi-person-circle" style="color: #275360; margin-right: 5px;"></i> 
            <?php echo htmlspecialchars($memberName); ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="profile.php?id=<?php echo $_GET['id']; ?>">Profile</a></li>
            <li><a class="dropdown-item" href="feedback.php">concern</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>

        </ul>


        <!-- Logout Confirmation Modal -->


    </div>
    
      </nav>
  </header>
  <!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <a href="api/logout.php" class="btn btn-primary" style="background-color: #465CB1; border-color: #465CB1; color: white;">Yes</a>
      </div>
    </div>
  </div>
</div>


<div class="form-popup"></div>
      




</script>

    <!-- Linking custom script -->
    <script src="js/dashbooard.js"></script>
</body>
</html>