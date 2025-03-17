<?php
ini_set('display_errors', 1);
session_start();
require 'database.php';

// Get the logged-in user's ID and type from session
$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type']; // 'doctor' or 'patient'

// Initialize variables
$patientIDDisplay = $fullName = $patientDOB = $patientEmail = '';

// Query to get all patient details
if ($userType === 'patient') {
    $sql = "SELECT id, firstName, lastName, dob, emailAddress FROM patient WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();

    if ($patient) {
        $patientIDDisplay = $patient['id'];
        $fullName = $patient['firstName'] . ' ' . $patient['lastName'];
        $patientDOB = $patient['dob'];
        $patientEmail = $patient['emailAddress'];
    }
}

// Fetch appointments for the patient
$appointments_sql = "SELECT * FROM appointment WHERE id = ? ORDER BY date,time";
$appointments_stmt = $connection->prepare($appointments_sql);
$appointments_stmt->bind_param("i", $userID);
$appointments_stmt->execute();
$appointments_result = $appointments_stmt->get_result();
$appointments = [];

while ($appointment = $appointments_result->fetch_assoc()) {
    $appointments[] = $appointment;
}

$stmt->close();
$appointments_stmt->close();
$connection->close();
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
        <h2>Welcome, <?php echo htmlspecialchars($fullName); ?>!</h2>
        <a href="logout.php" id="sign-out" style="font-weight: bold;">Sign Out</a>
    </div>

    <!-- Profile Card -->
    <div class="main-container">
        <div class="profile-card">
            <img class="profile-image" src="icon.jpg" alt="Patient Icon">
            <div class="profile-details">
                <p><strong>ID:</strong> <span><?php echo htmlspecialchars($patientIDDisplay); ?></span></p>
                <p><strong>Full Name:</strong> <span><?php echo htmlspecialchars($fullName); ?></span></p>
                <p><strong>DOB:</strong> <span><?php echo htmlspecialchars($patientDOB); ?></span></p>
                <p><strong>Email:</strong> <span><?php echo htmlspecialchars($patientEmail); ?></span></p>
            </div>
        </div>

        <div class="booking-container" onclick="window.location.href='Appointment-booking.php';">
            <h4>Book an Appointment</h4>
            <img src="calender.png" alt="Calendar Icon" class="booking-image">
        </div>
    </div>

    <!-- Upcoming Appointments Section -->
<div class="container">
    <div class="table-section">
        <h2>Upcoming Appointments</h2>

        <?php if (!empty($appointments)): ?>
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
                    <?php foreach ($appointments as $appt): ?>
                        <?php
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
                </tbody>
            </table>
        <?php else: ?>
            <p style="font-size: 18px; color: #555;">No appointments booked yet.</p>
        <?php endif; ?>
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

