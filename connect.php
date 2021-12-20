<?php
$server = 'localhost';
$username   = 'usernamehere';
$password   = 'passwordhere';
$database   = 'databasenamehere';

try {
    $dbh = new PDO('mysql:host=' + $server + ';dbname=' + $database, $username, $password, array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>