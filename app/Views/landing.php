<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="/css/landingStyle.css" rel="stylesheet">
</head>
<body>
<div class="navbar">
        <div class="logo">
            <a href="/">PDUDB</a>
        </div>
        <div class="space">
            <!-- Space -->
        </div>
    </div>
    <div class="main-layout">
        <div class="welcome-message">
            <span>Selamat Datang di Website PDUDB,</span><br>
            <span>Crew Produktif</span>
        </div>
        <div class="login-form" id="loginForm">
            <h3>Login</h3>
            <form action="/login" method="post">
                <?=csrf_field()?>
                <label for="loginEmail">Email</label><br>
                <input type="email" name="loginEmail" placeholder="email"><br>
                <label for="loginPassword">Password</label><br>
                <input type="password" name="loginPassword" placeholder="password"><br>
                <button type="submit">Login</button>
                <a href="/resetpassword">Forgot Password?</a><br>
                <span>Belum Punya akun?</span><br>
                <button type="button" id="showRegister" class="no-account">Buat Akun</button>
                <span><?php echo session()->getFlashdata('register_notice');?><span>
                <span><?php echo session()->getFlashdata('error_login');?><span>
                <span><?php echo session()->getFlashdata('forgotPassword_notice');?><span>
            </form>
        </div>
        <div class="register-form" id="registerForm">
            <h3>Register</h3>
            <form action="/register" method="post">
                <?=csrf_field()?>
                <label for="registerUsername">Username</label><br>
                <input type="username" name="registerUsername" placeholder="Username"><br>
                <label for="registerEmail">Email</label><br>
                <input type="email" name="registerEmail" placeholder="Email"><br>
                <label for="registerPassword">Password</label><br>
                <input type="password" name="registerPassword" placeholder="Password"><br>
                <label for="registerPasswordConfirm">Confirm Password</label><br>
                <input type="password" name="registerPasswordConfirm" placeholder="Confirm Password"><br>
                <button type="submit" id="registerButton">Register</button><br>
                <span>Sudah Punya akun?</span><br>
                <button type="button" id="showLogin" class="no-account">Login</button>
            </form>
        </div>
    </div>
</body>
<script src="/js/landing.js"></script>
</html>