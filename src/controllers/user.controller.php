<?php
namespace Ctrl;

require_once __DIR__ . '/../models/user.model.php';

use Exception;
use Mod;
use Conf;

function to_login() {
  if (!preg_match('/\/login/i', $_SERVER['REQUEST_URI'])) {
    header('Location: /login');
  }
}

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
    User::logout();
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

class User {
  static function logout() {
    @session_start();
    @session_destroy();
    @setcookie('remb', '', time() - 3600, '/');
    to_login();
  }

  static function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      global $err;

      if (empty($_POST['username'])) {
        $err = 'missing username field';
        goto render_login;
      }

      $username = $_POST['username'];

      if (empty($_POST['password'])) {
        $err = 'missing password field';
        goto render_login;
      }

      $password = $_POST['password'];
      $remember = isset($_POST['remember']);

      $user = Mod\User::_find('username', $username);

      if (!$user || !$user->verify($password)) {
        $err = 'username or password not matched';
        goto render_login;
      }

      try {
        save_session($user->id, $remember);
        header('Location: /');
      } catch(Exception $except) {
        $err = $except;
      }
    }

  render_login:
    global $cur_user;
    $cur_user = login_guard();
    Conf\render('login');
  }
}
?>
