<?php
include 'api/connection.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);

    try {
        // Retrieve OTP and expiry for the email
        $stmt = $conn->prepare("SELECT otp_code, otp_expiry FROM accountinfo WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_otp = $row['otp_code'];
            $expiry = $row['otp_expiry'];

            // Check if OTP matches and is not expired
            if ($otp === $stored_otp && strtotime($expiry) >= time()) {
                // OTP is valid
                header("Location: reset_password.php?email=$email");
                exit();
            } else {
                echo "<script>alert('Invalid or expired OTP!');</script>";
            }
        } else {
            echo "<script>alert('Email not found!');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(to right, #e9eff1, #ffffff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .container {
            background: white;
            padding: 2rem 3rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            transition: all 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 1.8rem;
            color: #2E3E81;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #555;
        }

        form {
            margin-top: 1.2rem;
        }

        label {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            display: block;
            text-align: left;
        }

        input[type="text"] {
            font-size: 1rem;
            padding: 0.6rem 0.8rem;
            width: 100%;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border 0.2s ease;
        }

        input[type="text"]:focus {
            border: 1px solid #2E3E81;
        }

        button {
            font-size: 1rem;
            color: #fff;
            background: #2E3E81;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            width: 100%;
        }

        button:hover {
            background: #1E2C5A;
        }

        .message {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #e74c3c;
        }

        /* Responsive Styling */
        @media (max-width: 480px) {
            h1 {
                font-size: 1.5rem;
            }

            button {
                font-size: 0.9rem;
            }
        }
    </style>
    <script>
        // Allow only numbers and limit the input length to 6
        function validateOtpInput(input) {
            // Restrict input to numbers only and limit it to 6 digits
            input.value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            if (input.value.length > 6) {
                input.value = input.value.slice(0, 6); // Restrict length to 6
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Verify OTP</h1>
        <p>Enter the OTP sent to your email to proceed</p>
        <form action="" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
            <input type="text" name="otp" required oninput="validateOtpInput(this)" placeholder="Enter OTP">
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
