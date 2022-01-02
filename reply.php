<?php
    //include database connection module
    include 'connect.php';

    $date = date("Y-m-d H:i:s");

    //prepare to insert
    $sql = $dbh->prepare("INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES (:content, :post_date, :topic, :userid)");
    $sql->bindParam(':content', $_POST['replyContent'],PDO::PARAM_STR);
    $sql->bindParam(':post_date', $date);
    $sql->bindParam(':topic', $_POST['topicId'],PDO::PARAM_INT);
    $sql->bindParam(':userid', $_POST['userId'],PDO::PARAM_INT);

    $sql->execute();
?>