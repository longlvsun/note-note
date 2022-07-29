<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/login/guard.php';
// print json_encode($cur_user);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Document</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />
    <link rel="stylesheet" href="public/css/style.css" />
  </head>

  <body>
    <!-- Header -->
    <?php include "./inc/header.php"; ?>
    <!--Body container-->
    <div class="height-100 bg-light">
      <h4>Main Components</h4>
    </div>
    <!-- Footer -->
    <?php include "./inc/footer.php"; ?>
  </body>
  <script type="text/javascript" src="public/js/main.js"></script>
  <script
    type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
  ></script>
  <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
  ></script>
</html>
