<?php
    function fetchAllData($query){
        include 'connect.php';
        $result = $dbh->prepare($query);
        $result->execute();
        $result = $result->fetchAll();
        return $result;
    }
?>