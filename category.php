<?php
    echo 'debugging test';
    if (!$dbh){
        echo 'no connection.';
    }
    //first select the category based on $_GET['cat']
    $cat_id = $_GET['cat'];

    //prepare statement
    $sql = $dbh->prepare("SELECT cat_id, cat_name, cat_description FROM categories WHERE cat_id = :cat_id");

    //bind the paramaters
    $sql->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);

    //execute the prepared statement
    $sql->execute();
    $result = $sql->fetchAll();

    if($result->rowCount === 0){
        echo 'No categories defined yet.';
    } else {     
        // Loop through each category counting number of topics and getting the category ID
        foreach($result as $catRow) {
            echo '<div class="my-2 py-1 px-4"><h4>Category: ' . $catRow['cat_name'] . '</h4> ' . $catRow['cat_description'] . '</div>';
        }
    }


    


?>