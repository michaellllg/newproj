const navbarMenu = document.querySelector(".navbar .links");
const hamburgerBtn = document.querySelector(".hamburger-btn");
const hideMenuBtn = navbarMenu.querySelector(".close-btn");
const showPopupBtn = document.querySelector(".login-btn");
const formPopup = document.querySelector(".form-popup");
const hidePopupBtn = formPopup.querySelector(".close-btn");
const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");
// Show mobile menu
hamburgerBtn.addEventListener("click", () => {
    navbarMenu.classList.toggle("show-menu");
});
// Hide mobile menu
hideMenuBtn.addEventListener("click", () =>  hamburgerBtn.click());


// Set the current month and year as default selections
window.onload = () => {
  const yearSelect = document.getElementById('year');
  const monthSelect = document.getElementById('Month');

  const currentDate = new Date();
  const currentYear = currentDate.getFullYear();
  const currentMonth = currentDate.getMonth() + 1; // Months are 0-indexed in JavaScript

  // Set the default values
  yearSelect.value = currentYear;
  monthSelect.value = currentMonth;

  // Fetch the data for the current month and year
  fetchAttendanceData(currentYear, currentMonth);
};

// Fetch the data based on selected year and month
function fetchAttendanceData(year, month) {
  return fetch(`api/chart.php?year=${year}&month=${month}`)
      .then(response => response.json())
      .then(data => {
          // Process and update the chart data
          updateChart(data);
      });
}

function updateChart(data) {
  // Use the weeks as they are (no subtraction)
  const weeks = data.map(item => item.week);  // No change, keep the original week numbers
  const attendance = data.map(item => item.attendance);

  // Update the chart labels and data
  myChart.data.labels = weeks.map(week => `Week ${week}`);  // Display 'Week 1', 'Week 2', etc.
  myChart.data.datasets[0].data = attendance;
  myChart.update();
}

// Handle the change events for Year and Month selection
function changeMonitoring() {
  const selectedYear = document.getElementById('year').value;
  const selectedMonth = document.getElementById('Month').value;
  
  // Fetch new data based on selected year and month
  fetchAttendanceData(selectedYear, selectedMonth);
}

// Initialize the chart
const data = {
  labels: ['Week1', 'Week2', 'Week3', 'Week4'],
  datasets: [{
      label: 'Weekly Attendance',
      data: [0, 0, 0, 0],  // Default data
      backgroundColor: [
        '#364687', // Week 1: Solid #364687
        '#6D7EC5', // Week 2: Solid #6D7EC5
        '#364687', // Week 3: Solid #364687
        '#6D7EC5'  // Week 4: Solid #6D7EC5
    ],
    borderWidth: 1
  }]
};

// Chart config
const config = {
  type: 'bar',
  data,
  options: {
      scales: {
          y: {
              beginAtZero: true
          }
      }
  }
};

// Render the chart
const myChart = new Chart(
  document.getElementById('myChart'),
  config
);
