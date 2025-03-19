<?php
session_start();




if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // إعادة التوجيه إذا لم يكن المستخدم مسجلًا
    exit();
}



if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // إعادة التوجيه إذا لم يكن المستخدم مسجلًا
    exit();
}


// التأكد من أن المستخدم مسجل الدخول كطبيب
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// التأكد من وجود معرف الموعد في الرابط
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid appointment ID.");
}

$appointment_id = intval($_GET['id']);

// الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$password = "root";
$database = "medora";

$connection = new mysqli($host, $user, $password, $database,8889);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// تحديث حالة الموعد إلى "Confirmed"
$updateQuery = "UPDATE appointment SET status = 'Confirmed' WHERE id = ? AND status = 'Pending'";
$stmt = $connection->prepare($updateQuery);
$stmt->bind_param("i", $appointment_id);

if ($stmt->execute()) {
    // إعادة التوجيه إلى صفحة الطبيب بعد التحديث
    header("Location: doctor_homepage.php");
    exit();
} else {
    echo "Error updating appointment status: " . $connection->error;
}

$stmt->close();
$connection->close();
?>
