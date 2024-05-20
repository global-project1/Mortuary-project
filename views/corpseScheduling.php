<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corpse Scheduling</title>

    <link rel="stylesheet" href="assets/css/corpseScheduling.css">
    <!-- link to font icons -->
    <link rel="stylesheet" href="assets/font/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
    
    <form method="post">
        <h1>Corpse removal Scheduling</h1>

        <?php
            if(isset($_SESSION['req_error'])){
                echo "<p class='error_msg'> {$_SESSION['req_error']}</p>";
                unset($_SESSION['req_error']);
            }
        ?>

        <input type="text" placeholder="name" required name="name">
        <input type="text" placeholder="email" required name="email">
        <input type="date" placeholder="Date of removal" required name="DOR">
        <input type="text" placeholder="Enter Corpse ID" required name="corpseId">
        <input type="submit" value="submit" name="scheduling">
    </form>
</body>
</html>