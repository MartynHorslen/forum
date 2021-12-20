<?php
    include 'head.php';
    include 'header.php';

    //Forum Bootstrap Body
    echo '<div class="row no-gutters align-items-center"><!-- open row -->
    <div class="col-sm-10 col-md-8 offset-sm-1 offset-md-2"> ';

    //Forum Navigation


    //Forum page set by url view.
    if (!isset($_GET['view'])) {
        include 'overview.php';
        //echo 'Forum Overview';
    } else if ($_GET['view'] == "cat") {
        //include 'category.php';
        echo 'Forum Category view';
    } else if ($_GET['view'] == "topic"){
        //include 'topic.php';
        echo 'Forum Topic view';
    } else if ($_GET['view'] == "new"){
        //include 'new.php';
        echo 'Forum New Posts view';
    }  else if ($_GET['view'] == "create"){
        //include 'create.php';
        echo 'Create a new topic.';
    } else {
        echo "Error";
    }

    //Closing Forum Bootstrap Body
    echo '</div></div>';

    include 'footer.php';
?>