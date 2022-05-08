<?php
    include_once("db.php");
    session_start();

    if(isset($_SESSION['user'])){
        $id = $_SESSION['user'];
        $query = $db->prepare("SELECT username FROM users WHERE id=?;");
        $query->bind_param("i",$id);
        $query->execute();
        $res = $query->get_result();
        $query->close();

        $data = $res->fetch_assoc();
        $session_user = $data['username'];
    }
    if(isset($session_user)){
        if(isset($_GET['id'])){
            $board_id = $_GET['id'];
            $user_id = $_SESSION['user'];

            $query = $db->prepare("SELECT id FROM recm_limit WHERE user_id=? and board_id=?;");
            $query->bind_param("ii",$user_id,$board_id);
            $query->execute();
            $res = $query->get_result();
            $query->close();
            $data = $res->fetch_assoc();

            if(!isset($data['id'])){

                $query = $db->prepare("SELECT recm FROM board WHERE id=?;");
                $query->bind_param("i",$board_id);
                $query->execute();
                $res = $query->get_result();
                $query->close();
            
                $data = $res->fetch_assoc();
                $p_recm = $data['recm'] + 1;

                $query = $db->prepare("UPDATE board SET recm=? WHERE id=?;");
                $query->bind_param("ii",$p_recm,$board_id);
                $query->execute();
                $query->close();

                $query = $db->prepare("INSERT INTO recm_limit(user_id,board_id) VALUES(?,?);");
                $query->bind_param("ii",$user_id,$board_id);
                $query->execute();
                $query->close();

                echo('<script>document.location.href="/board.php?id='.$_GET['id'].'";</script>');
            } else {
                echo('<script>alert("You already recommanded!"); document.location.href="/board.php?id='.$_GET['id'].'";</script>');
            }
        }
    } else{
        echo('<script>alert("You must login!"); document.location.href="/board.php?id='.$_GET['id'].'";</script>');
    }
?>