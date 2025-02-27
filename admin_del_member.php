<?php
require_once '../../conn/conn.php';
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
$sql = "SELECT * FROM tbl_member WHERE id = '$id'";
$query = $conn->query($sql);
$rs = $query->fetch_assoc();
if($rs['img'] !=''){
    $path = '../imges/noimg.jpg/' . $rs['img'];
    unlink($path);
}

$sql = "DELETE FROM tbl_member WHERE id = '$id'";
$query = $conn->query($sql);
?>