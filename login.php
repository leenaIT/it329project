<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log in Page</title>
    <link rel="stylesheet" href="newstyle2.css">
</head>
<body>
    <header>
      <div class="logo"><img src="logo.png" alt="Clinic Logo"></div>
      <nav>
        <a href="HomePage2.html">Home</a>
        <a href="#contact-us">Contact Us</a>
      </nav>
  </header>
  <?php
  // تعديل هذه المتغيرات حسب الإعدادات لديك
  $Shost = "localhost";
  $Sdatabase = "medora";
  $Suser = "root";
  $Spass = "root";
  
  // إنشاء اتصال بقاعدة البيانات
  $Sconnection = mysqli_connect($Shost, $Suser, $Spass, $Sdatabase,8889);
  
  if (!$Sconnection) {
      die("Connection failed: " . mysqli_connect_error());
  }
  
  session_start();
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST['emailAddress'];
      $password = $_POST['password'];
      $role = $_POST['role']; // 'doctor' أو 'patient'
  
      // التحقق من أن المستخدم أدخل نوع الحساب
      if (!$role) {
          header("Location: login.html?error=Please select a role");
          exit();
      }
  
      // البحث عن المستخدم في قاعدة البيانات
      $query = "SELECT id, password FROM $role WHERE emailAddress = ?";
      $stmt = mysqli_prepare($Sconnection, $query);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
  
      if (mysqli_stmt_num_rows($stmt) > 0) {
          mysqli_stmt_bind_result($stmt, $user_id, $hashed_password);
          mysqli_stmt_fetch($stmt);
  
          // التحقق من كلمة المرور
          if (password_verify($password, $hashed_password)) {
              $_SESSION['user_id'] = $user_id;
              $_SESSION['user_type'] = $role;
  
              // توجيه المستخدم حسب نوعه
              if ($role === "doctor") {
                  header("Location: doctor_homepage.php");
              } else {
                  header("Location: patient_homepage.php");
              }
              exit();
          } else {
              header("Location: login.html?error=Incorrect password");
              exit();
          }
      } else {
          header("Location: login.html?error=User not found");
          exit();
      }
  
      mysqli_stmt_close($stmt);
  }
  
  // إغلاق الاتصال
  mysqli_close($Sconnection);
  ?>
  
     <div class="background">
        <div class="login-container">
          <h2>Login</h2>
          <p>Welcome back you have been missed!!</p>
          <form id="login-form">
              <input type="email" id="email" placeholder="Email Address" required>
              <input type="password" id="password" placeholder="Password" required>
              
              <div class="role-selection">
                  <label for="patient">Patient</label>
                  <input type="radio" id="patient" name="role" value="patient">
                  
                  <label for="doctor">Doctor</label>
                  <input type="radio" id="doctor" name="role" value="doctor">
              </div>
  
              <button type="submit">Log In</button>
          </form>
      </div>

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
      
      <div class="footer-right-1">
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