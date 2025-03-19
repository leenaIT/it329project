<?php
session_start();




if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // إعادة التوجيه إذا لم يكن المستخدم مسجلًا
    exit();
}


// التأكد من تسجيل دخول الطبيب
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];

// الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$password = "root";
$database = "medora";

$connection = new mysqli($host, $user, $password, $database,8889);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// استرجاع بيانات الطبيب
$doctorQuery = "SELECT firstName, lastName, emailAddress, speciality FROM doctor d
                JOIN speciality s ON d.SpecialityID = s.id WHERE d.id = ?";
$stmt = $connection->prepare($doctorQuery);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();
$stmt->close();

// استرجاع المواعيد القادمة
$appointmentsQuery = "SELECT a.id, a.date, a.time, p.firstName, p.lastName, p.DoB, p.Gender, a.reason, a.status
                      FROM appointment a
                      JOIN patient p ON a.PatientID = p.id
                      WHERE a.DoctorID = ? AND (a.status = 'Pending' OR a.status = 'Confirmed')
                      ORDER BY STR_TO_DATE(a.date, '%d/%m/%Y'), a.time";
$stmt = $connection->prepare($appointmentsQuery);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$appointments = $stmt->get_result();
$stmt->close();

// استرجاع المرضى الذين أكملوا مواعيدهم
$patientsQuery = "SELECT DISTINCT p.firstName, p.lastName, p.DoB, p.Gender, GROUP_CONCAT(m.MedicationName SEPARATOR ', ') as medications
                   FROM appointment a
                   JOIN patient p ON a.PatientID = p.id
                   LEFT JOIN prescription pr ON pr.AppointmentID = a.id
                   LEFT JOIN medication m ON pr.MedicationID = m.id
                   WHERE a.DoctorID = ? AND a.status = 'Done'
                   GROUP BY p.id
                   ORDER BY p.firstName ASC";
$stmt = $connection->prepare($patientsQuery);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$patients = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Homepage</title>
    <link rel="stylesheet" href="newstyle2.css">
    <style>

.welcome {
    margin: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    animation: slideIn 0.8s ease-in-out;
}

.welcome h2 {
    font-family: 'Playfair Display', serif;
    color: #000;
}

.welcome a {
    text-decoration: none;
    color: #BAD8B6;
    font-weight: bold;
    transition: color 0.3s ease;
}

.welcome a:hover {
    text-decoration: underline;
    color: #2A7D84;
}

 

        .container {
    padding: 15px;
    width: 90%;
    max-width: 1200px;
    margin: auto;
    margin-top: -10px; 
    animation: fadeInUp 1s ease-in-out;
}

.section {
    background-color: #ffffff;
    border-radius: 8px; 
    padding: 15px; 
    margin-bottom: 20px; 
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}


.section:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.section h2 {
font-family: 'Playfair Display', serif;
font-size: 1.4em;
color: #333;
border-bottom: 2px solid #4DA1A9;
padding-bottom: 8px;
margin-bottom: 12px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    background-color: #fff;
    text-align: center;
}

table th, table td {
    border: 1px solid #e0e0e0;
    padding: 15px;
}

table th {
    background: linear-gradient(135deg, #4da1a9, #7cc7cb);
    color: white;
    text-transform: uppercase;
}

table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

table tbody tr:nth-child(even) {
    background-color: #fffef5;
}

table tbody tr:hover {
    background-color: #eef7fa;
    transition: background-color 0.3s ease;
}


/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}


    table {
        font-size: 0.9em;
    }

    .btn {
        padding: 10px 20px;
    }
  
        
    </style>
</head>
<body>
    <header>
        <div class="logo"><img src="logo.png" alt="Clinic Logo"></div>
        <nav>
            <a href="HomePage2.html">Home</a>
            <a href="logout.php">Sign Out</a>
        </nav>
    </header>
    
    <div class="welcome">
        <h2>Welcome, Dr. <?php echo htmlspecialchars($doctor['firstName'] . ' ' . $doctor['lastName']); ?></h2>
    </div>
    
    <div class="profile-card">
        <div class="profile-details">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['emailAddress']); ?></p>
            <p><strong>Speciality:</strong> <?php echo htmlspecialchars($doctor['speciality']); ?></p>
        </div>
    </div>

    <div class="container">
        <div class="section">
            <h2>Upcoming Appointments</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient's Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Reason for Visit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $appointments->fetch_assoc()) {
                        $dob = new DateTime($row['DoB']);
                        $age = $dob->diff(new DateTime())->y;
                        echo "<tr>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['time']) . "</td>
                            <td>" . htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) . "</td>
                            <td>" . $age . "</td>
                            <td>" . htmlspecialchars($row['Gender']) . "</td>
                            <td>" . htmlspecialchars($row['reason']) . "</td>
                            <td>";
                        if ($row['status'] == 'Pending') {
                            echo "<a href='confirm_appointment.php?id=" . $row['id'] . "'>Confirm</a>";
                        } elseif ($row['status'] == 'Confirmed') {
                            echo "<a href='prescribe.php?id=" . $row['id'] . "'>Prescribe</a>";
                        } else {
                            echo "Done";
                        }
                        echo "</td>
                        </tr>";
                    } ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Your Patients</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Medications</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $patients->fetch_assoc()) {
                        $dob = new DateTime($row['DoB']);
                        $age = $dob->diff(new DateTime())->y;
                        echo "<tr>
                            <td>" . htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) . "</td>
                            <td>" . $age . "</td>
                            <td>" . htmlspecialchars($row['Gender']) . "</td>
                            <td>" . ($row['medications'] ? htmlspecialchars($row['medications']) : 'None') . "</td>
                        </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php $connection->close(); ?>
