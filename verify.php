<?php
include_once("db.php");
if(isset($_GET['code']) and isset($_GET['username'])){

    $query = $db->prepare("SELECT * FROM verify WHERE code=? and username=?;");
    $query->bind_param("ss",$_GET['code'],$_GET['username']);
    $query->execute();
    $res = $query->get_result();
    $query->close();
    $data = $res->fetch_assoc();

    if($data['isverify'] == 0){
        $is_verify = 1;

        $query = $db->prepare("UPDATE verify SET isverify=? WHERE code=? and username=?;");
        $query->bind_param("iss",$is_verify,$_GET['code'],$_GET['username']);
        $query->execute();
        $query->close();

        echo('Success <script> document.location.href="/login.php";</script>');
    }

}
?>