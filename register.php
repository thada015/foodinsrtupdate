<!DOCTYPE html>
<html lang="th">
<head>
    <link rel="icon" type="image/jpg" href="favicon.jpg">
    <meta charset="UTF-8">
    <title>Register</title>

    <style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;

    /* พื้นหลังเขียวไล่เฉด */
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

/* กล่องฟอร์ม */
.box {
    width: 420px;
    background: #ffffff;
    padding: 45px 40px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    backdrop-filter: blur(5px);
    animation: fadeIn 0.6s ease;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #27ae60;
    font-weight: 600;
}

label {
    font-size: 14px;
    margin-bottom: 6px;
    display: block;
    color: #444;
}

.input-wrapper {
    position: relative;
    margin-bottom: 18px;
}

.left-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    opacity: 0.6;
}

input {
    width: 100%;
    padding: 13px 12px 13px 42px;
    border: 1px solid #dcdcdc;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

input:focus {
    border-color: #27ae60;
    box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
    outline: none;
}

input.has-eye {
    padding-right: 45px;
}

.eye {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    opacity: 0.6;
    cursor: pointer;
    transition: 0.2s;
}

.eye:hover {
    opacity: 1;
}

/* ปุ่ม */
button {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #27ae60, #2ecc71);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

/* ลิงก์ login */
.login-link {
    text-align: center;
    margin-top: 18px;
    font-size: 14px;
    color: #555;
}

.login-link a {
    color: #27ae60;
    text-decoration: none;
    font-weight: 600;
}

.login-link a:hover {
    text-decoration: underline;
}

/* Toast */
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 14px 20px;
    border-radius: 10px;
    font-size: 14px;
    color: #fff;
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.4s ease;
    z-index: 9999;
}

.toast.show {
    opacity: 1;
    transform: translateY(0);
}

.toast.success { 
    background: #27ae60; 
}

.toast.error { 
    background: #e74c3c; 
}

/* Modal */
.modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 99999;
}

.modal.show {
    display: flex;
}

.modal-box {
    background: #fff;
    padding: 35px 45px;
    border-radius: 18px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    animation: pop 0.3s ease;
}

.modal-box h3 {
    margin: 0 0 10px;
    color: #27ae60;
}

.modal-box p {
    font-size: 14px;
    color: #555;
}

@keyframes pop {
    from { transform: scale(0.8); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
    </style>
</head>

<body>

<div class="box">
    <h2>Register</h2>

    <form action="poseregister.php" method="post">

        <label>First Name</label>
        <div class="input-wrapper">
            <img class="left-icon" src="https://cdn-icons-png.flaticon.com/512/847/847969.png">
            <input type="text" name="firstname"placeholder="Enter your first name" required>
        </div>

        <label>Last Name</label>
        <div class="input-wrapper">
            <img class="left-icon" src="https://cdn-icons-png.flaticon.com/512/847/847969.png">
            <input type="text" name="lastname"placeholder="Enter your last name" required>
        </div>

        <label>Email</label>
        <div class="input-wrapper">
            <img class="left-icon" src="https://cdn-icons-png.flaticon.com/512/542/542689.png">
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <label>Phone Number</label>
        <div class="input-wrapper">
    <img class="left-icon" src="https://img.icons8.com/?size=100&id=9659&format=png&color=000000">
    <input type="text"
           name="phonenumber"
           placeholder="Enter your phone number"
           maxlength="15"
           required>
       </div>

        <label>Password</label>
        <div class="input-wrapper">
            <img class="left-icon" src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png">
            <input type="password" id="password" name="password1" class="has-eye"placeholder="Enter your password" required>
            <img class="eye" src="https://cdn-icons-png.flaticon.com/512/709/709612.png"
                 onclick="togglePassword('password', this)">
        </div>

        <label>Confirm Password</label>
        <div class="input-wrapper">
            <img class="left-icon" src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png">
            <input type="password" id="confirmPassword" name="password2" class="has-eye"placeholder="Confirm your password" required>
            <img class="eye" src="https://cdn-icons-png.flaticon.com/512/709/709612.png"
                 onclick="togglePassword('confirmPassword', this)">
        </div>

        <button type="submit">Create Account</button>

        <div class="login-link">
            Already have an account? <a href="login.php">Login</a>
        </div>

    </form>
</div>

<div id="toast" class="toast"></div>
<div id="successModal" class="modal">
    <div class="modal-box">
        <h3>✅ สมัครเสร็จสิ้น</h3>
        <p>กำลังพาไปหน้าเข้าสู่ระบบ...</p>
    </div>
</div>


<script>
function togglePassword(id, eye) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        eye.style.opacity = "1";
    } else {
        input.type = "password";
        eye.style.opacity = "0.6";
    }
}

function showToast(msg, type) {
    const toast = document.getElementById("toast");
    toast.className = "toast show " + type;
    toast.innerText = msg;
    setTimeout(() => toast.className = "toast", 3000);
}
</script>

<script>
<?php if (isset($_GET['error'])): ?>
    showToast("<?= htmlspecialchars($_GET['error']) ?>", "error");
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    showToast("<?= htmlspecialchars($_GET['success']) ?>", "success");
<?php endif; ?>
</script>

<script>
<?php if (isset($_GET['success'])): ?>
    const modal = document.getElementById("successModal");
    modal.classList.add("show");

    setTimeout(() => {
        window.location.href = "login.php";
    }, 2500);
<?php endif; ?>
</script>

</body>
</html>
