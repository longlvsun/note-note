<?php
namespace Ctrl;

require_once __DIR__ . '/../config/config.php';
use Ctrl;
use Conf;

class Home {
  static function login() {
    return Ctrl\User::login();
  }

  static function logout() {
    return Ctrl\User::logout();
  }

  static function register() {
    return Ctrl\User::register();
  }

  static function home() {
    global $cur_user;
    $cur_user = Ctrl\login_guard();
    return Ctrl\Note::home();
    // Conf\render_multiple(['header', 'main', 'footer']);
  }

}
?>
