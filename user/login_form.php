<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="modern-container">
    <div class="modern-card">

        <h2>User Login</h2>

        <form action="register_insert.php" method="POST">

            <label>Enter Username</label>
            <input type="text" name="username">

            <label>Enter Password</label>
            <input type="password" name="password">

            <input type="submit" name="login" value="Log In">
        </form>

        <button onclick="document.location='register.php'" class="bbut">Create New Account</button>

    </div>
</div>

</body>
</html>
