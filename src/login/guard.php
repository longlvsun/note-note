<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] .'/config.php';

function to_login() {
  if ($_SERVER['REQUEST_URI'] !== '/login/') {
    header('Location: /login/');
  }
  exit();
}

function get_uid() {
  if (isset($_SESSION['uid'])) {
    return $_SESSION['uid'];
  }

  if (isset($_COOKIE['remb'])) {
    [$id, $hash] = explode('|', $_COOKIE['remb']);
    if (hash('sha256', 'remb' . $id . 'remb') === $hash) {
      $_SESSION['uid'] = $id;
      return $id;
    }
  }

  return false;
}

$uid = get_uid();

if ($uid === false) {
  to_login();
}

$uid = mysqli_real_escape_string($dbconn, $uid);
$res = mysqli_query($dbconn, "select * from users where id = $uid");
$res = $res->fetch_assoc();

if (!$res) {
  session_destroy();
  to_login();
}

$cur_user = $res;

if (isset($_REQUEST['href'])) {
  header('Location: ' . $_REQUEST['href']);
  exit();
}

if ($_SERVER['REQUEST_URI'] === '/login/') {
  header('Location: /');
  exit();
}
?>
