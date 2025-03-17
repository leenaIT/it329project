<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="newstyle2.css">
</head>
<body>
<?php
// الاتصال بقاعدة البيانات
$Shost = "localhost";
$Sdatabase = "medora";
$Suser = "root";
$Spass = "root";

$Sconnection = mysqli_connect($Shost, $Suser, $Spass, $Sdatabase,8889);

if (!$Sconnection) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['emailAddress'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // التحقق مما إذا كان البريد الإلكتروني مستخدمًا بالفعل
    $checkEmailQuery = "SELECT id FROM $role WHERE emailAddress = ?";
    $stmt = mysqli_prepare($Sconnection, $checkEmailQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        header("Location: signup.html?error=Email already exists");
        exit();
    }
    mysqli_stmt_close($stmt);

    if ($role === "patient") {
        $gender = $_POST['Gender'];
        $dob = $_POST['DoB'];

        $query = "INSERT INTO patient (firstName, lastName, Gender, DoB, emailAddress, password) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($Sconnection, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $gender, $dob, $email, $password);
    } elseif ($role === "doctor") {
        $specialityID = $_POST['SpecialityID'];
        $uniqueFileName = uniqid() . "_" . basename($_FILES["photo"]["name"]);
        $targetDir = "uploads/";
        $targetFilePath = $targetDir . $uniqueFileName;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath);

        $query = "INSERT INTO doctor (firstName, lastName, photo, SpecialityID, emailAddress, password) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($Sconnection, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $uniqueFileName, $specialityID, $email, $password);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['user_id'] = mysqli_insert_id($Sconnection);
        $_SESSION['user_type'] = $role;

        if ($role === "doctor") {
            /* leena write your php page*/
            header("Location: doctor.php");
        } else {
            header("Location: patient.php");
        }
        exit();
    } else {
        echo "Error: " . mysqli_error($Sconnection);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($Sconnection);
?>


    <!-- Header Section -->
    <header>
      <div class="logo"><img src="logo.png" alt="Clinic Logo"></div>
      <nav>
        <a href="HomePage2.html">Home</a>
        <a href="#contact-us">Contact Us</a>
      </nav>
  </header>
     <!-- Main Content Section with Background -->
     <div class="background">
      <div class="box">
          <div class="content">
            <div class="role-selection">
                <h3>Select your role:</h3>
                <input type="radio" id="patient" name="role" value="patient" onclick="showForm()">
                <label for="patient">Patient</label>
        
                <input type="radio" id="doctor" name="role" value="doctor" onclick="showForm()">
                <label for="doctor">Doctor</label>
            </div>
              
              <div class="form-container">
                  <!-- Patient Form -->
<div id="patientForm" class="hidden">
    <form action="signup.php" method="POST">
        <input type="hidden" name="role" value="patient">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="text" name="ID" placeholder="ID" required>
        <select name="Gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <input type="date" name="DoB" placeholder="Date of Birth" required>
        <input type="email" name="emailAddress" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
</div>

<!-- Doctor Form -->
<div id="doctorForm" class="hidden">
    <form action="signup.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="role" value="doctor">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="text" name="ID" placeholder="ID" required>
        <input type="file" name="photo" required>
        <select name="SpecialityID" required>
            <option value="">Select Speciality</option>
            <option value="Neurological_Specialist">Neurological Specialist</option>
            <option value="Sports_Rehabilitation_Specialist">Sports Rehabilitation Specialist</option>
            <option value="Pediatric_Physical_Therapist">Pediatric Physical Therapist</option>
            <option value="Geriatric_Specialist">Geriatric Specialist</option>
        </select>
        <input type="email" name="emailAddress" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
</div>

              </div>
          </div>
      </div>
    </div>

    <!-- Footer Section -->
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

  <script>
function showForm() {
  const selectedRole = document.querySelector('input[name="role"]:checked').value;

  document.getElementById('patientForm').classList.add('hidden');
  document.getElementById('doctorForm').classList.add('hidden');
  
  if (selectedRole === 'patient') {
      document.getElementById('patientForm').classList.remove('hidden');
  } else if (selectedRole === 'doctor') {
      document.getElementById('doctorForm').classList.remove('hidden');
  }
}


</script>

</body>
</html>