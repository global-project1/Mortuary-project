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
        <h1>Sign in</h1>
        <input type="email" placeholder="Email" name="email" class="email" required><label><i class="fa-solid fa-envelope"></i></label>
        <input type="text" placeholder="Matricule" name="matricule" class="matricule" required><label class="label3"><i class="fa-solid fa-person"></i></label>
        <input type="password" placeholder="Password" name="password" class="password" required><label class="label4"><i class="fa-solid fa-eye"></i></label>

        <input type="submit" value="Login" name="login">
    </form>    

</body>
</html>