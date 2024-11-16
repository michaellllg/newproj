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

// setup 
const data = {
    labels: ['Week1', 'Week2', 'Week3', 'Week4',],
    datasets: [{
      label: 'Weekly Sales',
      data: [18, 12, 6, 9,],
      data: [
    {id: 'Week1', financials: {
        2020: { cost: 21, sales: 40, profit: 120 },
        2021: { cost: 33, sales: 80, profit: 140 },
        2022: { cost: 20, sales: 30, profit: 160 },
        2023: { cost: 19, sales: 20, profit: 170 },
       } 
    },
    {id: 'Week2', financials: {
        2020: { cost: 44, sales: 40, profit: 120 },
        2021: { cost: 33, sales: 80, profit: 140 },
        2022: { cost: 20, sales: 30, profit: 160 },
        2023: { cost: 19, sales: 34, profit: 370 },
       } 
    },
    {id: 'Week3', financials: {
        2020: { cost: 103, sales: 40, profit: 120 },
        2021: { cost: 33, sales: 80, profit: 140 },
        2022: { cost: 20, sales: 30, profit: 160 },
        2023: { cost: 19, sales: 20, profit: 370 },
       } 
    },
    {id: 'Week4', financials: {
        2020: { cost: 10, sales: 40, profit: 120 },
        2021: { cost: 33, sales: 820, profit: 240 },
        2022: { cost: 20, sales: 30, profit: 360 },
        2023: { cost: 19, sales: 20, profit: 370 },
       } 
    },
    
      ],
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

  // config 
  const config = {
    type: 'bar',
    data,
    options: {
      parsing:{
        xAxisKey: 'id',
        yAxisKey: 'financials.2020.cost'
      },  
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  };

  // render init block
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

  // Instantly assign Chart.js version
  const chartVersion = document.getElementById('chartVersion');
  chartVersion.innerText = Chart.version;



