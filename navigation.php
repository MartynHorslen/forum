<div class="card mb-2 px-3 py-2">
    <div class="row">
        <div class="col-12 col-sm-6">
            <a class="btn btn-primary btn-sm m-1" href="index.php">Home</a>
            <a class="btn btn-primary btn-sm m-1" href="index.php?view=new">New Posts</a>

            <?php 
            //Add link to create topic if user is signed in and on the 'category' page
            if (isset($_SESSION['signed_in']) && isset($_GET['view']) && $_GET['view'] == "cat"){
                echo '<a class="btn btn-primary btn-sm m-1" href="index.php?view=create&cat=' . $_GET['cat'] . '">Create a Topic</a>';
            }
            ?>
        </div>

        <div class="col-12 col-sm-6 text-right mt-2">
            <?php
            //Add welcome text and signout link if user is signed in or 'sign in' and 'create account' links if not.
            if(isset($_SESSION['signed_in']))
            {
                echo 'Hello ' . $_SESSION['user_name'] . '. <a href="../signout.php">Sign Out</a>';
            }
            else
            {
                if (!isset($_GET['view']) || $_GET['view'] === 'signin'){
                    //don't set 'previous'
                    echo '<a href="index.php?view=signin">Sign in</a> or <a href="index.php?view=register">create an account</a>.';
                } else if ($_GET['view'] === 'topic'){
                    //set 'previous' to topic view and topic number
                    echo '<a href="index.php?view=signin&previous=topic&topic=' . $_GET['topic'] . '">Sign in</a> or <a href="index.php?view=register&previous=topic&topic=' . $_GET['topic'] . '">create an account</a>.';
                } else if ($_GET['view'] === 'cat'){
                    //set 'previous' to topic view and topic number
                    echo '<a href="index.php?view=signin&previous=cat&cat=' . $_GET['cat'] . '">Sign in</a> or <a href="index.php?view=register&previous=cat&cat=' . $_GET['cat'] . '">create an account</a>.';
                } else {
                    //set 'previous' to current view
                    echo '<a href="index.php?view=signin&previous=' . $_GET['view'] . '">Sign in</a> or <a href="index.php?view=register&previous=' . $_GET['view'] . '">create an account</a>.';
                }
            }
            ?>
        </div>
    </div>
</div>