<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            width: 100%;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .announcement-box {
            width: 90%;
            max-width: 600px;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 0 auto;
        }
        .announcement-box h2 {
            color: #275360;
            margin-bottom: 1.5rem;
        }
        .announcement-box img {
            width: 150px; /* Set the desired size of the icon */
            height: 100px;
        }
        .announcement-box ul {
            padding: 0;
            list-style: none;
            text-align: left;
        }
        .announcement-box ul li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .announcement-box ul li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <header>
        <?php include('nav.php'); ?>
    </header>
    <main>
        <div class="announcement-box">
        <img src="images/a-icon.png" alt="announcement-Icon">
            <h2>Announcement!</h2>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
