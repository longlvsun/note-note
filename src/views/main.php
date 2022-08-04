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
  foreach ($note as $e) {
    // echo json_encode($e);
    $newDate = date("d/m/Y", strtotime($e[2]));
    echo "<div class='col-sm-4 h-100 pb-2'>";
    echo "<div class='card bg-light shadow-lg'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title '>$e[5]</h5>";
    echo "<p class='card-text'>$e[4]</p>";
    echo "</div>";
    echo "<div class='card-body row pt-2'>";
    echo "<form class='col-2' method='post'>";
    echo "<input type='hidden' name='id' value='$e[0]'>";
    echo "<input class='btn btn-outline-danger btn-sm' type='submit' name='delete' value='Xóa'>";
    echo "</form>";
    echo "<form class='col-3' action='http://localhost:8080/edit_note'  method='get'>";
    echo "<input type='hidden' name='id' value='$e[0]'>";
    echo "<input class='btn btn-outline-warning btn-sm' type='submit' value='Chỉnh sửa'>";
    echo "</form>";
    echo "</div>";
    echo "<div class='card-footer text-muted '>";
    echo "Last update at " . "$newDate";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  ?>
</div>

<a href="#" id="toTopBtn" class="cd-top text-replace js-cd-top cd-top--is-visible cd-top--fade-out" data-abc="true"></a>


