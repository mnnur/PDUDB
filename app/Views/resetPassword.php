<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="/css/resetPassStyle.css" rel="stylesheet">
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
        <div class="reset-form">
            <form action="/resetpassword/reset" method="post">
                <h3>Reset Password</h3>
                <?=csrf_field()?>
                <div class="email-field">
                    <label for="resetPasswordEmail">Email</label><br>
                    <input type="email" placeholder="Email" name="resetPasswordEmail" id="resetPasswordEmail">
                    <button id="getCode" type="button">Get Code</button>
                </div>
                <label for="resetPasswordCode">Verification Code</label><br>
                <input type="text" placeholder="Verification Code" name="resetPasswordCode"><br>
                <label for="newPassword">New Password</label><br>
                <input type="password" placeholder="New Password" name="newPassword"><br>
                <label for="newPasswordConfirm">Confirm New Password</label><br>
                <input type="password" placeholder="Confirm New Password" name="newPasswordConfirm"><br>
                <button id="resetPasswordButton" type="submit">Reset Password</button>
            </form>
            <br>
            <span><?php echo session()->getFlashdata('forgotPassword_notice');?><span>
        </div>
    </div>
</body>
<script src="/js/resetPassword.js"></script>
</html>