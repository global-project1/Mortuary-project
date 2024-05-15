<?php
    $db = new SQLite3($_SESSION['root_dir'] . '/config/mortuary_db.sqlite');

    if(!$db)
        die("Error Opening database");
    
    return $db

?>