<?php
namespace Ctrl;

require_once __DIR__ . '/../models/user.model.php';

use Exception;
use Mod;

class User {
  static function to_login() {
    if ($_SERVER['REQUEST_URI'] !== '/login') {
      header('Location: /login');
    }
  }

  static function get_from_browser() {
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

  static function save($id, $remember = false) {
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

  static function logout() {
    @session_start();
    @session_destroy();
    @setcookie('remb', '', time() - 3600, '/');
    self::to_login();
  }

  static function guard() {
    $cur_user = self::get_from_browser();

    if (!$cur_user) {
      self::logout();
      return false;
    }

    if (isset($_REQUEST['href'])) {
      header('Location: ' . $_REQUEST['href']);
    }

    if ($_SERVER['REQUEST_URI'] === '/login') {
      header('Location: /');
    }

    return $cur_user;
  }

  static function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
        self::save($user->id, $remember);
        header('Location: /');
      } catch(Exception $except) {
        $err = $except;
        goto render_login;
      }

      exit();
    }

  render_login:
    $cur_user = self::guard();
    error_log(json_encode($cur_user));

    ob_start();
    include_once __DIR__ . '/../views/login.php';
    $content = ob_get_clean();

    include_once __DIR__ . '/../views/layout.php';
  }
}
?>
