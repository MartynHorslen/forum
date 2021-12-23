<?php
    try {
        //first select the category based on $_GET['cat_id']
        $cat_id = parseInt($_GET['cat']);

        //prepare statement
        $sql = $dbh->prepare("SELECT cat_id, cat_name, cat_description FROM categories WHERE cat_id = :cat_id");

        //bind the paramaters
        $sql->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);

        //execute the prepared statement
        $sql->execute();
        $result = $sql->fetchAll();
        print_r($result);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }


?>