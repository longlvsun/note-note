<?php
global $editedNote;
global $err;
?>

<div class="container w-50 pt-1 pb-5">
  <div class="card shadow-lg bg-light mt-5">
    <h5 class="card-header">Chỉnh sửa ghi chú</h5>
    <div class="card-body">
      <form class=" text-center border border-light p-2" method="post">
        <input
          type="text"
          name="title"
          class="form-control mb-4"
          placeholder="Tên ghi chú"
          value="<?= $editedNote->title ?>"
          required
        />
        <textarea
          name="content"
          class="form-control"
          placeholder="Nội dung"
          id="ContentTextarea"
          style="height: 55vh"
        ><?= $editedNote->content ?></textarea>
        <div class="d-flex justify-content-around"></div>
        <?php
        if (isset($err)) {
          print "<div class='text-danger mt-3' id='err-text'><i>*$err!!</i></div>";
          print "<script>setTimeout(() =>document.getElementById('err-text').remove(), 3000);</script>";
        }
        ?>
        <a class="btn btn-danger mt-4" href="/">Hủy</a>
        <input class="btn btn-primary btn-block mt-4" type="submit" value="Xác nhận" />
      </form>
      <div class='card-footer text-muted '>
        Created at <?= Conf\get_time($editedNote->get_created()) ?>, Last update at <?= Conf\get_time($editedNote->get_updated()) ?>
      </div>
    </div>
  </div>
</div>
