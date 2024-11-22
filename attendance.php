<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/attendance.css">
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!-- Include QRious library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar">
           
            <a href="#" class="logo">
                <img src="images/logo.png" alt="logo">
                <h2>CJCRSG</h2>
            </a>
           
            <button onclick="goBack()" class="login-btn">← Go Back</button>
        </nav>
    </header>

    <div class="wrapper">
      <div class="login-container" id="attendance-form">
        <h2>Attendance <br>Login</h2>
        <form id="attendance-form">
          <label for="memberID">MemberID</label>
          <input type="text" id="memberID" name="memberID" placeholder="Enter your ID" required />
          <button type="submit" id="submit-btn">Login</button>
          <a href="#" class="qr-code-link" id="scanQRCode">Scan QR Code</a>
        </form>
      </div>

      <!-- QR Code Scanner Section -->
      <div class="container" id="qrScanner" style="display: none;">
        <h1>Scan QR Codes</h1>
        <div class="section">
          <div id="my-qr-reader"></div>
        </div>
        <div class="inputID"><a href="#" id="inputMemberID">Input Member ID</a></div>
      </div>
    </div>

<script src="js/html5-qr.js"></script>
<script src="js/qrscanner.js"></script>

    <script>
  // JavaScript to navigate back when the button is clicked
  function goBack() {
    window.history.back(); // Navigate to the previous page
  }

  // Handle QR Code scan toggle
  document.getElementById("scanQRCode").addEventListener("click", function(e) {
    e.preventDefault(); // Prevent default link behavior

    // Hide login form and show QR scanner
    document.getElementById("attendance-form").style.display = "none"; // Hide login form
    document.getElementById("qrScanner").style.display = "block"; // Show QR scanner
  });

  // Handle "Input Member ID" link
  document.getElementById("inputMemberID").addEventListener("click", function(e) {
    e.preventDefault(); // Prevent default link behavior

    // Show login form and hide QR scanner
    document.getElementById("attendance-form").style.display = "block"; // Show login form
    document.getElementById("qrScanner").style.display = "none"; // Hide QR scanner
  });
</script>



<script>
      document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("attendance-form");
        const errorTxt = document.querySelector(".error-txt");

        form.addEventListener("submit", function (e) {
          e.preventDefault(); // Prevent default form submission

          const memberID = document.getElementById("memberID").value.trim();

          if (memberID !== "") {
            fetch("http://localhost/newproj/api/insert.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({ memberID: memberID }),
            })
              .then((response) => {
                if (!response.ok) {
                  throw new Error("Network response was not ok");
                }
                return response.json();
              })
              .then((data) => {
                // Check if response is not empty
                if (data) {
                  // Check if attendance recorded successfully
                  if (data.success) {
                    window.location.href = "attendanceRecorded.html";
                  } else {
                    // Handle other responses
                    alert(data.message || "Error recording attendance");
                  }
                } else {
                  throw new Error("Empty response received");
                }
              })
              .catch((error) => {
                // Handle fetch error
                alert("Error: " + error.message);
              });
          } else {
            // Display error if memberID is empty
            errorTxt.textContent = "Member ID can't be blank";
          }
        });
      });
    </script>
</body>
</html>
