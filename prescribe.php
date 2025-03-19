<?php
session_start();
require 'database.php';

// التحقق من أن المستخدم طبيب
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid appointment ID.");
}

$appointment_id = intval($_GET['id']);

$query = "SELECT p.id, p.firstName, p.lastName, p.DoB, p.Gender 
          FROM appointment a 
          JOIN patient p ON a.PatientID = p.id 
          WHERE a.id = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
$stmt->close();

if (!$patient) {
    die("Patient not found.");
}

// حساب عمر المريض
$dob = new DateTime($patient['DoB']);
$today = new DateTime();
$age = $dob->diff($today)->y;

$medications_query = "SELECT id, MedicationName FROM medication";
$medications_result = $connection->query($medications_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescribe Medication</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="newstyle2.css">

    <style>
        .form-container1 {
            background-color:#fffaf1; 
            width: 500px;
            height: 625px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            margin-left: 430px;
            animation: fadeIn 1s ease-in-out;
        }

        .form-container1 h3 {
            color: #125250;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .form-container1 h1 {
            color: #125250;
            font-size: 26px;
            text-align: center;
            font-weight: bold;
        }

        .form-group1 {
            margin-bottom: 20px;
        }

        .form-container1 label {
            display: block;
            font-size: 16px;
            color: #333;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .gender-group1 {
            display: flex;
            align-items: center; 
            gap: 300px; 
            margin-left: 10px;
        }

        .gender-group1 label {
            display: flex;
            align-items: center; 
            color:#000000;
        }

        .form-container1 input[type="text"], 
        .form-container1 input[type="number"], 
        .form-container1 select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .form-container1 input[type="radio"],
        .form-container1 input[type="checkbox"] {
            transform: scale(1.2);
            margin-right: 8px;
        }

        .divider1, .long-divider1 {
            width: 95%;
            height: 1px;
            background-color: #ddd;
        }

        .submit-btn1 {
            background-color: #52837e;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            position: absolute;
            margin-left: 340px;
            width: 100px;
            font-family: "Times New Roman", Times, serif;
            margin-top: 10px;
        }

        .submit-btn1:hover {
            background-color: #3b6b66;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="logo.png" alt="Medora Logo">
    </div>
    <nav>
        <a href="HomePage2.html">Home</a>
        <a href="#contact">Contact</a>
    </nav>
</header>

<br><br>
<div class="form-container1">
    <form action="prescription.php" method="POST">
        <h1>Patient's Medications</h1>
        <br>

        <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
        <input type="hidden" name="patient_id" value="<?php echo $patient['id']; ?>">

        <div class="form-group1">
            <label for="patientName">Patient's Name:</label>
            <input type="text" id="patientName1" value="<?php echo htmlspecialchars($patient['firstName'] . ' ' . $patient['lastName']); ?>" readonly>
        </div>

        <div class="form-group1">
            <label for="age">Age:</label>
            <input type="number" id="age1" value="<?php echo $age; ?>" readonly>
        </div>

        <div class="form-group1">
            <label>Gender:</label>
            <div class="gender-group1">
                <label><input type="radio" name="gender" value="male" <?php echo (strtolower($patient['Gender']) == 'male') ? 'checked' : ''; ?> disabled> Male</label>
<label><input type="radio" name="gender" value="female" <?php echo (strtolower($patient['Gender']) == 'female') ? 'checked' : ''; ?> disabled> Female</label>

            </div>
        </div>

        <div class="divider1"></div><br>

        <h3>Medications</h3>
        <div class="form-group1">
            <?php while ($medication = $medications_result->fetch_assoc()): ?>
                <label><input type="checkbox" name="medications[]" value="<?php echo $medication['id']; ?>"> <?php echo htmlspecialchars($medication['MedicationName']); ?></label><br>
            <?php endwhile; ?>
        </div>

        <div class="long-divider1"></div>

        <button type="submit" class="submit-btn1">Submit</button>

    </form>
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
</footer>

</body>
</html>
