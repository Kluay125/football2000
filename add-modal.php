<?php
include_once '../../conn/conn.php';
$t_id = '';
$txt1 = '';
$txt2 = '';
$img = '../imges/tsts1.png';
if (isset($_GET['t_id'])) {

  $header = 'แก้ไข';
  $t_id = $_GET['t_id'];
  $sql = "SELECT * FROM tbl_type WHERE t_id='$t_id'";
  $query = $conn->query($sql);
  $rs = $query->fetch_assoc();
  if ($rs['t_img'] != '') {
    $img = '../img_type/' . $rs['t_img'];
  } else {
    $img = '../imges/tsts1.png';
  }
  $txt1 = $rs['t_name'];
  $txt2 = $rs['t_date'];
} else {
  $header = 'เพิ่ม';
}

//    if(isset($_GET['t_id'])){
//      $header = 'แก้ไข';
//    }else {
//      $header = 'เพิ่ม';
//    }

?>



<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">
      <?= $header ?>ประเภทสินค้า
    </h5>
  </div>
  <form class="add-modal_type">
    <div class="modal-body">
      <div class=" text-center">
        <img src="<?= $img; ?>" class="rounded img-thumnail" id="preview" style="width: 150px;">
        <h5>
          <small class="text-white">รูปประเภทสินค้า</small>
        </h5>




        <div class="input-group flex-nowrap mb-2 mr-sm-2">
          <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-image"></i></span>
          <input type="file" name="t_img" class="form-control" id="file" placeholder="" onchange="previewFile()"
            accept="image/*">



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
        <input type="hidden" name="t_id" id="t_id" value="<?= $t_id; ?>">

        <label class="sr-only" for="inlineFormInputGroupUsername2">ชื่อเจ้า</label>
        <div class="input-group mb-2 mr-sm-2">

          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="fa-solid fa-store"></i>
            </div>
          </div>
          <input type="text" name="txt1" class="form-control" id="inlineFormInputGroupUsername2"
            placeholder="ชื่อประเถทสินค้า" value="<?= $txt1; ?>" />
        </div>
        <div class="input-group mb-2 mr-sm-2">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="fa-regular fa-clock"></i>
            </div>
          </div>
          <input type="date" name="txt2" class="form-control" id="inlineFormInputGroupUsername2"
            placeholder="วันที่สร้าง" value="<?= $txt2; ?>" />
        </div>
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
    });
    $('.add-modal_type').submit(function(e) {
      e.preventDefault();
      var data = new FormData($(this)[0]);
      $.post('./admin_add_type.php', data, function(res) {
        var obj = $.parseJSON(res);
        if (obj[0].sts == '0') {
          $('.close-btn').click();
          Swal.fire(obj[0].msg, '', 'warning');
        } else {
          $('.close-btn').click();
          Swal.fire(obj[0].msg, '', 'success').then(function() {
            window.location.href = './tbl_type.php';

          });
        }
      });
    });
  })
</script>