<?php include 'api/login.php'; ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CJCRSG</title>
    <!-- Linking Google fonts for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
  </head>

  <style>
/* Custom styles for prev and next icons */
.carousel-control-prev-icon,
.carousel-control-next-icon {
  background-color: #555; /* Grey-black color */
  border-radius: 50%; /* Optional: Makes the icons circular */
  width: 30px;
  height: 30px;
}

.carousel-control-prev-icon:hover,
.carousel-control-next-icon:hover {
  background-color: #333; /* Darker shade on hover */
}


/* Media Queries for Responsiveness */
@media (max-width: 768px) {
  .welcome h1 {
    font-size: 1.5rem;
  }

  #image-gallery {
    font-size: 0.9rem;
  }

  .mision-vision h1 {
    font-size: 1.4rem;
  }

  .mision-vision h3 {
    font-size: 0.9rem;
  }
}

@media (max-width: 480px) {
  .welcome h1 {
    font-size: 1.3rem;
  }

  #image-gallery {
    font-size: 0.8rem;
  }

  .mision-vision h1 {
    font-size: 1.2rem;
  }

  .mision-vision h3 {
    font-size: 0.8rem;
  }
}
</style>
  <body>








    <header>
      <nav class="navbar">
          <span class="hamburger-btn material-symbols-rounded">menu</span>
          <a href="#" class="logo">
              <img src="images/logo.png" alt="logo">
              <h2>CJCRSG</h2>
          </a>
          <ul class="links">
              <span class="close-btn material-symbols-rounded">close</span>
              <li><a href="#" class="navl">Home</a></li>
              <li><a href="#image-gallery" class="navl">Gallery</a></li>
              <li><a href="#about" class="navl">About</a></li>
              <li><a href="#contact-us" class="navl">Contact us</a></li>
          </ul>
          <button class="login-btn">LOG IN</button>
      </nav>
  </header>
  <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <div class="form-box login">
            <div class="form-details">
                <h2>Welcome Back</h2>
                <p>Please log in using your personal information to stay connected with us.</p>
            </div>
            <div class="form-content">
                <h2>LOG IN</h2>
                <!-- Login Form -->
                <form action="api/login.php" method="POST">
    <div class="input-field">
        <input type="text" name="email" required>
        <label>Email</label>
    </div>
    <div class="input-field">
        <input type="password" name="password" required>
        <label>Password</label>
    </div>
    <a href="forgot-password.php" class="forgot-pass-link">Forgot password?</a>
    <button type="submit">Log In</button>
                </form>
                <div class="bottom-link">
                    Don't have an account?
                    <a href="#" id="signup-link">Sign up</a>
                </div>
            </div>
        </div>
        <div class="form-box signup">
            <div class="form-details">
                <h2>Create Account</h2>
                <p>To become a part of our community, please sign up using your personal information.</p>
            </div>
            <div class="form-content">
                <h2>SIGN UP</h2>
                <form action="api/signup.php" method="POST"> <!-- Keep this action pointing to signup.php -->
        <div class="input-field">
            <input type="text" name="fullname" required>
            <label>Enter your full name</label>
        </div>
        <div class="input-field">
            <input type="email" name="email" required>
            <label>Enter your email</label>
        </div>
        <div class="input-field">
            <input type="password" name="password" required>
            <label>Enter your password</label>
        </div>
        <div class="policy-text">
            <input type="checkbox" id="policy" required>
            <label for="policy">
                I agree to the
                <a href="#" class="option">Terms & Conditions</a>
            </label>
        </div>
        <button type="submit">Sign Up</button>

        <div class="bottom-link">
            Already have an account? 
            <a href="#" id="login-link">Login</a>
        </div>
    </form>
            </div>
        </div>
    </div>
    <!-- Chatbot Toggler -->
    <button id="chatbot-toggler">
      <span class="material-symbols-rounded">mode_comment</span>
      <span class="material-symbols-rounded">close</span>
    </button>

    <div class="chatbot-popup">
      <!-- Chatbot Header -->
      <div class="chat-header">
        <div class="header-info">
          <svg class="chatbot-logo" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
            <path
              d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
            />
          </svg>
          <h2 class="logo-text">Solomon</h2>
        </div>
        <button id="close-chatbot" class="material-symbols-rounded">keyboard_arrow_down</button>
      </div>

      <!-- Chatbot Body -->
      <div class="chat-body">
        <div class="message bot-message">
          <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
            <path
              d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
            />
          </svg>
          <!-- prettier-ignore -->
          <div class="message-text"> Hey there  <br /> How can I help you today? </div>
        </div>
      </div>

      <!-- Chatbot Footer -->
      <div class="chat-footer">
        <form action="#" class="chat-form">
          <textarea placeholder="Message..." class="message-input" required></textarea>
          <div class="chat-controls">
            <button type="button" id="emoji-picker" class="material-symbols-outlined">sentiment_satisfied</button>
            <div class="file-upload-wrapper">
              <input type="file" accept="image/*" id="file-input" hidden />
              <img src="#" />
              <button type="button" id="file-upload" class="material-symbols-rounded">attach_file</button>
              <button type="button" id="file-cancel" class="material-symbols-rounded">close</button>
            </div>
            <button type="submit" id="send-message" class="material-symbols-rounded">arrow_upward</button>
          </div>
        </form>
      </div>
    </div>



    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="z-index: 0;">
      <ol class="carousel-indicators" >
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
        <img class="d-block w-100" src="images/1.gif" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="images/2.png" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="images/3.png" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" >
        <span class="carousel-control-next-icon" aria-hidden="true" ></span>
        <span class="sr-only">Next</span>
      </a>
    </div>



    <div class="welcome">
      <br>
<h1>Welcome to Church of Jesus Christ the Risen Son of God Phils. Inc.</h1><br>
<h5 id="image-gallery">Together, we grow in worship, fellowship, and service, sharing the light of Christ and building a community rooted in grace and hope.</h5>
    </div>
    <br>

    <section>
    <div class="lightBox">
      <div class="lightBox_content">
        <i class="fas fa-times close"></i>
        <div class="logo_icons">
          <a>
          <img class="logoImg" src="images/logo.png" alt="">
            <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
            </div>
          </a>
          
        </div>
        <div class="showImg">
          <div class="image">
           <img src="images/img1.jpg" alt=""> 
          </div>
        </div>
      </div>
    </div>
    <div class="image-gallery">
      <header style="position: relative; z-index: 0;" > Church Gallery</header>
      <div class="image-container">
        <div class="image-box">
          <img class="gImg" src="images/img10.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img6.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img8.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img9.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img7.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img11.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img12.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img13.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img14.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>
        <div class="image-box">
          <img class="gImg" src="images/img15.jpg" alt="">
          <div class="logo_icons">
            <a>
              <img class="logoImg" src="images/logo.png" alt="">
              <div class="text_content">
              <span class="name">Church of Jesus Christ the Risen Son of God Phils. Inc. </span>
              <span class="followers">CJCRSG</span>
              </div>
            </a>
          </div>
        </div>

     <br  id="about">
  </section>




  <div class="mision-vision">
    <h1>Mission</h1><br>
    <h3>To share the gospel of the kingdom, to make disciples of Christ and to plant churches in the Philippines and all over the world.</h3>
    <br><br>
    <h1>Vision</h1><br>
    <h3>To bring people to God.</h3>
  </div>

    



    <footer>
      <div class="content">
        <div class="left box">
          <div class="upper">
            <div class="topic">About us</div>
            <p>Introducing our church organization, where our guiding principle is "Gospel First." Inspired by Luke 9:6 (AMP), we prioritize spreading the Gospel and healing the sick in every community we touch. Through passionate preaching and compassionate care, we emulate Christ's ministry, bringing hope and transformation wherever we go.</p>
          </div>
        </div>
        <div class="middle box">
          <div class="topic" id="contact-us">Contact us</div>
          <div class="phone">
            <a href="#"><i class="fas fa-phone-volume"></i>   +637 9089 6767</a>
          </div>
          <div class="email">
            <a href="#"><i class="fas fa-envelope">    </i>  cjcrsg@gmail.com</a>
          </div>
          <br>
          <div class="topic">Follow us</div>
          <div class="media-icons">
            <a href="https://www.facebook.com/cjcrsg"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/cjc.rsg/"><i class="fab fa-instagram"></i></a>
            <a href="https://www.messenger.com/t/268149390030881"><i class="fab fa-facebook-messenger"></i></a>
          </div>
        </div>
        <div class="right box">
          <div class="topic">Location</div>
          <div class="iframe-wrapper">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12999.10312931178!2d121.14604000000001!3d14.106640000000002!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd6599540dff9b%3A0x3f6f45e5791f444!2sCJCRSG!5e1!3m2!1sen!2sph!4v1731659125091!5m2!1sen!2sph" width="400" height="200" style="border: 2px solid black
    ; border-radius: 3px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
        </div>
      </div>
      <div class="bottom">
        <p>Copyright © 2024 <a href="#">CJCRSG</a> All rights reserved</p>
      </div>
    </footer>
    <!-- Linking Emoji Mart script for emoji picker -->
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

    <!-- Linking custom script -->
    <script src="js/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script>
  let body = document.querySelector("body"),
      lightBox = document.querySelector(".lightBox"),
      img = document.querySelectorAll(".gImg"),
      showImg = lightBox.querySelector(".showImg img"),
      close = lightBox .querySelector(".close");
     for (let image of img) {
       image.addEventListener("click", ()=>{
         showImg.src = image.src;
         lightBox.style.display = "block";
         body.style.overflow = "hidden";
         close.onclick = ()=>{
           lightBox.style.display = "none";
           body.style.overflow = "visible";
         };
       });
     }
  </script>
  </body>
</html>