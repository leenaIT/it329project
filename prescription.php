<?php
session_start();
require 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); 
    exit();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id = intval($_POST['appointment_id']);
    $patient_id = intval($_POST['patient_id']);
    $medications = $_POST['medications'] ?? [];

    if (empty($medications)) {
        die("No medications selected.");
    }

    $update_query = "UPDATE appointment SET status = 'Done' WHERE id = ?";
    $stmt = $connection->prepare($update_query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $stmt->close();

    $insert_query = "INSERT INTO prescription (AppointmentID, MedicationID) VALUES (?, ?)";
    $stmt = $connection->prepare($insert_query);

    foreach ($medications as $med_id) {
        $stmt->bind_param("ii", $appointment_id, $med_id);
        $stmt->execute();
    }
    
    $stmt->close();
    $connection->close();

    header("Location: doctor_homepage.php");
    exit();
}
?>
