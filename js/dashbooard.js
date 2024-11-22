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


//chartjs
// Fetch the data based on selected year and month
function fetchAttendanceData(year, month) {
  return fetch(`../api/attendance.php?year=${year}&month=${month}`)
      .then(response => response.json())
      .then(data => {
          // Process and update the chart data
          updateChart(data);
      });
}

// Update the chart with new data
function updateChart(data) {
  const weeks = data.map(item => item.week);
  const attendance = data.map(item => item.attendance);
  
  // Update the chart labels and data
  myChart.data.labels = weeks;
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
          'rgba(255, 26, 104, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)'
      ],
      borderColor: [
          'rgba(255, 26, 104, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)'
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

// Initially load data for default year and month
fetchAttendanceData('2024', 'nov');

