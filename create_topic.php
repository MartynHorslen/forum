<?php
    include 'connect.php';

    $date = date("Y-m-d H:i:s");

    $dbh->beginTransaction();

    $sql = $dbh->prepare("INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by) VALUES(:topic_subject, :topic_date, :topic_cat, :userid)");

    $sql->bindParam(':topic_subject', $_POST['topicSubject'], PDO::PARAM_STR);
    $sql->bindParam(':topic_date', $date);
    $sql->bindParam(':topic_cat', $_POST['topicCat'], PDO::PARAM_INT);
    $sql->bindParam(':userid', $_POST['userId'], PDO::PARAM_INT);

    if($sql->execute())
    {
        //continue.
        $insertId = $dbh->lastInsertId();

        $sql2 = $dbh->prepare("INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES(:post_content, :post_date, :post_topic, :userid)");

        $sql2->bindParam(':post_content', $_POST['postContent']);
        $sql2->bindParam(':post_date', $date);
        $sql2->bindParam(':post_topic', $insertId, PDO::PARAM_INT);
        $sql2->bindParam(':userid', $_POST['userId'], PDO::PARAM_INT);

        if($sql2->execute()){
            $dbh->commit();
            echo $insertId;
        } else {
            //Damn! the query failed, quit
            $dbh->rollback();
            echo 'second';
        }
    }
    else
    {
        //Damn! the query failed, quit
        $dbh->rollback();
        echo 'first';
    }
?>