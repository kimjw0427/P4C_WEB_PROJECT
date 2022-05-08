<?php
$db_host = "127.0.0.1";
$db_id = "admin";
$db_ps = "admin1234";
$db_name = "WEB";

$db = new mysqli($db_host, $db_id, $db_ps, $db_name);
if ($db->connect_error){
    echo('<script>alert("can\'t connect DB");</script>');
} else {
    $sql_query = "
    CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(20) NOT NULL,
        `email` varchar(50) NOT NULL,
        `password` varchar(20) NOT NULL,
        PRIMARY KEY (`id`)
    );";

    if($db->query($sql_query) == FALSE){
        echo('<script>alert("ERROR: can\'t create table");</script>');
        echo($db->error);
    }

    $sql_query = "
    CREATE TABLE IF NOT EXISTS `board` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(20) NOT NULL,
        `title` varchar(150) not null,
        `content` text not null,
        `date` datetime not null,
        `view` int unsigned not null default 0,
        `recm` int unsigned not null default 0,
        PRIMARY KEY (`id`)
    );";

    if($db->query($sql_query) == FALSE){
        echo('<script>alert("ERROR: can\'t create board");</script>');
        echo($db->error);
    }

    $sql_query = "
    CREATE TABLE IF NOT EXISTS `file_db` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `board_id` int unsigned,
        `file_name` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
    );";

    if($db->query($sql_query) == FALSE){
        echo('<script>alert("ERROR: can\'t create file_db");</script>');
        echo($db->error);
    }

    $sql_query = "
    CREATE TABLE IF NOT EXISTS `view_limit` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `ip` varchar(20) NOT NULL,
        `board_id` int unsigned,
        `date` datetime not null,
        PRIMARY KEY (`id`)
    );";

    if($db->query($sql_query) == FALSE){
        echo('<script>alert("ERROR: can\'t create view_limit");</script>');
        echo($db->error);
    }

    $sql_query = "
    CREATE TABLE IF NOT EXISTS `recm_limit` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `board_id` int unsigned,
        PRIMARY KEY (`id`)
    );";

    if($db->query($sql_query) == FALSE){
        echo('<script>alert("ERROR: can\'t create recm_limit");</script>');
        echo($db->error);
    }

    $sql_query = "
    CREATE TABLE IF NOT EXISTS `comment` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(20) NOT NULL,
        `content` text not null,
        `user_id` int(11) NOT NULL,
        `board_id` int unsigned,
        PRIMARY KEY (`id`)
    );";

    if($db->query($sql_query) == FALSE){
        echo('<script>alert("ERROR: can\'t create comment");</script>');
        echo($db->error);
    }

    $sql_query = "
    CREATE TABLE IF NOT EXISTS `verify` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(20) NOT NULL,
        `email` varchar(50) NOT NULL,
        `code` varchar(100) NOT NULL,
        `isverify` int unsigned,
        PRIMARY KEY (`id`)
    );";

    if($db->query($sql_query) == FALSE){
        echo('<script>alert("ERROR: can\'t create verify");</script>');
        echo($db->error);
    }
}
?>
