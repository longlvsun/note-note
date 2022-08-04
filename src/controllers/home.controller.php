<?php
namespace Ctrl;

use Ctrl;

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

  static function edit_note() {
    return Ctrl\Note::edit_note();
  }

  static function home() {
    global $cur_user;
    $cur_user = Ctrl\login_guard();
    return Ctrl\Note::home();
    // Conf\render_multiple(['header', 'main', 'footer']);
  }

}
?>
