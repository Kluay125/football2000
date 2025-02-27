<?php
include '../conn/conn.php';
$id = $_POST['id'];
$txt0 = trim(htmlspecialchars($_POST['txt0']));
$txt1 = trim(htmlspecialchars($_POST['txt1']));
$txt2 = trim(htmlspecialchars($_POST['txt2']));
$txt3 = trim(htmlspecialchars($_POST['txt3']));
$txt4 = trim(htmlspecialchars($_POST['txt4']));
$txt5 = trim(htmlspecialchars($_POST['txt5']));
$txt6 = trim(htmlspecialchars($_POST['txt6']));
$txt7 = trim(htmlspecialchars($_POST['txt7']));
$txt8 = trim(htmlspecialchars($_POST['txt8']));

$filename = $_FILES['img']['name'];
$filetmp = $_FILES['img']['tmp_name'];
$filetype = $_FILES['img']['type'];
if ($filename !== '') {
    switch ($filetype) {
        case 'image/jpeg':
            $lastname = '.jpg';
            break;
        case 'image/png':
            $lastname = '.png';
            break;
        case 'image/gif':
            $lastname = '.gif';
            break;
    }
}

$date2 = date("Y-m-d H:i:s");

$path = './img_member';
if (!file_exists($path)) {
    mkdir($path, 0755, true);
}


if (($txt1 == '') or ($txt2 == '')) {
    $obj = array([
        'sts' => '0',
        'msg' => 'กรุณากรอกข้อมูลให้ครบ'
    ]);
    echo json_encode($obj);
    exit();
}
//------เพิ่ม-----------//
if ($id == '') {
    $sql = "SELECT id FROM tbl_member WHERE username ='$txt6'";
    $query  = $conn->query($sql);
    if ($query->num_rows > 0) {
        $obj = array([
            'sts' => '0',
            'msg' => 'ชื่อ' . $txt6 . 'ซ้ำกรุณากรอกใหม่อีกครั้ง!!'
        ]);
        echo json_encode($obj);
        exit();
    }
    if($txt7 !=$txt8){
        $obj = array([
            'sts' => '0',
            'msg' => 'รหัสผ่านไม่ตรงกัน'
        ]);
        echo json_encode($obj);
        exit();
    }

    $sql ="SELECT id FROM tbl_member ORDER BY id DESC";
    $query = $conn->query($sql);
    if($query->num_rows == 0){
        $uid = '1';
    }else{
        $rs = $query->fetch_assoc();
        $uid = ($rs['id']) + 1;
    }
    $code = sprintf('%04d',$uid);
    $u_uid = 'U'. date("Y") . date("m") . $code;

    if ($filename != '') {
        $files = $txt1 . $lastname;
        move_uploaded_file($filetmp, $path . '/' . $files);
    } else {
        $files = '';
    }
    $pass_has = hash('sha256', $txt7);
    $txt6 = $conn->real_escape_string($txt6);
    $txt0 = $conn->real_escape_string($txt0);

    $sql = "INSERT INTO `tbl_member` (`id`,`uid`,`permission`,`usname`,`nickname`,`phone`,`mail`,`address`,`img`,`username`,`password`) 
    VALUES (NULL,'$u_uid','$txt0', '$txt1', '$txt2', '$txt3', '$txt4', '$txt5', '$files' , '$txt6','$pass_has')";
    $query = $conn->query($sql);
    $obj = array([
        'sts' => '1',
        'msg' => 'บันทึกข้อมูลเรียบร้อยแล้ว'
    ]);
    echo json_encode($obj);
    exit();
}
//------เพิ่ม-----------//
//------แก้ไขข้อมูล-----------//
else {
    $sql = "SELECT id FROM tbl_member WHERE usname ='$txt1' AND id !='$id'";
    $query  = $conn->query($sql);
    if ($query->num_rows > 0) {
        $obj = array([
            'sts' => '0',
            'msg' => 'ชื่อประเภท' . $txt1 . 'ซ้ำกรุณากรอกใหม่อีกครั้ง!!'
        ]);
        echo json_encode($obj);
        exit();
    }

    $sql = "SELECT * FROM tbl_member WHERE id ='$id'";
    $query = $conn->query($sql);
    $rs = $query->fetch_assoc();

    if ($filename != '') {
        unlink($path . '/' . $rs['img']);
    }

    if ($filename != '') {
        $files = $txt1 . $lastname;
        move_uploaded_file($filetmp, $path . '/' . $files);
    } else {
        $files = '';
    }


    $sql = "UPDATE `tbl_member` 
    SET `permission` = '$txt0', `usname` = '$txt1', `nickname` = '$txt2',
     `phone` = '$txt3', `mail` = '$txt4',
      `address` = '$txt5', `img` = '$files', `username` = '$txt6',
       `password` = '$txt7' 
    WHERE `id` = '$id' ";

    $query = $conn->query($sql);
    $obj = array([
        'sts' => '1',
        'msg' => 'บันทึกข้อมูลเรียบร้อยแล้ว'
    ]);
    echo json_encode($obj);
    exit();
}

//------แก้ไขข้อมูล-----------//