<?php
    function fetchAllData($query, $dbh){
        $result = $dbh->prepare($query);
        $result->execute();
        $result = $result->fetchAll();
        return $result;
    }
?>