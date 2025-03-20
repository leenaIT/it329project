<?php

  $host = "localhost";
    $database = "medora";
    $user = "root";
    $pass = "";
    $port = "8889";
    
    // إنشاء اتصال بقاعدة البيانات
    $connection = mysqli_connect($host, $user, $pass, $database);
   
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    session_start();


// إذا كان المستخدم مسجّل الدخول، أرسله إلى صفحته المناسبة
if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'doctor') {
        header("Location: doctor_homepage.php");
        exit();
    } elseif ($_SESSION['user_type'] === 'patient') {
        header("Location: patient.php");
        exit();
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medora</title>
    <link rel="stylesheet" href="newstyle2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,600&display=swap">
   
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Medora Logo">
        </div>
        <nav>
            <a href="#about-us">About Us</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>

   <!-- Hero Section -->
   <section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Medora <span>Services</span> That You Can <span>Trust</span></h1>
        <p>Join Medora for expert physiotherapy and 
            wellness support tailored to your unique needs</p>
        <button onclick="window.location.href='signup.php'">Sign up</button>
        <p class="signup-text">Already have account? <a href="login.php" id="log-in">log in</a></p>

    </div>
</section>
    

<div class="services">
    <h2> Our Services</h2>

<div class="services-carousel-container">
    <button class="carousel-arrow left-arrow" id="leftArrow" disabled><img src="Left‏‏Arrow.png" alt="left Arrow"></button>

    <div class="services-carousel" id="carousel">

      <div class="service">
        <img src="service1.png" alt="Service1" />
        <h3>Orthopedic Services</h3>
        <p>Treatments for musculoskeletal issues,<br> including fractures, joint replacements, and<br> sports injuries</p>
      </div>

      <div class="service">
        <img src="service2.png" alt="Service2" />
        <h3>Neurological Care</h3>
        <p>Diagnosis and treatment of neurological<br>disorders, such as stroke, epilepsy, and<br>migraines</p>
      </div>

      <div class="service">
        <img src="service5.png" alt="Service3" />
        <h3>Women's Health Services</h3>
        <p>Comprehensive care for women's health<br>issues, including pelvic health, prenatal<br>care, and menopause management</p>
      </div>

      <div class="service">
        <img src="service3.png" alt="service4" />
        <h3>Cardiological Services</h3>
        <p>Heart-related care, including managing <br>hypertension, heart disease, and performing <br>heart screenings </p>
      </div>

      <div class="service">
        <img src="service4.png" alt="service5" />
        <h3>Pediatric Services</h3>
        <p>General and specialized healthcare for children,<br> such as immunizations, developmental screenings,<br> and childhood illnesses</p>
      </div>

    </div>

    <button class="carousel-arrow right-arrow" id="rightArrow"><img src="arrow.png" alt="right Arrow"></button>
  </div>
  </div>


    <h2 id="cli">Patient Testimonials</h2>
    <div class="reviews">
    

        <div class="carousel-item left">
            <img src="cli1.jpg" alt="Client">
            <h3>Sophia Harper</h3>
            <pre>
    "I can't thank the team at Medora enough for their 
    exceptional care and professionalism. From the moment I 
    walked in, I felt welcomed and confident that I was in good 
    hands. Their expertise helped me recover faster than I expected!"</pre>
    <br>
    <p class="stars">★★★★★</p>
          </div>
          <div class="carousel-item active">
            <img src="cli2.jpg" alt="Client">
            <h3>James Bennett</h3>
            <pre>
    "After months of struggling with pain and limited mobility,
    the therapists at Medora transformed my life. Their personalized 
    approach and genuine care made all the difference. I’m finally 
    able to move freely again!"</pre>
    <br>
    <p class="stars">★★★★☆</p>
          </div>
          <div class="carousel-item right">
            <img src="cli3.jpg" alt="Client">
            <h3>Emma Collins</h3>
            <pre>
    "What truly sets Medora apart is their attention to detail 
    and focus on individualized care. Every session was tailored to 
    my needs, and the progress I’ve made is incredible. I highly 
    recommend their services!"</pre>
    <br>
    <p class="stars">★★★★★</p>
          </div>
          <div class="carousel-item">
            <img src="cli4.jpg" alt="Client">
            <h3>Noah Foster</h3>
            <pre>
    "The team at Medora took the time to understand my concerns 
    and goals, and they created a treatment plan that fit perfectly 
    into my lifestyle. Their patience and support were invaluable 
    throughout my recovery journey."</pre>
    <br>
    <p class="stars">★★★★★</p>
          </div>
          <div class="carousel-item">
            <img src="cli5.jpg" alt="Client">
            <h3>Ava Morgan</h3>
            <pre>
    "The advanced techniques and technology used at Medora are 
    top-notch. I felt like I was receiving cutting-edge care from 
    start to finish."</pre>
    <br>
    <p class="stars">★★★★☆</p>
          </div>
          
    </div>
   
    <div id="about-us" class="about-us">
        <h2>About Us</h2>
        <p>
            At Medora, we believe that every recovery journey starts with personalized care. 
            Our dedicated team is committed to providing the best support for your physical therapy needs.
        </p>
        <blockquote>
            “Physical therapy is not just about healing the body; it’s about restoring hope, resilience, 
            and the freedom to move again.”
        </blockquote>
        <p>
            We use advanced techniques and technologies to help you recover, manage conditions, 
            and improve your overall well-being.
        </p>
        <br>
    </div>

    <footer>
      <div class="footer-left-1">
          <h4>Get In Touch</h4>
          <div class="contact-info-1" id="contact-us">
              <div class="contact-item-1">
                  <img src="phone1.png" alt="Phone Icon">
                  <span class="single-line-1">+996 58765 43210</span>
              </div>
              <div class="contact-item-1">
                  <img src="mail-icon.png" alt="Email Icon">
                  <span class="single-line-1">medora@gmail.com</span>
              </div>
              <div class="contact-item-1">
                  <img src="location1.png" alt="Location Icon">
                  <span class="single-line-1">Riyadh, Saudi Arabia</span>
              </div>
          </div>
      </div>
      
      <div class="footer-center-1">
          <a href="index.html">
          <img src="logo.png" alt="Logo" class="footer-logo-1 logo-toggle">
      </a>
      </div>
      
      <div class="footer-right-1" id="contact">
          <p><strong>Social media</strong></p>
          <div class="social-icons-1">
              
              <img src="facebook1.png" alt="Facebook">
              <img src="X1.png" alt="Twitter">
              <img src="instagram1.png" alt="Instagram">
              <img src="linkedin1.png" alt="LinkedIn">
          </div>
      </div>
      
      <div class="footer-bottom-1">
          <p>© 2024 Website. All rights reserved.</p>
      </div>
  </footer>
  <script src="medora.js"></script>

</body>
</html>




