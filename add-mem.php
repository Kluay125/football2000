<?php
include_once '../../conn/conn.php';
$id = '';
$txt1 = '';
$txt2 = '';
$txt3 = '';
$img = '../imges/img1.jpg';
if (isset($_GET['id'])) {
    $header = 'แก้ไข';
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_member WHERE id='$id'";
    $query = $conn->query($sql);
    $rs = $query->fetch_assoc();
    if ($rs['img'] != '') {
        $img = './img_member/' . $rs['img'];
    } else {
        $img = '../imges/img1.jpg';
    } 
    $txt1 = $rs['usname'];
    $txt2 = $rs['phone'];
    $txt3 = $rs['address'];
    $txt4 = $rs['username'];
} else {
    $header = 'เพิ่ม';
}

?>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $header ?>สมาชิก</h5>
    </div>

    <form class="add-modal_type">
        <div class="modal-body">
            <input type="hidden" name="id" id="id" value="<?= $id; ?>">
            <div class=" text-center">
                <img src="<?= $img; ?>" class="rounded img-thumnail" id="preview" style="width: 150px;">
                <h5>
                    <small>รูปสมาชิก</small>
                </h5>
                <div class="input-group flex-nowrap mb-1">
                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-card-image"></i></span>
                    <input type="file" name="img" id="file" class="form-control" placeholder="Username" onchange="previewFile()" accept="image/*">
                </div>
                <script>
                    function previewFile() {
                        var preview = document.querySelector('img#preview');
                        var file = document.querySelector('input[type=file]').files[0];
                        var reader = new FileReader();
                        reader.onloadend = function() {
                            preview.src = reader.result;
                        }
                        if (file) {
                            reader.readAsDataURL(file);
                        } else {
                            preview.src = "<?= $img; ?>";
                        }
                    }
                </script>
            </div>
        <div class="input-group flex-nowrap mb-2 mr-sm-2">
          <span class="input-group-text" id="addon-wrapping"> <i class="fa-solid fa-user"></i></span>
          <input type="text" name="txt1" class="form-control" id="inlineFormInputGroupUsername2 " placeholder="ชื่อ-นามสกุล"  value="<?= $txt1; ?>">
        </div>
        <div class="input-group flex-nowrap mb-2 mr-sm-2">
          <span class="input-group-text" id="addon-wrapping"> <i class="fa-solid fa-user"></i></span>
          <input type="text" name="txt2" class="form-control" id="inlineFormInputGroupUsername2 " placeholder="ปีที่ได้บัลลงดอร์"  value="<?= $txt1; ?>">
        </div>
        <div class="input-group flex-nowrap mb-2 mr-sm-2">
          <span class="input-group-text" id="addon-wrapping"> <i class="fa-solid fa-user"></i></span>
          <input type="text" name="txt3" class="form-control" id="inlineFormInputGroupUsername2 " placeholder="ประเทศ"  value="<?= $txt2; ?>">
        </div>
        <div class="input-group flex-nowrap mb-2 mr-sm-2">
          <span class="input-group-text" id="addon-wrapping"> <i class="fa-solid fa-phone"></i></span>
          <input type="text" name="txt4" class="form-control" id="inlineFormInputGroupUsername2 " placeholder="ประวัติ"  value="<?= $txt3; ?>"/>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
            <button type="button" class="close-btn btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
        </div>
    </form>
</div>
<script>
    $(function() {
        $.ajaxSetup({
            cache: false,
            processData: false,
            contentType: false
        })

        $('.add-modal_type').submit(function(e) {
            e.preventDefault();
            var data = new FormData($(this)[0]);
            $.post('./admin_add_member.php', data, function(res) {
                var obj = $.parseJSON(res);
                if (obj[0].sts == '0') {
                    $('.close-btn').click();
                    Swal.fire(obj[0].msg, '', 'warning');
                } else {
                    $('.close-btn').click();
                    Swal.fire(obj[0].msg, '', 'success').then(function() {
                        window.location.href = './tbl_mem.php';
                    });
                }
            });
        });
    })
</script>