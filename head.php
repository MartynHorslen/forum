<?php
    //Start session before anything else runs.
    session_start();

    //Open DB connection as most pages are going to interact with the DB anyway.
    include 'connect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bootstrap Forum made in PHP & MySQL</title>
        <!--<meta name="description" content="">-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Site Structure -->
        <?php echo '<link rel="stylesheet" href="/css/structure.css">' ?>
        <!-- Style / Skin -->
        <link rel="stylesheet" href="/css/default.css">
    </head>
    <body class="quinary">
        
            