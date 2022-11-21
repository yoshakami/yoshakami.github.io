<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/login/ログインする.css">
    <meta charset="latin-1">
</head>
<body>
<form action="index.php" method="post">
    <h2>login</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <label class="display-name">Display Name</label>
    <input class="display-input" type="text" name="dname" placeholder="Display Name"><br>
    <label class="user-name">User Name</label>
    <input class="user-input" type="text" name="uname" placeholder="User Name">
    <p class="user-note">⬅ (only used to login)</p><br>
    <label class="password-name">Password</label>
    <input class="password-input" type="password" name="password" placeholder="Password"><br>
    <button class="submit-button" type="submit">Login</button>
</form>
</body>
<?php
if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data)
    {

        $data = trim($data);

        $data = stripslashes($data);

        $data = htmlspecialchars($data);

        return $data;

    }

    $uname = validate($_POST['uname']);

    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=Username");
        exit();

    } else if (empty($pass)) {
        header("Location: index.php?error=Password");
        exit();
    } else {
        $ufile = fopen()
    }
}