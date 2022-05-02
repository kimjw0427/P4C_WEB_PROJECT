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
}
?>
