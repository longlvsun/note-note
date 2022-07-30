<?php
require_once __DIR__ . '/controllers/home.controller.php';
require_once __DIR__ . '/controllers/user.controller.php';
require_once __DIR__ . '/controllers/note.controller.php';

$cur_user = Ctrl\User::guard();
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
  if (preg_match('/call to undefined function/i', $err)) {
    print $err;
  }
}
?>
