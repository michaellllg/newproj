<?php

include 'api/connection.php';
// Get the memberID from the URL (e.g., id=16)
$memberID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get the year from the GET request (default to current year if not provided)
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y'); // Default to current year

if ($memberID > 0) {
    // Query the attendance table for the given memberID and year
    $sql = "SELECT date FROM attendance WHERE memberID = $memberID AND YEAR(date) = $year";
    $result = $conn->query($sql);

    // Initialize an array to store attendance dates
    $attendance_dates = [];

    if ($result->num_rows > 0) {
        // Store the attendance dates and times in the array
        while ($row = $result->fetch_assoc()) {
            // Extract the full date and time
            $attendance_dates[] = $row['date'];  // full timestamp (date and time)
        }
    }

    // Convert the PHP array to a JSON object for use in JavaScript
    $attendance_dates_json = json_encode($attendance_dates);
} else {
    $attendance_dates_json = '[]'; // No data if id is not provided or invalid
}

$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribution Graph</title>
    <style>
        /* Grid-related CSS */
        :root {
            --square-size: 15px;
            --square-gap: 5px;
            --week-width: calc(var(--square-size) + var(--square-gap));
        }

        .months { grid-area: months; }
        .days { grid-area: days; }
        .squares { grid-area: squares; }

        /* Center the graph container */
        .graph-container {
            display: flex;
            justify-content: center;  /* Center the graph horizontally */  
            align-items: center;      /* Center the graph vertically */
            height: 100vh;            /* Full viewport height */
            padding: 20px;
            position: relative;       /* Needed to position the dropdown */
            bottom: 300px;
        }

        /* Styling for the graph container */
        .graph {
            display: inline-grid;
            grid-template-areas: "empty months"
                                 "days squares";
            grid-template-columns: auto 1fr;
            grid-gap: 10px;
            background-color: white;   /* White background for the graph */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Shadow effect */
            border-radius: 10px;       /* Rounded corners for the graph container */
            padding: 20px;
            max-width: 100%;           /* Make sure it fits within the viewport */
            overflow: hidden;
            transform: scale(1.2);     /* Scale the graph to 120% (20% bigger) */
            transform-origin: center; /* Ensure scaling happens from the center */
        }
        

        /* Dropdown for selecting years */
        .year-dropdown {
            position: absolute;
            top: 220px;
            right: 80px;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 17px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        

        .months {
            display: grid;
            grid-template-columns: calc(var(--week-width) * 4) /* Jan */
                                   calc(var(--week-width) * 4) /* Feb */
                                   calc(var(--week-width) * 4) /* Mar */
                                   calc(var(--week-width) * 5) /* Apr */
                                   calc(var(--week-width) * 4) /* May */
                                   calc(var(--week-width) * 4) /* Jun */
                                   calc(var(--week-width) * 5) /* Jul */
                                   calc(var(--week-width) * 4) /* Aug */
                                   calc(var(--week-width) * 4) /* Sep */
                                   calc(var(--week-width) * 5) /* Oct */
                                   calc(var(--week-width) * 4) /* Nov */
                                   calc(var(--week-width) * 5) /* Dec */;
        }

        .days,
        .squares {
            display: grid;
            grid-gap: var(--square-gap);
            grid-template-rows: repeat(7, var(--square-size));
        }

        .squares {
            grid-auto-flow: column;
            grid-auto-columns: var(--square-size);
        }

        /* Styling for the squares */
        .squares li {
            background-color: white; /* Default white color */
            border: 1px solid #ddd; /* Optional border for better visibility */
            width: var(--square-size);
            height: var(--square-size);
        }

        .squares li[data-level="1"] {
            background-color: #435186; /* Custom blue color */
        }

        /* General reset for lists */
        .months, .days, .squares {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        /* Align text inside .months and .days properly */
        .months li, .days li {
            text-align: center;
            font-size: 12px;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7; /* Light background for the page */
        }

        .graph {
            padding: 20px;
            border: 1px #e1e4e8 solid;
            margin: 70px;
        }
        /* Style for the H1 heading */
        h1 {
            text-align: center;
            font-size: 32px;
            color: #364687;
            margin-bottom: 20px; /* Adds space between the title and the graph */
            position: relative;
            top:10px;
        }


        
/* Container for Admin Section */
.admin-container {
  text-align: left; /* Align text to the left */
  margin-top: 20px;
  margin-left: 100px; /* Align to the left edge */
  padding-top: 30px;
  padding-right: 300px;
  position: relative;
  top: 50px;

 
}

/* Greeting Label Styling */
.admin-greeting {
  font-size: 30px;
  font-weight: bold;
  color: #303858;
  margin-bottom: 8px;
  display: block; /* Ensure spacing below the label */
}

/* Description Label Styling */
.admin-description {
  font-size: 14px;
  color: #60657b;
  margin-bottom: 16px;
  display: block; /* Ensure proper spacing */
}

/* Button Styling */
.attendance-button {
  font-size: 14px;
  font-weight: bold;
  color: #303858;
  background-color: #a4b6ee;
  border: 1px solid #d6e7f3;
  border-radius: 8px;
  padding: 8px 16px;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

/* Button Hover Effect */
.attendance-button:hover {
  background-color: #b4c6e4;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
}


/* Flex Container for Layout */
.container-wrapper {
  display: flex;
  gap: 4px; /* Space between containery and chartCard */
  justify-content: flex-start; /* Align to the right edge */
  align-items: flex-start; /* Align at the top */
  margin: 30px auto; /* Center the container horizontally */
  padding: 0 15px;
  flex-wrap: wrap; /* Allow wrapping on smaller screens */
  box-sizing: border-box;
}

/* css of the graph by diana binangkal*/
.graphBox {
  position: relative;
  left: 25%;
  top: -150px;
  width: 70%;
  padding:20px;
  display: grid;
  grid-template-columns: 1fr 2fr;
  grid-gap: 30px;
  min-height: 200px;
}

.graphBox .box{
  position: relative;
  background: #BCCCDC;
  padding: 20px;
  width: 100%;
  box-shadow: 0 7px 25px rgba(0, 0, 0, 0, 0.08);
  border-radius: 20px;
}



.modal-dialog-top {
  top: 10%; /* Adjust this value to control how far from the top the modal appears */
  margin: 0 auto; /* Center horizontally */
}


@media (max-width: 1024px) {
  .admin-container {
    margin-left: 5px;
    padding-right: 150px;
  }

  .container-wrapper {
    gap: 10px;
    padding: 0 10px;
  }

}



/* For screens between 991px and 1399px */
@media (min-width: 991px) and (max-width: 1399px) {
  /* Admin container stays aligned to the left */
  .admin-container {
    text-align: left; /* Align text to the left */
    margin-top: 20px;
    margin-left: 10px; /* Ensure the container is on the left side */
    padding-top: 30px;
    padding-right: 10px; /* Adjust padding */
  }

  /* Flex container should align the widget and chart side by side */
  .container-wrapper {
    display: flex;
    gap: 10px; /* Increase gap between the widget and chart */
    justify-content: flex-start; /* Align to the left */
    align-items: flex-start; /* Align at the top */
    margin: 20px auto;
    padding: 0 20px; /* Ensure proper padding on the sides */
    flex-wrap: wrap; /* Allow wrapping if needed */
    box-sizing: border-box;
  }

}
 

  /* Ensure the greeting text and description are properly sized */
  .admin-greeting {
    font-size: 26px; /* Adjust font size */
  }

  .admin-description {
    font-size: 14px; /* Adjust font size */
  }

  /* Adjust button size */
  .attendance-button {
    font-size: 14px;
    padding: 10px 18px; /* Adjust padding for better fit */
  }



@media (max-width: 768px) {
  .container-wrapper {
    flex-direction: column; /* Stack vertically below 768px */
    align-items: center;
  }

  

  .admin-container {
    margin-left: 5px;
    padding-right: 0;
    margin-bottom: 20px;
  }


}




@media (max-width: 346px) {
  /* Very small screens adjustments */
  .container-wrapper {
    flex-direction: column; /* Ensure vertical stacking on very small screens */
  }

 
}


@media (max-width: 320px) {


  .admin-container {
    padding-right: 0; /* Remove extra padding */
  }
}

@media (max-width: 200px) {

  .admin-container {
    font-size: 10px; /* Reduce font size for tiny screens */
  }
}

    </style>
</head>
<body>



<?php include('nav.php'); ?>

<h1>My Attendance</h1>

<!--The Greetings XD -->
<div class="admin-container">
        <label class="admin-greeting">Hi, User <?php echo $memberName; ?>!</label>
  <label class="admin-description">Manage the attendance of CJC Members.</label>
  <a href="attendance.php"><button class="attendance-button">Add Attendance</button></a>
</div>
<!-- Add Chart -->
<div class="graphBox">
    <div class="box">
      <canvas id="myChart"></canvas>
    </div>
    <div class="box">
      <canvas id="myChartt"></canvas>
    </div>
</div>

<div class="graph-container">
    <select class="year-dropdown">
    <option value="2023" <?php echo $year == 2023 ? 'selected' : ''; ?>>2023</option>
    <option value="2024" <?php echo $year == 2024 ? 'selected' : ''; ?>>2024</option>
    <option value="2025" <?php echo $year == 2025 ? 'selected' : ''; ?>>2025</option>


    </select>

    <div class="graph">
        <ul class="months">
            <li>Jan</li>
            <li>Feb</li>
            <li>Mar</li>
            <li>Apr</li>
            <li>May</li>
            <li>Jun</li>
            <li>Jul</li>
            <li>Aug</li>
            <li>Sep</li>
            <li>Oct</li>
            <li>Nov</li>
            <li>Dec</li>
        </ul>
        <ul class="days">
            <li>Mon</li>
            <li>Tue</li>
            <li>Wed</li>
            <li>Thu</li>
            <li>Fri</li>
            <li>Sat</li>
            <li>Sun</li>
        </ul>
        <ul class="squares">
            <!-- JavaScript will populate this -->
        </ul>
    </div>
</div>
 <script src = "https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'polarArea',
    data: {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat','Sun'],
      datasets: [{
        label: '# of Attendance',
        data: [0,1,2,3,4,5],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
 </script>
<script>
// Get the current year
const currentYear = new Date().getFullYear();

// Check if a year is stored in localStorage
let selectedYear = localStorage.getItem('selectedYear');

// If no year is stored, default to the current year
if (!selectedYear) {
    selectedYear = currentYear;
} else {
    // Ensure that the stored year is valid; if not, default to the current year
    if (isNaN(selectedYear) || selectedYear < 2020 || selectedYear > 2025) {
        selectedYear = currentYear;
    }
}

// Set the year dropdown to the stored or default year
document.querySelector('.year-dropdown').value = selectedYear;

// PHP data passed to JavaScript (attendance dates with time)
const attendanceDates = <?php echo json_encode($attendance_dates); ?>;

// Debugging statement to check the data
console.log("Attendance Dates:", attendanceDates);

// Generate squares with two colors
const squares = document.querySelector('.squares');

// Generate a total of 365 squares (for each day of the year)
for (let i = 1; i <= 365; i++) {
    const level = 0; // Default to white (no attendance)
    let attendanceTooltip = ''; // Store the tooltip content

    // Create a date object for the current day (starting from the first day of the selected year)
    const currentDate = new Date(selectedYear + '-01-01'); // Use the selected year
    currentDate.setDate(currentDate.getDate() + i - 1);  // Adjust date to current square

    // Format the date to YYYY-MM-DD for comparison
    const formattedDate = currentDate.toISOString().split('T')[0];

    // Debugging statement to log each date check
    console.log("Checking date:", formattedDate);

    // Check if the current square matches any attendance date
    const matchingAttendance = attendanceDates.filter(date => date.split(' ')[0] === formattedDate);

    if (matchingAttendance.length > 0) {
        // If there's attendance for this date, set the color to blue (level 1)
        const attendance = matchingAttendance[0];  // Get the full timestamp
        const formattedTime = attendance.split(' ')[1];  // Extract the time part (HH:MM:SS)

        // Set the tooltip with both date and time
        attendanceTooltip = `Attendance on ${formattedDate} at ${formattedTime}`;

        // Insert the square with the tooltip
        squares.insertAdjacentHTML('beforeend', `<li data-level="1" title="${attendanceTooltip}"></li>`);
    } else {
        // If no attendance, default to white
        squares.insertAdjacentHTML('beforeend', `<li data-level="${level}"></li>`);
    }
}

// Add event listener to the year dropdown
document.querySelector('.year-dropdown').addEventListener('change', function() {
    // Get the selected year
    const selectedYear = this.value;
    
    // Store the selected year in localStorage
    localStorage.setItem('selectedYear', selectedYear);

    // Reload the page to reflect the new year selection
    location.reload();
});

</script>

</body>
</html>