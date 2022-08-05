<?php
namespace Mid;

use Ctrl;
use Mod;

function get_from_browser() {
  @session_start();
  if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
  }

  if (isset($_COOKIE['remb'])) {
    [$id, $hash] = explode('|', $_COOKIE['remb']);
    if (hash('sha256', 'remb' . $id . 'remb') === $hash) {
      $_SESSION['uid'] = $id;
      $uid = $id;
    }
  }

  if (empty($uid)) return false;
  return Mod\User::load($uid);
}

function save_session($id, $remember = false) {
    @session_start();
    $_SESSION['uid'] = $id;
    if ($remember) {
      setcookie(
        'remb',
        $id . '|' . hash('sha256', 'remb' . $id . 'remb'),
        time() + 3600 * 24 * 30,
        '/'
      );
    }
}

function login_guard() {
  $cur_user = get_from_browser();

  if (!$cur_user) {
    Ctrl\User::logout();
    return false;
  }

  if (isset($_REQUEST['href'])) {
    header('Location: ' . $_REQUEST['href']);
  }

  if (preg_match('/\/login/i', $_SERVER['REQUEST_URI'])) {
    header('Location: /');
  }

  return $cur_user;
}

?>
