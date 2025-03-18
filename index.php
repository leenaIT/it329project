<?php
  $host = "localhost";
    $database = "medora";
    $user = "root";
    $pass = "root";
    $port = "8889";
    
    // إنشاء اتصال بقاعدة البيانات
    $connection = mysqli_connect($host, $user, $pass, $database,$port);
   
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }else
header("Location: signup.php"); // أو أي صفحة رئيسية تريدها
exit();
?>


?>



