<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/qrcode.css">
    
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
    <?php include('attendanceRecorded1.html'); ?>
    </header>


    <div class="container">
        <h1>Scan QR Codes</h1>
        <div class="section">
            <div id="my-qr-reader">
                
            </div>
        </div>
        <div class="inputID"><a href="attendance.php">Input Member ID</a></div>
    
    <script src="js/html5-qr.js">
    </script>
    <script src="js/qrscanner.js"></script>


    <script>
        // JavaScript to navigate back when the button is clicked
        function goBack() {
            window.history.back(); // Navigate to the previous page
        }
    </script>
</body>
</html>
