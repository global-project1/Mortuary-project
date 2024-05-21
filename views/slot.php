
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Slot</title>
    <link rel="stylesheet" href="assets/css/slot.css">
</head>
<body>
    
    <form action="" method="POST">

        <h2>Choose a Slot</h2>
        <div class="select-input">
            <label for="slot">Slot: </label>
            
            <select name="slot" id="slot" required>
                <?php
                    $free = $_SESSION['free_slots'];
                    for( $i = 0; $i < count($free); $i ++){
                        echo "<option value=".$free[$i][0].">".$free[$i][1]."</option>";
                    }
                ?>
            </select>
        </div> 

        <input type="submit" name="add_slot" value="Submit" id="submit">
    </form>
</body>
</html>