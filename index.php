<?php
    include 'head.php';
    include 'header.php';

    //Forum Bootstrap Body
    echo '<div class="row no-gutters align-items-center"><!-- open row -->
    <div class="col-sm-10 col-md-8 offset-sm-1 offset-md-2"> ';

    //Forum Navigation
    if (isset($_GET['view']) && $_GET['view'] == 'signin'){
        //don't include nav
    } else {
        include 'navigation.php';
    }

    //Forum page set by url view.
    if (!isset($_GET['view'])) {
        include 'overview.php';
        //echo 'Forum Overview';
    } else if ($_GET['view'] == "cat") {
        include 'category.php';
        //echo 'Forum Category view';
    } else if ($_GET['view'] == "topic"){
        include 'topic.php';
        //echo 'Forum Topic view';
    } else if ($_GET['view'] == "new"){
        include 'newposts.php';
        //echo 'Forum New Posts view';
    }  else if ($_GET['view'] == "create"){
        //include 'create.php';
        echo 'Create a new topic.';
    }  else if ($_GET['view'] == "signin"){
        include 'signin.php';
        //echo 'Sign in page';
    }  else {
        echo "Error";
    }

    //Closing Forum Bootstrap Body
    echo '</div></div>';

    include 'footer.php';
?>