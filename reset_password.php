<?php
include 'api/connection.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        try {
            // Update the password in the database
            $stmt = $conn->prepare("UPDATE accountinfo SET password = ?, otp_code = NULL, otp_expiry = NULL WHERE email = ?");
            $stmt->bind_param("ss", $new_password, $email);
            $stmt->execute();

            // Success message and redirection
            echo "<script>
                alert('Password successfully changed!');
                window.location.href = 'index.php';
            </script>";
            exit();
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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

        form {
            margin-top: 1.2rem;
        }

        input[type="password"] {
            font-size: 1rem;
            padding: 0.6rem 0.8rem;
            width: 100%;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border 0.2s ease;
        }

        input[type="password"]:focus {
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

        #password-message {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            color: #e74c3c;
        }
    </style>
    <script>
function validatePassword() {
    const newPassword = document.querySelector('input[name="new_password"]').value;
    const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
    const passwordMessage = document.getElementById('password-message');

    // Corrected Regex
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=]).{8,}$/;

    if (!regex.test(newPassword)) {
        passwordMessage.innerText = "Password must be at least 8 characters long, include 1 uppercase, 1 lowercase, 1 number, and 1 special character.";
        return false;
    }

    if (newPassword !== confirmPassword) {
        passwordMessage.innerText = "Passwords do not match.";
        return false;
    }

    passwordMessage.innerText = "";
    return true;
}
</script>

</head>
<body>
    <div class="container">
        <h1>Reset Your Password</h1>
        <p>Enter your new password to reset your account access</p>
        <div id="password-message"></div>
        <form action="" method="POST" onsubmit="return validatePassword()">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
            <input type="password" name="new_password" required placeholder="Enter new password">
            <input type="password" name="confirm_password" required placeholder="Confirm new password">
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
