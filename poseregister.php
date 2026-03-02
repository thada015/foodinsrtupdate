<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('myadd.php');

if (
    !isset(
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['email'],
        $_POST['phonenumber'],
        $_POST['password1'],
        $_POST['password2']
    )
) {
    header("Location: register.php?error=กรุณากรอกข้อมูลให้ครบ");
    exit();
}

$firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
$lastname  = mysqli_real_escape_string($connect, $_POST['lastname']);
$email     = mysqli_real_escape_string($connect, $_POST['email']);
$phone     = mysqli_real_escape_string($connect, $_POST['phonenumber']);
$pass1     = $_POST['password1'];
$pass2     = $_POST['password2'];

if ($pass1 !== $pass2) {
    header("Location: register.php?error=รหัสผ่านไม่ตรงกัน");
    exit();
}

/* เช็คอีเมลซ้ำ */
$check_email = mysqli_query(
    $connect,
    "SELECT id_account FROM accountuser WHERE email_account='$email'"
);

if (mysqli_num_rows($check_email) > 0) {
    header("Location: register.php?error=อีเมลนี้ถูกใช้แล้ว");
    exit();
}

/* เช็คเบอร์ซ้ำ */
$check_phone = mysqli_query(
    $connect,
    "SELECT id_account FROM accountuser WHERE phonenumber='$phone'"
);

if (mysqli_num_rows($check_phone) > 0) {
    header("Location: register.php?error=เบอร์โทรนี้ถูกใช้แล้ว");
    exit();
}

$hash = password_hash($pass1, PASSWORD_DEFAULT);
$username = $firstname . ' ' . $lastname;

/* ✅ INSERT ต้องมี phonenumber */
$sql = "INSERT INTO accountuser
(user_account, email_account, phonenumber, password_account)
VALUES
('$username', '$email', '$phone', '$hash')";

if (!mysqli_query($connect, $sql)) {
    die("SQL Error: " . mysqli_error($connect));
}

/* สมัครสำเร็จ */
header("Location: register.php?success=สมัครสมาชิกสำเร็จ");
exit();

ob_end_flush();
