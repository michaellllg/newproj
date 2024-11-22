<?php include 'api/status.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CJCRSG</title>
    <!-- Linking Google fonts for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="css/dashboard.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
     <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="https://cdn.jsdelivr.net/npm/datatables@1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
        <label class="admin-greeting">Hi, Admin <?php echo $memberName; ?>!</label>
  <label class="admin-description">Manage the attendance of CJC Members.</label>
  <a href="attendance.php"><button class="attendance-button">Add Attendance</button></a>
</div>
  <div class="containery">
    <div class="member-status-widget">
      <div class="header">
        <span class="title">Member Status</span>
        <button class="filter-button">All ▼</button>
      </div>
      <div class="progress-bar">
        <div class="inactive-bar" style="width: <?php echo round($inactivePercentage); ?>%;"></div>
        <div class="active-bar" style="width: <?php echo round($activePercentage); ?>%;"></div>
      </div>
      <div class="stats">
        <div class="total">
          <span>Total</span>
          <span><?php echo $totalCount; ?></span>
          <span>100%</span>
        </div>
        <div class="status">
          <div class="status-item">
            <span class="status-dot active"></span>
            <span class="statusw">Active</span>
            <span class="num"><?php echo $activeCount; ?></span>
            <span class="perc"><?php echo round($activePercentage); ?>%</span>
          </div>
          <div class="status-item">
            <span class="status-dot inactive"></span>
            <span class="statusw">Inactive</span>
            <span class="num"><?php echo $inactiveCount; ?></span>
            <span class="perc"><?php echo round($inactivePercentage); ?>%</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="chartCard">
    <div class="chartBox">
      <canvas id="myChart"></canvas>
      <select id="year" onchange="changeMonitoring()">
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
      </select>
      <select id="Month" onchange="changeMonitoring()">
        <option value="january">January</option>
        <option value="febuary">Febuary</option>
        <option value="march">March</option>
      </select>
    </div>
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
        <select id="filterInput" class="form-select d-inline-block " style="width: 110px; margin-right: 5px;">
            <option value="">Filter by Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
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

// Query to get the combined data from `accountinfo` and `member` tables
$sql = "
    SELECT 
        a.memberID AS id, 
        m.name, 
        a.email, 
        m.status
    FROM 
        accountinfo a
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
                <th scope="col" data-sort="name">ID
                    <span class="sort-icon">&#9650;&#9660;</span>
                </th>
                <th scope="col" data-sort="name">Name
                    <span class="sort-icon">&#9650;&#9660;</span>
                </th>
                <th scope="col" data-sort="email">Email
                    <span class="sort-icon">&#9650;&#9660;</span>
                </th>
                <th scope="col" data-sort="status">Status
                    <span class="sort-icon">&#9650;&#9660;</span>
                </th>
                <th scope="col" style="width: 15%;">Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    foreach ($combinedData as $row) {
        echo "<tr data-status='" . $row['status'] . "'>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>
                <a href='profile.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>View</a>
                <button class='btn btn-warning btn-sm'>Report</button>
              </td>";
        echo "</tr>";
    }
    ?>
</tbody>
    </table>
</div>

        </tbody>
    </table>
</div>

<!-- Pagination -->
<nav>
    <ul class="pagination justify-content-center" id="pagination">
        <!-- Pagination items will be dynamically created -->
    </ul>
</nav>

    <!-- Your existing HTML code for the search, filter, and table remains unchanged -->

<!-- Add the script for print functionality -->
<!-- Your existing HTML and PHP code for the table remains unchanged -->

<!-- Add the script for print functionality -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
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



  
    <!-- Linking custom script -->
    <script src="js/dashbooard.js"></script>

    
  </body>
</html>