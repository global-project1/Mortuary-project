<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="assets/css/login.css">
    <!-- link to font icons -->
    <link rel="stylesheet" href="assets/font/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
    <form method="post">
        <h1>Sign In</h1>
        <?php
            if(isset($_SESSION['login_error'])){
                echo "<p class='error_msg'> {$_SESSION['login_error']}</p>";
                unset($_SESSION['login_error']);
            }
        ?>
        <div class="input-sect">
            <input type="text" placeholder="Name" name="name" class="name" required>
            <label>
                <i class="fa-solid fa-user"></i>
            </label>
        </div>

        <div class="input-sect">
            <input type="email" placeholder="Email" name="email" class="email" required>
            <label>
                <i class="fa-solid fa-envelope"></i>
            </label>
        </div>

        <div class="input-sect">
            <input type="text" placeholder="Matricule" name="matricule" class="matricule" required>
            <label>
                <i class="fa-solid fa-person"></i>
            </label>
        </div>

        <div class="input-sect">
            <input type="password" placeholder="Password" name="password" class="password" required>
            <label>
                <i class="fa-solid fa-eye"></i>
            </label>
        </div>

        <input type="submit" value="Login" name="login">
    </form>    

</body>
</html>