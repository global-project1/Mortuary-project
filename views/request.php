<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corpse Scheduling</title>

    <link rel="stylesheet" href="assets/css/request.css">
    <!-- link to font icons -->
    <link rel="stylesheet" href="assets/font/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
    
    <form method="post">
        <h2>Corpse removal</h2>
        <?php
            if(isset($_SESSION['req_error'])){
                echo "<p class='error_msg'> {$_SESSION['req_error']}</p>";
                unset($_SESSION['req_error']);
            }
        ?>

        <div class="input-section">
            <label for="corpseId">Corpse ID</label>
            <input type="text" required name="corpseId" id="corpseId">

        </div>
        <div class="input-section">
            <label for="name">Remover Name</label>
            <input type="text" required name="name" id="name">

        </div>
        <div class="input-section">
            <label for="email">Email</label>
            <input type="text" required name="email" id="email">

        </div>
        <div class="input-section">
            <label for="date">Date to remove</label>
            <input type="date" required name="date" id="date">

        </div>

        <input type="submit" value="submit" name="scheduling">
    </form>
</body>
</html>