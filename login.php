<?php
session_start();
require('myadd.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = mysqli_real_escape_string($connect, $_POST['emailuser']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM accountuser 
            WHERE email_account = '$email' 
            LIMIT 1";

    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password_account'])) {
            $_SESSION['id_account'] = $user['id_account'];
            $_SESSION['user_id']   = $user['id_account'];
            $_SESSION['username'] = $user['user_account'];
            $_SESSION['role']     = $user['role']; // ⭐ สำคัญ

            // แยก admin / user
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit();

        } else {
            $error = "รหัสผ่านไม่ถูกต้อง";
        }

    } else {
        $error = "ไม่พบผู้ใช้นี้ในระบบ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="icon" type="image/jpg" href="favicon.jpg">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
** { box-sizing: border-box; }

body { 
    margin: 0;
    height: 100vh;
    font-family: 'Segoe UI', sans-serif;

    /* พื้นหลังเขียวไล่เฉด + เบลอ */
    background: linear-gradient(rgba(255, 255, 255, 0.65)),
    
    background-size: cover;
    background-position: center;

    display: flex;
    justify-content: center;
    align-items: center;
}

/* กล่อง login */
.login-box {
    background: rgba(255,255,255,0.95);
    width: 380px;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    backdrop-filter: blur(8px);
    animation: fadeIn 0.6s ease;
}

.login-box h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #1b5e20;
    font-weight: 600;
}

/* input */
.form-group {
    width: 100%;
    position: relative;
    margin-bottom: 18px;
}

.form-group input {
    width: 100%;
    height: 48px;
    padding: 0 44px 0 46px;
    border: 1px solid #dcdcdc;
    border-radius: 10px;
    font-size: 14px;
    transition: 0.3s;
    
    box-sizing: border-box;   /* 🔥 สำคัญมาก */
}

.form-group input:focus {
    border-color: #2ecc71;
    box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.25);
    outline: none;
}

.left-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    opacity: 0.6;
}

.toggle-password {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #6c757d;
    cursor: pointer;
    transition: 0.2s;
}

.toggle-password:hover {
    color: #2ecc71;
}

/* forgot */
.forgot {
    text-align: right;
    font-size: 13px;
    margin-bottom: 15px;
}

.forgot a {
    color: #1b5e20;
    text-decoration: none;
}

.forgot a:hover {
    text-decoration: underline;
}

/* ปุ่ม login */
.btn-login {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #27ae60, #2ecc71);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

/* error */
.error {
    background: #ffe5e5;
    color: #c0392b;
    padding: 10px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 15px;
    text-align: center;
}

/* register */
.register {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
}

.register a {
    color: #1b5e20;
    font-weight: 600;
    text-decoration: none;
}

.register a:hover {
    text-decoration: underline;
}

/* animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if ($error != "") { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <div class="form-group">
            <input type="email" name="emailuser" placeholder="Email Address" required>
            <img src="https://cdn-icons-png.flaticon.com/512/542/542689.png" class="left-icon">
        </div>

        <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" class="left-icon">
            <i class="fa-regular fa-eye toggle-password" onclick="togglePassword()"></i>
        </div>

        <div class="forgot">
            <a href="#">Forgot Password?</a>
        </div>

        <button class="btn-login" type="submit">Sign in</button>

        <div class="register">
            Don't have an account? <a href="register.php">Register</a>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}
</script>





</body>

</html>