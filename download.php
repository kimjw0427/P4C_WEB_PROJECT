<?
include_once("db.php");
if(isset($_GET['id'])){

    $query = $db->prepare("SELECT * FROM file_db WHERE board_id=?;");
    $query->bind_param("i",$_GET['id']);
    $query->execute();
    $res = $query->get_result();
    $query->close();
    $data = $res->fetch_assoc();


    $file_name = $data['file_name'];                  
    $file_dir = "uploads/".$file_name;

    $download_name = substr($file_name,28,strlen($file_name));

    header('Content-Type: application/x-octetstream');
    header('Content-Length: '.filesize($file_dir));
    header('Content-Disposition: attachment; filename='.$download_name);
    header('Content-Transfer-Encoding: binary');

    $fp = fopen($file_dir, "r");
    fpassthru($fp);
    fclose($fp);

}
?>