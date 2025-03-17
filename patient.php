<?php
ini_set('display_errors', 1);
session_start();
require 'database.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in patient's ID
$patientID = $_SESSION['patient_id'];

// Fetch patient details from the database
$sql = "SELECT full_name, dob, email FROM patients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patientID);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    die("Error fetching patient details!");
}

// Assign patient details
$patientName = $patient['full_name'];
$patientDOB = $patient['dob'];
$patientEmail = $patient['email'];

// Fetch appointments for the patient
$sql = "SELECT id, date, time, doctor_name, doctor_photo, status FROM appointments WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patientID);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Home Page</title>
    <link rel="stylesheet" href="newstyle2.css">
</head>
<body>
    <!-- Welcome Section -->
    <div class="welcome">
        <h2>Welcome, <?php echo htmlspecialchars($patientName); ?>!</h2>
        <a href="logout.php" id="sign-out" style="font-weight: bold;">Sign Out</a>
    </div>

    <!-- Profile Card -->
    <div class="main-container">
        <div class="profile-card">
            <img class="profile-image" src="icon.jpg" alt="Patient Icon">
            <div class="profile-details">
                <p><strong>ID:</strong> <span><?php echo htmlspecialchars($patientID); ?></span></p>
                <p><strong>Full Name:</strong> <span><?php echo htmlspecialchars($patientName); ?></span></p>
                <p><strong>DOB:</strong> <span><?php echo htmlspecialchars($patientDOB); ?></span></p>
                <p><strong>Email:</strong> <span><?php echo htmlspecialchars($patientEmail); ?></span></p>
            </div>
        </div>

        <div class="booking-container" onclick="window.location.href='Appointment-booking.php';">
            <h4>Book an Appointment</h4>
            <img src="calender.png" alt="Calendar Icon" class="booking-image">
        </div>
    </div>

    <!-- Upcoming Appointments Table -->
    <div class="container">
        <div class="table-section">
            <h2>Upcoming Appointments</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor's Name</th>
                        <th>Doctor's Photo</th>
                        <th>Status</th>
                        <th>Cancel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($appointments) > 0): ?>
                        <?php foreach ($appointments as $appt): ?>
                            <?php
                            // Formatting date and time for better readability
                            $formattedDate = date("F j, Y", strtotime($appt['date']));
                            $formattedTime = date("g:i A", strtotime($appt['time']));
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($formattedDate); ?></td>
                                <td><?php echo htmlspecialchars($formattedTime); ?></td>
                                <td><?php echo htmlspecialchars($appt['doctor_name']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($appt['doctor_photo']); ?>" alt="Doctor Photo" width="50"></td>
                                <td><?php echo htmlspecialchars($appt['status']); ?></td>
                                <td>
                                    <a href="cancel_appointment.php?id=<?php echo $appt['id']; ?>" class="cancel" onclick="return confirm('Are you sure you want to cancel this appointment?')">Cancel</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No upcoming appointments.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

  
   <script>
   
   function confirmCancellation() {
            return confirm("Are you sure you want to cancel this appointment?");
        }
        
  function showServices() {
    document.getElementById('doctors-slideshow').parentElement.style.display = 'none';
    document.getElementById('services-section').style.display = 'block';
}

function showDoctors() {
    document.getElementById('services-section').style.display = 'none';
    document.getElementById('doctors-slideshow').parentElement.style.display = 'block';
}


   </script>
</body>
</html>
