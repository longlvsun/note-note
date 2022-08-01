<?php
require_once __DIR__ . '/controllers/index.php';

// $cur_user = Ctrl\login_guard();
// print json_encode($cur_user);

$ctrl = isset($_GET['ctrl']) ? $_GET['ctrl'] : 'home';
$act = isset($_GET['act']) ? $_GET['act'] : 'home';

$ctrl = ucfirst($ctrl);
// print $ctrl . '/' . $act;

try {
  "Ctrl\\$ctrl::$act"();
} catch(Exception $err) {
  print $err;
} catch(Error $err) {
  if (preg_match("/undefined.*$ctrl::$act/i", $err)) {
    header('Location: /');
  }
  print $err;
}
?>
