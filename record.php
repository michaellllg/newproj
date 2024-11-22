
<?php
include 'api/login.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CJCRSG</title>
    <!-- Linking Google fonts for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="css/record.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
     <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="https://cdn.jsdelivr.net/npm/datatables@1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/logout.js"></script>
  </head>
 
  <body>





    <header>
      <nav class="navbar">
          <span class="hamburger-btn material-symbols-rounded">menu</span>
          <a href="#" class="logo">
              <img src="images/logo.png" alt="logo">
              <h2>CJCRSG</h2>
          </a>
          <ul class="links">
              <span class="close-btn material-symbols-rounded">close</span>
              <li><a  href="dashboard.php?id=<?php echo $_GET['id']; ?>">Dashboard</a></li>
              <li><a  href="member.php?id=<?php echo $_GET['id']; ?>">Member</a></li>
              <li><a  href="record.php?id=<?php echo $_GET['id']; ?>">Attendance</a></li>
              <li><a  href="event.php?id=<?php echo $_GET['id']; ?>">Event</a></li>
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
            <li><a class="dropdown-item" href="#">Settings</a></li>
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
        <a href="api/logout.php" class="btn btn-primary">Yes</a>
      </div>
    </div>
  </div>
</div>



  
  <div class="form-popup"></div>
      


    <div class="container mt-1">

    

<div class="container-wrapper">
<div class="admin-container">
  <label class="admin-greeting">Attendance Record!</label>
  <label class="admin-description">Lorem ipsum dolor sit amet consectetur adipisicing elit.</label>
</div>
</div>
        

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>



<!-- Search and Filter -->
<div class="row mb-3 align-items-center">
    <div class="col-md-6">
        <div class="input-group w-50">
            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>
    </div>
    <div class="col-md-6 d-flex justify-content-end align-items-center">
    <input type="date" id="dateFilter" class="form-control" style="width: 150px; margin-right: 10px;">
        <button id="printButton" class="btn btn-outline-secondary ms-2" style="background-color: #636EA0; color: white; border-color: #636EA0;">
            <i class="bi bi-printer"></i>
        </button>
    </div>
</div>


<?php
// Define database connection parameters
$servername = "localhost";  // Adjust the server name as needed
$username = "root";         // Adjust the username as needed
$password = "";             // Adjust the password as needed
$dbname = "cjcrsg";         // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
SELECT 
    a.atten_id AS id, 
    m.memberID,
    m.name, 
    DATE_FORMAT(a.date, '%b %d, %Y') AS formatted_date,
    DATE_FORMAT(a.date, '%h:%i %p') AS formatted_time
FROM 
    attendance a
JOIN 
    member m 
ON 
    a.memberID = m.memberID
";

$result = $conn->query($sql);

// Initialize an array to store the combined data
$combinedData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $combinedData[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!-- HTML to display the table -->
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="dataTable">
    <thead class="table-black">
    <tr>
        <th scope="col" data-sort="name">Member ID
            <span class="sort-icon">&#9650;&#9660;</span>
        </th>
        <th scope="col" data-sort="name">Name
            <span class="sort-icon">&#9650;&#9660;</span>
        </th>
        <th scope="col" data-sort="date">Date
            <span class="sort-icon">&#9650;&#9660;</span>
        </th>
        <th scope="col" data-sort="time">Time
            <span class="sort-icon">&#9650;&#9660;</span>
        </th>
        <th scope="col" style="width: 15%;">Actions</th>
    </tr>
</thead>
<tbody>
    <?php
    foreach ($combinedData as $row) {
        // Extract date and time parts from 'formatted_date'
        $rowDate = date('Y-m-d', strtotime($row['formatted_date'])); // 'YYYY-MM-DD'
        $rowTime = date('h:i A', strtotime($row['formatted_date'])); // 'hh:mm AM/PM'

        echo "<tr data-date='" . $rowDate . "'>";
        echo "<td>" . $row['memberID'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $rowDate . "</td>"; // Display Date
        echo "<td>" . $rowTime . "</td>"; // Display Time
        echo "<td>
                <button class='btn btn-danger btn-sm'>Delete</button>
                <button class='btn btn-warning btn-sm'>Report</button>
              </td>";
        echo "</tr>";
    }
    ?>
</tbody>



    </table>
</div>


<!-- Pagination -->
<nav>
    <ul class="pagination justify-content-center" id="pagination">
        <!-- Pagination items will be dynamically created -->
    </ul>
</nav>
<script>
   document.getElementById('dateFilter').addEventListener('input', function () {
    const selectedDate = this.value; // Get selected date in 'YYYY-MM-DD' format
    const rows = document.querySelectorAll('#dataTable tbody tr'); // Get all rows

    rows.forEach(row => {
        const rowDate = row.getAttribute('data-date'); // Get the date from the data-date attribute

        // Show rows that match the selected date or if no date is selected
        if (!selectedDate || rowDate === selectedDate) {
            row.style.display = ''; // Show row
        } else {
            row.style.display = 'none'; // Hide row
        }
    });
});

</script>
<script>
    // Function to handle the print button click
    document.getElementById("printButton").addEventListener("click", function () {
        var table = document.getElementById("dataTable"); // Get the table element
        
        // Hide the "Actions" column (the last column in the table)
        var actionsColumnIndex = table.rows[0].cells.length - 1; // Last column index
        for (var i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[actionsColumnIndex].style.display = 'none'; // Hide actions column
        }

        // Create a new window for printing
        var printWindow = window.open('', '', 'height=800,width=600');
        
        // Add the table content into the print window's document
        printWindow.document.write('<html><head><title>Cjc data</title>');
        printWindow.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {padding: 8px 12px; text-align: left; border: 1px solid #ddd;} th {background-color: #f2f2f2;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h2>Member Data</h2>');
        printWindow.document.write(table.outerHTML); // Insert the table content
        printWindow.document.write('</body></html>');
        
        // Wait for the content to be loaded before triggering the print dialog
        printWindow.document.close(); // Close the document to finish loading
        printWindow.print(); // Trigger the print dialog

        // After printing, restore the "Actions" column visibility
        setTimeout(function() {
            for (var i = 0; i < table.rows.length; i++) {
                table.rows[i].cells[actionsColumnIndex].style.display = ''; // Restore actions column
            }
        }, 1000); // Wait 1 second before restoring to ensure print dialog is triggered
    });
</script>



    <!-- Bootstrap JS and Popper.js -->
    
    <script>
        const rowsPerPage = 5;
        let currentPage = 1;

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function () {
            filterTable();
        });

        // Filter functionality
        document.getElementById('filterInput').addEventListener('change', function () {
            filterTable();
        });

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filterTerm = document.getElementById('filterInput').value;
            const rows = document.querySelectorAll('#dataTable tbody tr');
            rows.forEach(row => {
                const name = row.cells[0].innerText.toLowerCase();
                const email = row.cells[1].innerText.toLowerCase();
                const status = row.getAttribute('data-status');
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesFilter = !filterTerm || status === filterTerm;
                row.style.display = matchesSearch && matchesFilter ? '' : 'none';
            });
            setupPagination();
        }

        // Sort functionality
        const headers = document.querySelectorAll('#dataTable thead th[data-sort]');
        headers.forEach(header => {
            header.addEventListener('click', function () {
                const sortKey = header.getAttribute('data-sort');
                const isAscending = header.classList.toggle('asc');
                sortTable(sortKey, isAscending);
            });
        });

        function sortTable(key, ascending) {
            const tbody = document.querySelector('#dataTable tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const columnIndex = [...headers].findIndex(h => h.getAttribute('data-sort') === key);
            rows.sort((a, b) => {
                const aText = a.cells[columnIndex].innerText.toLowerCase();
                const bText = b.cells[columnIndex].innerText.toLowerCase();
                return ascending ? aText.localeCompare(bText) : bText.localeCompare(aText);
            });
            rows.forEach(row => tbody.appendChild(row));
        }

        


        
       
    </script>



  
   

    
  </body>
</html>