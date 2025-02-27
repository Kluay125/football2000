<?php
include_once '../../conn/conn.php';
$id = trim($_POST['id']);
$usname = trim(htmlspecialchars($_POST['$usname']));
$phone = trim(htmlspecialchars($_POST['$phone']));
$mail = trim(htmlspecialchars($_POST['$mail']));
$address = trim(htmlspecialchars($_POST['$address']));
$username = trim(htmlspecialchars($_POST['$username']));
$password1 = trim(htmlspecialchars($_POST['$password']));
$password2 = trim(htmlspecialchars($_POST['$password1']));
//----รูป----//
$filename = $_FILES['img']['name'];
$filetmp = $_FILES['img']['tmp_name'];
$filetype = $_FILES['img']['type'];
if($filename !==''){
    switch($filetype){
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
//----สร้างโฟเดอร์เก็บรูปภาพ----//
$path = '../img_member';
if(!file_exists($path)){
    mkdir($path,0755,true);
}

//----เพิ่มข้อมูล----//

if($id =='' ){

    if(($usname =='') or ($phone =='') or ($mail =='')or ($address =='') or ($username =='') or ($password =='') or ($password1 =='')){
        $obj = array([
            'sts' =>'0',
            'msg' =>'กรุณากรอกข้อมูลให้ครบ'
        ]);
        echo json_encode($obj);
        exit();
    }
}