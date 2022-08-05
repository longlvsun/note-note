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
    return Ctrl\Note::home();
  }

}
?>
