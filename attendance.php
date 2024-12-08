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
        <!-- QR Code Scanner Section -->
        <div class="container" id="qrScanner">
            <h1>Scan QR Codes</h1>
            <div class="section">
                <div id="my-qr-reader"></div>
            </div>
            <div class="inputID">
                <a href="#" id="inputMemberID">Input Member ID</a>
            </div>
        </div>

        <!-- Login Form (Hidden by Default) -->
        <div class="login-container" id="attendance-form" style="display: none;">
            <h2>Attendance <br>Login</h2>
            <form>
                <label for="memberID">MemberID</label>
                <input type="text" id="memberID" name="memberID" placeholder="Enter your ID" required />
                <button type="submit" id="submit-btn">Login</button>
                <a href="#" class="qr-code-link" id="scanQRCode">Scan QR Code</a>
            </form>
        </div>
    </div>

    <script src="js/html5-qr.js"></script>
    <script src="js/qrscanner.js"></script>

    <script>
        // JavaScript to navigate back when the button is clicked
        function goBack() {
            window.history.back(); // Navigate to the previous page
        }

        // Handle "Input Member ID" link
        document.getElementById("inputMemberID").addEventListener("click", function(e) {
            e.preventDefault(); // Prevent default link behavior

            // Show login form and hide QR scanner
            document.getElementById("attendance-form").style.display = "block"; // Show login form
            document.getElementById("qrScanner").style.display = "none"; // Hide QR scanner
        });

        // Handle "Scan QR Code" link
        document.getElementById("scanQRCode").addEventListener("click", function(e) {
            e.preventDefault(); // Prevent default link behavior

            // Show QR scanner and hide login form
            document.getElementById("attendance-form").style.display = "none"; // Hide login form
            document.getElementById("qrScanner").style.display = "block"; // Show QR scanner
        });

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
