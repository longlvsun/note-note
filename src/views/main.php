<?php
function get_time($date) {
  $date = strtotime($date);
  $day = date('d/m/y', $date);
  if ($date >= strtotime('today')) {
    $day = 'today';
  } else if ($date >= strtotime('yesterday')) {
    $day = 'yesterday';
  }

  return date('H:i:s', $date) . ' - ' . $day;
}
?>

<div class="container w-50 pt-1 pb-5">
  <div class="card shadow-lg bg-light mt-5">
    <h5 class="card-header">Tạo ghi chú</h5>
    <div class="card-body">
      <form class=" text-center border border-light p-2" method="post">
        <input type="text" name="title" class="form-control mb-4" placeholder="Tên ghi chú" required />
        <textarea name="content" class="form-control" placeholder="Nội dung" id="ContentTextarea" style="height: 100px"></textarea>

        <div class="d-flex justify-content-around">
          <div>
          </div>
        </div>
        <?php
        if (isset($err)) {
          print "<div class='text-danger mt-3' id='err-text'><i>*$err!!</i></div>";
          print "<script>setTimeout(() =>document.getElementById('err-text').remove(), 3000);</script>";
        }
        ?>
        <input class="btn btn-primary btn-block mt-4" type="submit" value="Tạo ghi chú" />

      </form>
    </div>
  </div>

</div>

<div class="row w-75 mx-auto pt-5 pb-5">
  <?php
  global $note;
  foreach (@$note as $e) {
    // echo json_encode($e);
    $created = get_time($e->get_created());
    $updated = get_time($e->get_updated());
    $ctn = strlen($e->content) > 250 ? substr($e->content, 0, 250) . '...' : $e->content;
    print "
  <div class='col-sm-4 h-100 pb-2'>
    <div class='card bg-light shadow-lg'>
      <div class='card-body'>
        <h5 class='card-title '><a href='/edit_note?id=$e->id'>$e->title</a></h5>
        <p class='card-text'>$ctn</p>
      </div>
      <div class='card-body row pt-2'>
        <form class='col-2' method='post'>
          <input type='hidden' name='id' value='$e->id'>
          <input
            class='btn btn-outline-danger btn-sm'
            type='submit' name='delete' value='Xóa'
          />
        </form>
        <form class='col-3' action='/edit_note'  method='get'>
          <input type='hidden' name='id' value='$e->id'>
          <input
            class='btn btn-outline-warning btn-sm'
            type='submit' value='Chỉnh sửa'
          />
        </form>
      </div>
      <div class='card-footer text-muted '>
        Created at $created, Last update at $updated
      </div>
    </div>
  </div>";
  }
  ?>
</div>

<a href="#" id="toTopBtn" class="cd-top text-replace js-cd-top cd-top--is-visible cd-top--fade-out" data-abc="true"></a>
