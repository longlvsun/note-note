<?php
namespace Ctrl;

require_once __DIR__ . '/../models/user.model.php';

use Exception;
use Mid;
use Mod;
use Conf;

class User {
  static function logout() {
    @session_start();
    @session_destroy();
    @setcookie('remb', '', time() - 3600, '/');
    Conf\to_login();
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
        Mid\save_session($user->id, $remember);
        header('Location: /');
      } catch(Exception $except) {
        $err = $except;
      }
    }

  render_login:
    global $cur_user;
    $cur_user = Mid\login_guard();
    Conf\render('login');
  }

  static function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      global $err;

      if (empty($_POST['username'])) {
        $err = 'missing username field';
        goto render_register;
      }

      $username = $_POST['username'];

      if (empty($_POST['password'])) {
        $err = 'missing password field';
        goto render_register;
      }

      $password = $_POST['password'];

      if (empty($_POST['cfpassword'])) {
        $err = 'missing confirm password field';
        goto render_register;
      }

      $cfpassword = $_POST['cfpassword'];
      $remember = isset($_POST['remember']);

      $user = Mod\User::_find('username', $username);

      if ($user) {
        $err = 'username existed';
        goto render_register;
      }

      if ($password != $cfpassword) {
        $err = 'confirm password not matched';
        goto render_register;
      }

      try {
        $user = Mod\User::new($username, $password);
        Mid\save_session($user->id, $remember);
        header('Location: /');
      } catch(Exception $except) {
        $err = $except;
      }
    }

  render_register:
    Conf\render('register');
  }
}
?>
