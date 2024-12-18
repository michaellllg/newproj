<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
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
    <style>
        .inputID{
            align-item: center !important;
        }
    </style>
    <header>
        <nav class="navbar">
            <a href="#" class="logo">
                <img src="images/logo.png" alt="logo">
                <h2>CJCRSG</h2>
            </a>
            <button onclick="goBack()" class="login-btn">← Go Back</button>
        </nav>
    </header>


        <!-- Login Form (Hidden by Default) -->
        <div class="login-container" id="attendance-form">
            <h2>Attendance <br>Login</h2>
            <form>
                <label for="memberID">MemberID</label>
                <input type="text" id="memberID" name="memberID" placeholder="Enter your ID" required />
                <button type="submit" id="submit-btn">Login</button>
                <a href="qrcode.php" class="qr-code-link" id="scanQRCode">Scan QR Code</a>
            </form>
        </div>
    </div>


    <script>
       function goBack() {
  const previousPage = document.referrer; // Get the URL of the previous page
  if (previousPage) {
    const reloadURL = previousPage.includes('?') 
      ? `${previousPage}&reload=true` 
      : `${previousPage}?reload=true`;
    window.location.href = reloadURL; // Navigate to the previous page with reload flag
  } else {
    window.history.back(); // Fallback to history navigation
  }
}



        // QR Code Processing
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("attendance-form");

            form.addEventListener("submit", function (e) {
                e.preventDefault(); // Prevent default form submission

                const memberID = document.getElementById("memberID").value.trim();

                if (memberID !== "") {
                    fetch("https://cjcrsg.site/api/insert.php", {

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
                            if (data && data.success) {
                                document.getElementById("memberID").value = ""; // Clear input field
                                window.location.href = "attendanceRecorded.html"; // Redirect
                            } else {
                                alert(data.message || "Error recording attendance");
                            }
                        })
                        .catch((error) => {
                            alert("Error: " + error.message);
                        });
                } else {
                    alert("Member ID can't be blank");
                }
            });
        });
    </script>
</body>
</html>
