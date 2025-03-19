<?php
session_start();
include 'database.php';



if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // إعادة التوجيه إذا لم يكن المستخدم مسجلًا
    exit();
}



// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in first.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_SESSION['user_id'];
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];

    $sql = "INSERT INTO appointments (patient_id, doctor, appointment_date, appointment_time, reason)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $patient_id, $doctor, $date, $time, $reason);

    if ($stmt->execute()) {
        header("Location: patient.php"); // Redirect to patient info page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Appointment Booking</title>
    <link rel="stylesheet" href="newstyle2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

    <style>
        .page-content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            width: 100%; 
            margin: 0 auto; 
        }

        .container {
            background-color: #fffaf1;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            min-height: 300px;
            box-sizing: border-box;
        }

        h1 {
            color: #4da1a9;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select, input, textarea, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #bad8b6;
        }

        button {
            background-color: #4da1a9;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #bad8b6;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo"><img src="logo.png" alt="Clinic Logo"></div>
        <nav>
            <a href="HomePage2.html">Home</a>
            <a href="#contact-us">Contact Us</a>
        </nav>
    </header>

    <div class="page-content">
        <div class="container">
            <h1>Book an Appointment</h1>

           <form id="bookingForm" method="POST" action="appointment.php">
    <!-- Specialty Selection -->
    <label for="specialty">Choose a Specialty:</label>
    <select id="specialty" name="specialty" required>
        <option value="">-- Select Specialty --</option>
        <option value="orthopedist">Orthopedist</option>
        <option value="neurologist">Neurologist</option>
        <option value="cardiologist">Cardiologist</option>
        <option value="pediatrician">Pediatrician</option>
        <option value="women's-health">Women's Health</option>
    </select>

    <!-- Doctor Dropdown will be filled dynamically -->
    <label for="doctor">Choose a Doctor:</label>
    <select id="doctor" name="doctor" required></select>

    <!-- Appointment Details -->
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required>

    <label for="time">Time:</label>
    <input type="time" id="time" name="time" required>

    <label for="reason">Reason for Visit:</label>
    <textarea id="reason" name="reason" rows="3" required></textarea>

    <button type="submit">Book Appointment</button>
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

    <script>
    const specialtySelect = document.getElementById('specialty');
    const doctorSelect = document.getElementById('doctor');

    const doctorsBySpecialty = {
        orthopedist: ['Dr. Hanan Alsaleh'],
        neurologist: ['Dr.Haifa Sultan', 'Dr. Abdullah Omar'],
        cardiologist: ['Dr. Sultan Ahmed', 'Dr.Mohammed Bin Faisal', 'Dr.Ghada Khalid'],
        pediatrician: ['Dr.Salman Abdulaziz', 'Dr.Sultan Ahmed'],
        "women's-health": ['Dr. Noura Abdulrhman', 'Dr.Sarah Abdullah']
    };

    specialtySelect.addEventListener('change', function () {
        const selectedSpecialty = this.value;
        doctorSelect.innerHTML = '';

        if (doctorsBySpecialty[selectedSpecialty]) {
            doctorsBySpecialty[selectedSpecialty].forEach(function (doctor) {
                const option = document.createElement('option');
                option.value = doctor;
                option.textContent = doctor;
                doctorSelect.appendChild(option);
            });
        } else {
            const option = document.createElement('option');
            option.textContent = 'Please select a specialty first';
            doctorSelect.appendChild(option);
        }
    });
</script>

</body>
</html>
